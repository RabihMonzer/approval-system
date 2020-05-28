<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Dictionaries\UserMessagesDictionary;
use App\DTO\Material\MaterialDTO;
use App\DTO\RejectedMaterialLog\RejectedMaterialLogDTO;
use App\DTO\ResponseData;
use App\DTO\ResponsePaginationData;
use App\DTOFactory\Material\MaterialDTOCollection;
use App\Events\MaterialApprovedEvent;
use App\Events\MaterialRejectedEvent;
use App\Material;
use App\MaterialType;
use App\RejectedMaterialLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

    public function store(Request $request)
    {
        $this->validateFormRequest($request);

        $materialType = MaterialType::getMaterialType($request->materialType);

        if (!$materialType instanceof MaterialType) {
            $materialType = MaterialType::createMaterialType($request->materialType);
        }

        $material = Material::createNewMaterialByRequest($request, $materialType);

        return new ResponseData([
            'data' => MaterialDTO::fromModel($material),
        ]);
    }

    public function show(Material $material)
    {
        $this->abortIfUserIsNotOwnerOfMaterialAndNotManager($material);

        return new ResponseData([
            'data' => MaterialDTO::fromModel($material),
        ]);
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

        return new ResponseData([
            'data' => MaterialDTO::fromModel($material),
        ]);
    }

    public function destroy(Material $material)
    {
        $this->abortIfUserIsNotOwnerOfMaterialAndNotManager($material);

        $material->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }

    public function approve(Request $request, Material $material)
    {
        $this->abortUnlessUserIsManager();

        $material->approve();

        event(new MaterialApprovedEvent($material));

        return new ResponseData([
            'data' => MaterialDTO::fromModel($material),
        ]);
    }

    public function decline(Request $request, Material $material)
    {
        $this->abortUnlessUserIsManager();

        $rejectedMaterialLog = RejectedMaterialLog::createRejectedMaterialLog($material);

        $material->delete();

        event(new MaterialRejectedEvent($rejectedMaterialLog));

        return new ResponseData([
            'data' => RejectedMaterialLogDTO::fromModel($rejectedMaterialLog),
        ]);
    }

    private function abortIfUserIsNotOwnerOfMaterialAndNotManager(Material $material): void
    {
        $currentLoggedInUser = auth()->user();

        if (!$currentLoggedInUser->isManager() && $material->user->isNot($currentLoggedInUser)) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }

    private function validateFormRequest(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getValidationRules());

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
    }

    private function getValidationRules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'content' => ['required'],
            'materialType' => ['required', 'max:255']
        ];
    }

    private function abortUnlessUserIsManager(): void
    {
        if (!auth()->user()->isManager()) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }
}
