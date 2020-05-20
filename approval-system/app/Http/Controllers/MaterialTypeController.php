<?php

namespace App\Http\Controllers;

use App\MaterialType;
use Illuminate\Http\Request;

class MaterialTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('store');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MaterialType  $materialType
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialType $materialType)
    {
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaterialType  $materialType
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialType $materialType)
    {
        dd('edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaterialType  $materialType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialType $materialType)
    {
        dd('');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaterialType  $materialType
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialType $materialType)
    {
        dd('destroy');
    }
}
