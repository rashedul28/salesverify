<?php

namespace App\Http\Controllers;

use App\Models\c;
use App\Models\File;
use App\Models\Offer;
use App\Models\OfferSource;
use App\Models\Sale;
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
        $sales = Sale::all();
        return view('salesmandashboard', compact('sales'));
         
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $offerSources = OfferSource::all();

        // offers with source_id
        $offers = Offer::select('id', 'name', 'offer_source_id')->get();

        return view('salesman.sales', compact('offerSources', 'offers'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
             $request->validate([
        'offer_source_id' => 'required|exists:offer_sources,id',
        'offer_id'        => 'required|exists:offers,id',
    ]);

    $offerSource = OfferSource::find($request->offer_source_id);
    $offer       = Offer::find($request->offer_id);

    // safety check
    if ($offer->offer_source_id != $offerSource->id) {
        return back()->withErrors(['offer_id' => 'Offer mismatch']);
    }

    Sale::create([
        'offer_source_id'   => $offerSource->id,
        'offer_source_name' => $offerSource->name, 
        'offer_id'          => $offer->id,
        'offer_name'        => $offer->name,        
        'source_id'         => auth()->user()->source_id,
    ]);

    return back()->with('success', 'Sale saved');
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
