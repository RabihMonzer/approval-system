<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Dictionaries\UserMessagesDictionary;
use App\Events\MaterialApprovedEvent;
use App\Events\MaterialRejectedEvent;
use App\Material;
use App\MaterialType;
use App\RejectedMaterialLog;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        return view('materials.index', ['materials' => $user->getNewsByStatus($request->get('status'))]);
    }

    public function create()
    {
        $availableMaterialTypes = MaterialType::all();

        return view('materials.create', compact('availableMaterialTypes'));
    }

    public function store(Request $request)
    {
        $this->validateFormRequest($request);

        $materialType = MaterialType::getMaterialType($request->materialType);

        if (!$materialType instanceof MaterialType) {
            $materialType = MaterialType::createMaterialType($request->materialType);
        }

        Material::createNewMaterialByRequest($request, $materialType);

        return redirect()->route('materials.create')
            ->with('success', UserMessagesDictionary::MATERIAL_CREATED);
    }

    public function show(Material $material)
    {
        $this->abortIfUserIsNotOwnerOfMaterialAndNotManager($material);

        return view('materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        $this->abortIfUserIsNotOwnerOfMaterialAndNotManager($material);

        return view('materials.edit', ['material' => $material, 'availableMaterialTypes' => MaterialType::all()]);
    }

    public function update(Request $request, Material $material)
    {
        $this->abortIfUserIsNotOwnerOfMaterialAndNotManager($material);
        $this->validateFormRequest($request);

        $materialType = MaterialType::getMaterialType($request->materialType);

        if (!$materialType instanceof MaterialType) {
            $materialType = MaterialType::createMaterialType($request->materialType);
        }

        $material->updateMaterialByRequest($request, $materialType);

        return redirect()->route('materials.show', $material->id)
            ->with('success', UserMessagesDictionary::MATERIAL_UPDATED);
    }

    public function destroy(Material $material)
    {
        $this->abortIfUserIsNotOwnerOfMaterialAndNotManager($material);

        $material->delete();

        return redirect()->route('materials.index')->with('success', UserMessagesDictionary::MATERIAL_DELETED);
    }

    public function approve(Request $request, Material $material)
    {
        $this->abortUnlessUserIsManager();

        $material->approve();

        event(new MaterialApprovedEvent($material));

        return redirect()->route('materials.show', $material->id)
            ->with('success', UserMessagesDictionary::MATERIAL_APPROVED);
    }

    public function decline(Request $request, Material $material)
    {
        $this->abortUnlessUserIsManager();

        $rejectedMaterialLog = RejectedMaterialLog::createRejectedMaterialLog($material);

        $material->delete();

        event(new MaterialRejectedEvent($rejectedMaterialLog));


        return redirect()->route('materials.index')
            ->with('success', UserMessagesDictionary::MATERIAL_REJECTED);
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateFormRequest(Request $request): void
    {
        $this->validate($request, [
            'title' => ['required', 'max:255'],
            'content' => ['required'],
            'materialType' => ['required', 'max:255']
        ]);
    }

    private function abortUnlessUserIsManager(): void
    {
        if (!auth()->user()->isManager()) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }

    private function abortIfUserIsNotOwnerOfMaterialAndNotManager(Material $material): void
    {
        $currentLoggedInUser = auth()->user();

        if (!$currentLoggedInUser->isManager() && $material->user->isNot($currentLoggedInUser)) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }
}
