<?php

namespace App\Http\Controllers;

use App\Models\C;
use App\Models\File;
use App\Models\Offer;
use App\Models\OfferSource;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $offerSource = OfferSource::all();
        return view('admin.createoffers', compact('offerSource'));
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

    public function report(Request $request)
    {
        return view('admin.report');

    }

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


    public function generateSalesFileMatchTable()
    {
        $rows = DB::table('sales')
            ->join('files', function ($join) {
                $join->on('sales.source_id', '=', 'files.source_id')
                    ->on('sales.offer_source_name', '=', 'files.offer_source')
                    ->on('sales.offer_name', '=', 'files.offer_name');
            })
            ->select(
                'sales.source_id',
                'sales.offer_source_name',
                'sales.offer_name',
                DB::raw('COUNT(sales.id) as sales_count')
            )
            ->groupBy(
                'sales.source_id',
                'sales.offer_source_name',
                'sales.offer_name'
            )
            ->get();

        foreach ($rows as $row) {
            DB::table('sales_file_matches')->updateOrInsert(
                [
                    'source_id'         => $row->source_id,
                    'offer_source_name' => $row->offer_source_name,
                    'offer_name'        => $row->offer_name,
                ],
                [
                    'sales_count' => $row->sales_count,
                    'updated_at'  => now(),
                    'created_at'  => now(),
                ]
            );
        }

        return back()->with('success', 'Sales count with date generated successfully');
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

        return view('admin.report', compact('matches'));
    }
}
