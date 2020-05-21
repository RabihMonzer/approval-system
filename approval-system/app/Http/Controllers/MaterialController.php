<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Dictionaries\MaterialStatusDictionary;
use App\Dictionaries\UserMessagesDictionary;
use App\Material;
use App\MaterialType;
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

    public function create()
    {
        $availableMaterialTypes = MaterialType::all();
        return view('materials.create', compact('availableMaterialTypes'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'max:255'],
            'content' => ['required'],
            'materialType' => ['required', 'max:255']
        ]);

        $materialType = MaterialType::getMaterialType($request->materialType);

        if (!$materialType instanceof MaterialType) {
            $materialType = MaterialType::createMaterialType($request->materialType);
        }

        Material::createNewMaterialByRequest($request, $materialType);

        return redirect()->route('materials.create');
    }

    public function show(Material $material)
    {
        return view('materials.show', ['material' => $material, 'availableMaterialTypes' => MaterialType::all()]);
    }

    public function edit(Material $material)
    {
        return view('materials.edit', compact($material));
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
