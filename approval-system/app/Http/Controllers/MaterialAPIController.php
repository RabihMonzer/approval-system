<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\Material\MaterialDTO;
use App\DTO\ResponseData;
use App\DTO\ResponsePaginationData;
use App\DTOFactory\Material\MaterialDTOCollection;
use App\Material;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class MaterialAPIController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $materials = auth()->user()->getMaterials($request->get('status'));

        return new ResponsePaginationData([
            'collection' => MaterialDTOCollection::fromCollection($materials),
        ]);
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
