<?php

namespace App\Http\Controllers;

use App\Models\C;
use App\Models\File;
use App\Models\Offer;
use App\Models\OfferSource;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Laravel\Pail\Files;

class adminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return 
    }


    public function AdminDashboard()
    {
         $offers = Offer::with('source')->get();
            return view('admindashboard', compact('offers'));
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


    public function generateSalesFileMatchTable(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $start = $request->start_date;
        $end = $request->end_date;

        // Get grouped sales data for the date range (combinations of source_id, offer_source_name, offer_name)
        $salesGroups = Sale::whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->groupBy('source_id', 'offer_source_name', 'offer_name')
            ->select(
                'source_id',
                'offer_source_name as offers_source',
                'offer_name',
                DB::raw('count(*) as sales')
            )
            ->get();

        // In generateSalesFileMatchTable()
        $fileGroups = File::whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->groupBy('source_id', 'offer_source', 'offer_name')  // ← Change 'offer' to 'offer_name'
            ->select(
                'source_id',
                'offer_source as offers_source',
                'offer_name',  // ← No alias needed if already named correctly
                DB::raw('count(*) as target')
            )
            ->get()
            ->keyBy(function ($item) {
                return $item->source_id . '|' . strtolower(trim($item->offers_source)) . '|' . strtolower(trim($item->offer_name));
            });

            // dd($fileGroups, $salesGroups);

        // Build the report array (only include rows where there is a matching combination in sales)
        $report = [];
        foreach ($salesGroups as $index => $sale) {
            $compositeKey = $sale->source_id . '|' . strtolower(trim($sale->offers_source)) . '|' . strtolower(trim($sale->offer_name));
            $target = $fileGroups->has($compositeKey) ? $fileGroups[$compositeKey]->target : 0;
            $verify = ($sale->sales === $target) ? 'yes' : 'no';

            $report[] = [
                'no' => $index + 1,
                'source_id' => $sale->source_id,
                'offers_source' => $sale->offers_source,
                'offer_name' => $sale->offer_name,
                'sales' => $sale->sales,
                'target' => $target,
                'verify' => $verify,
                'date' => $start . ' to ' . $end,
            ];
        }

        

        return view('admin.report', compact('report'));
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
