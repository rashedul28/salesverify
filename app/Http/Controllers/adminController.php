<?php

namespace App\Http\Controllers;

use App\Models\C;
use App\Models\File;
use App\Models\Offer;
use App\Models\OfferSource;
use App\Models\Sale;
use App\Models\SourceId;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class adminController extends Controller
{

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
         $u = User::with('sourceIds')
                    ->whereNotIn('role', ['admin'])
                    ->get();

        return view('users', compact('u'));
    }

    public function storeAssignedSource(Request $request, $id)
    {
        $request->validate([
            'source_ids' => 'nullable|string',   // can be empty
        ]);

        // Get the submitted string → "4, 5,7, 9" → clean → [4,5,7,9]
        $input = $request->input('source_ids', '');
        $submittedIds = array_filter(
            array_map('trim', explode(',', $input)),
            fn($v) => is_numeric($v) && $v > 0
        );

        $submittedIds = array_unique(array_map('intval', $submittedIds));

        // Find user (you may want to restrict to non-admins)
        $user = User::where('role', '!=', 'admin')->findOrFail($id);

        // Get current source_ids for this user (as array of integers)
        $currentIds = $user->sourceIds()->pluck('source_id')->toArray();

        // ── 1. IDs to ADD (in submitted but not in current)
        $toAdd = array_diff($submittedIds, $currentIds);

        // ── 2. IDs to REMOVE (in current but not in submitted)
        $toRemove = array_diff($currentIds, $submittedIds);

        

        DB::transaction(function () use ($user, $toAdd, $toRemove) {

            // Delete removed ones
            if (!empty($toRemove)) {
                $user->sourceIds()
                    ->whereIn('source_id', $toRemove)
                    ->delete();
            }

            // Insert new ones
            if (!empty($toAdd)) {
                $records = array_map(function ($sourceId) use ($user) {
                    return [
                        'user_id'     => $user->id,
                        'source_id'   => $sourceId,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ];
                }, $toAdd);

                SourceId::insert($records);
            }
        });

        return redirect()
            ->route('users.index')           // or wherever your users list is
            ->with('success', 'Source IDs updated successfully.');
    }

    

    public function PassKey($id, $id2)
    {
        // Fetch the offer by its ID
        $offer = Offer::findOrFail($id);

        // Fetch all offer sources for the dropdown
        $offerSources = OfferSource::findOrFail($id2);

        // dd($offer->name ,$offerSources->name);

        return view('admin.editOffer', compact('offer', 'offerSources'));
    }

    public function EditOffer(Request $request)
    {
        $request->validate([
            'offer_id' => 'required|integer|exists:offers,id',
            'offer_source_id' => 'required|integer|exists:offer_sources,id',
            'offer_source_name' => 'required|string|max:255',
            'offer_name' => 'required|string|max:255',
        ]);

        // Find the offer by its ID
        $offer = Offer::findOrFail($request->input('offer_id'));
        $offerSource = OfferSource::findOrFail($request->input('offer_source_id'));

        // Update the offer details
        $offer->name = $request->input('offer_name');
        $offerSource->name = $request->input('offer_source_name');
        $offerSource->save();
        $offer->save();

        // Redirect back to the offers list with a success message
        return redirect()->route('admin.create')->with('success', 'Offer updated successfully.');
    }

    public function DeleteOffer($id, $id2)
    {
        // Find the offer by its ID
        $offer = Offer::findOrFail($id2);

        $offerSource = OfferSource::findOrFail($id);

        // Delete the offer
        $offer->delete();
        $offerSource->delete();

        // Redirect back to the offers list with a success message
        return redirect()->route('admin.create')->with('success', 'Offer deleted successfully.');
    }


    // public function AdminDashboard()
    // {
    //      $offers = Offer::with('source')->get();
    //      $users = User::all();
    //         return view('admindashboard', compact('offers', 'users'));
    // }   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $offerSource = OfferSource::all();
        $offers = Offer::with('source')->get();
        return view('admin.createoffers', compact('offerSource', 'offers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Create an OfferSource when the first form is submitted
        if ($request->has('offers_source')) {
            $request->validate([
                'offers_source' => 'required|string|max:255',
            ]);

            OfferSource::create([
                'name' => $request->input('offers_source'),
            ]);

            return redirect()->route('admin.create')->with('success', 'Offer source created.');
        }

        // Create an Offer when the second form is submitted
        if ($request->has('offer_names')) {
            $request->validate([
                'offer_names' => 'required|string|max:255',
                'source_id' => 'required|integer|exists:offer_sources,id',
            ]);

            Offer::create([
                'name' => $request->input('offer_names'),
                'offer_source_id' => $request->input('source_id'),
            ]);

            return redirect()->route('admin.create')->with('success', 'Offer created.');
        }

        // If reached directly, redirect back to create page with sources loaded
        return redirect()->route('admin.create');
    }

    // public function report(Request $request)
    // {
    //     return view('admin.report');

    // }

    /**
     * Display the specified resource.
     */
    public function show(C $c)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(C $c)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, C $c)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(C $c)
    {
        //
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent deletion of admin users
        if ($user->role === 'admin') {
            return redirect()
                ->route('users.index')
                ->with('error', 'Cannot delete admin users.');
        }

        $usersourceid = SourceId::where('user_id', $user->id);
        $usersourceid->delete();

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function files()
    {
        $files = File::all();
        return view('admin.files', ['files' => $files]);
    }


    public function fileUpload(Request $request)
    {

        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $rows = array_map('str_getcsv', file($path));

        // get header row
        $header = array_map('trim', array_shift($rows));

        foreach ($rows as $row) {
            if (count($row) < count($header)) {
                continue;
            }

            $data = array_combine($header, $row);

            // required fields check
            if (
                empty($data['Date & Time']) ||
                empty($data['Offer Source'])
            ) {
                continue;
            }

            File::create([
                'date_time'    => Carbon::parse($data['Date & Time'])->format('Y-m-d H:i:s'),
                'offer_source' => $data['Offer Source'],
                'offer_name'   => $data['Offer'],
                'country'      => $data['Country'],
                'source_id'    => $data['Source ID'],
                'referrer'     => $data['Referrer'],
            ]);

            }
            $files = File::all();
            return redirect()
                ->route('admin.files')
                ->with('success', 'CSV uploaded');
    }


public function generateSalesFileMatchTable(Request $request)
{
    $request->flash();

    $users = User::orderBy('name')->pluck('name');

    $data = collect();
    $selectedUser = $request->username;
    $startDate = Carbon::parse($request->start_date)->startOfDay();
    $endDate = Carbon::parse($request->end_date)->endOfDay();

    if ($request->filled(['start_date','end_date'])) {

        $query = DB::table('sales as s')
            ->leftJoin('files as f', function ($join) use ($startDate, $endDate) {
                $join->on('s.offer_source_name', '=', 'f.offer_source')
                     ->on('s.offer_name', '=', 'f.offer_name')
                     ->on('s.source_id', '=', 'f.source_id')
                     ->whereBetween('f.date_time', [$startDate, $endDate]);
            })
            ->join('users as u', 's.user_id', '=', 'u.id')
            ->whereBetween('s.created_at', [$startDate, $endDate]);

        // J If username selected → filter
        if (!empty($selectedUser)) {
            $query->where('u.name', $selectedUser);
        }

        $data = $query
            ->groupBy(
                'u.name',
                's.source_id',
                's.offer_source_name',
                's.offer_name'
            )
            ->select(
                'u.name as username',
                's.source_id',
                's.offer_source_name',
                's.offer_name',
                DB::raw('COUNT(DISTINCT s.id) as total_sales'),
                DB::raw('COUNT(DISTINCT f.id) as target')
            )
            ->get();

        foreach ($data as $row) {
            $row->matched = ($row->total_sales == $row->target) ? 'Yes' : 'No';
        }
    }

    $saleuser = Sale::select('user_id')->distinct()->with('user')->get();

    return view('admindashboard', compact(
        'data',
        'users',
        'selectedUser',
        'startDate',
        'endDate',
        'saleuser'
    ));
}



    public function showSalesFileMatches()
    {
        $matches = DB::table('sales_file_matches')
            ->select([
                'source_id',
                'offer_source_name',
                'offer_name',
                'sales_count',
                'updated_at',
            ])
            ->orderBy('source_id')
            ->orderBy('offer_source_name')
            ->orderBy('offer_name')
            ->get()
            ->map(function ($row) {
            $row->updated_at = Carbon::parse($row->updated_at);
            return $row;
            });

            // dd($users);
            
            $saleuser = Sale::select('user_id')->distinct()->with('user')->get();

            // dd($saleuser);

            

            

        return view('admindashboard', compact('matches', 'saleuser'));
    }
}
