<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\Material\MaterialDTO;
use App\DTO\ResponseData;
use App\Material;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaterialAPIController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // in progress
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function show(Material $material)
    {
        $this->abortIfUserIsNotOwnerOfMaterialAndNotManager($material);

        return new ResponseData([
            'data' => MaterialDTO::fromModel($material),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        //
    }

    private function abortIfUserIsNotOwnerOfMaterialAndNotManager(Material $material): void
    {
        $currentLoggedInUser = auth()->user();

        if (!$currentLoggedInUser->isManager() && $material->user->isNot($currentLoggedInUser)) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }
}
