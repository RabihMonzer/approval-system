<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Material;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class MaterialController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $user = auth()->user();

        if (!$user instanceof User) {
            return redirect('login');
        }

        return view('materials.index', ['materials' => $user->getMaterials()]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('store');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        dd('edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        dd('update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        dd('destroy');
    }
}
