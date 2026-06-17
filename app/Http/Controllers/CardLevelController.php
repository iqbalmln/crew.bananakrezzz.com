<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storecard_levelRequest;
use App\Http\Requests\Updatecard_levelRequest;
use App\Models\card_level;

class CardLevelController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storecard_levelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(card_level $card_level)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(card_level $card_level)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatecard_levelRequest $request, card_level $card_level)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(card_level $card_level)
    {
        //
    }
}
