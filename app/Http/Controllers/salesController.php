<?php

namespace App\Http\Controllers;

use App\Models\c;
use App\Models\File;
use App\Models\Offer;
use App\Models\OfferSource;
use App\Models\Sale;
use App\Models\SourceId;
use Illuminate\Http\Request;

class salesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function SalesDashboard()
    {
        $sales = Sale::where('user_id', auth()->id())->get();

        $sources = SourceId::where('user_id', auth()->id())->get();

        $offerSources = OfferSource::all();

        // offers with source_id
        $offers = Offer::select('id', 'name', 'offer_source_id')->get();

        // dd($sources->source_id);

        if(auth()->user()->role == 'salesman') {
            return view('salesmandashboard', compact('sales', 'offerSources', 'offers', 'sources'));
        } else {
            return back()->withErrors(['Unauthorized' => 'You do not have access to this page.']);
        }
         
    }
    

    /**
     * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     $offerSources = OfferSource::all();

    //     // offers with source_id
    //     $offers = Offer::select('id', 'name', 'offer_source_id')->get();

    //     return view('salesman.sales', compact('offerSources', 'offers'));
        
    // }







    /**
     * Store a newly created resource in storage.
     */
    public function SaveSales(Request $request)
    {

            // \Log::info('Received sales data', $request->all());
            // dd($request->all());
    
            //  $request->validate([
            //     'offer_source_id' => 'required|exists:offer_sources,id',
            //     'offer_id'        => 'required|exists:offers,id',
            //     'source_id'       => 'required|exists:source_ids,id',
            //     'sales_date'      => 'required|date|before_or_equal:today',
            //     ]);

            

            $offerSource = OfferSource::find($request->offer_source_id);
            $offer       = Offer::find($request->offer_id);

            // dd($offerSource, $offer);

            // \Log::info('Validated offer source and offer', [
            //     'offer_source_id' => $offerSource->id,
            //     'offer_id'        => $offer->id,
            // ]);

            // safety check
            if ($offer->offer_source_id != $offerSource->id) {
                dd('Offer source and offer mismatch');
                return back()->withErrors(['offer_id' => 'Offer mismatch']);
                
            }

            foreach (range(1, $request->count) as $i) {
                Sale::create([
                    'user_id'           => auth()->id(),
                    'offer_source_id'   => $offerSource->id,
                    'offer_source_name' => $offerSource->name, 
                    'offer_id'          => $offer->id,
                    'offer_name'        => $offer->name,        
                    'source_id'         => $request->source_id,
                    'created_at'        => $request->sales_date,
                ]);
            }

            // dd($sale);

            // \Log::info('Sale created successfully', ['id' => $sale->id, 'user_id' => auth()->id()]);
            

            return redirect()->route('dashboard2')->with('success', 'Sale recorded successfully.');
    }


    public function SearchSales(Request $request)
    {
        $sales = Sale::query();

        if ($request->filled(['start_date', 'end_date'])) {
            $sales->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $sales = $sales->orderBy('created_at', 'desc')->get();

        // $sales = Sale::where('user_id', auth()->id())->get();

        $sources = SourceId::where('user_id', auth()->id())->get();

        $offerSources = OfferSource::all();

        // offers with source_id
        $offers = Offer::select('id', 'name', 'offer_source_id')->get();

        return view('salesmandashboard', compact('sales', 'offerSources', 'offers', 'sources'));
    }





    /**
     * Display the specified resource.
     */
    public function show(c $c)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(c $c)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, c $c)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(c $c)
    {
        //
    }
}
