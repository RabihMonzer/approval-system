<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Dictionaries\MaterialStatusDictionary;
use App\Dictionaries\UserMessagesDictionary;
use App\Material;
use App\RejectedMaterialLog;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $user = auth()->user();

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

    public function show(Material $material)
    {
        return view('materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        return \view('materials.edit', compact($material));
    }

    public function update(Request $request, Material $material)
    {
        dd('update123');
    }

    public function destroy(Material $material)
    {
        $rejectedMaterialLog = RejectedMaterialLog::createRejectedMaterialLog($material);
        $rejectedMaterialLog->save();

        $material->delete();

        return redirect()->route('materials.index')->with('message', UserMessagesDictionary::MATERIAL_DELETED);
    }

    public function approve(Request $request, Material $material)
    {
        $material->approve();

        return redirect()->route('materials.show', $material->id);
    }

    public function decline(Request $request, Material $material)
    {
        RejectedMaterialLog::createRejectedMaterialLog($material);

        $material->delete();

        return redirect()->route('materials.index');
    }
}
