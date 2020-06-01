<?php

namespace App\Http\Controllers;

use App\Dictionaries\UserMessagesDictionary;
use App\Events\NewsApprovedEvent;
use App\News;
use App\Validators\UserRoleValidatorTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    use UserRoleValidatorTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        return view('news.index', ['news' => $user->getNewsByStatus($request->get('status'))]);
    }

    public function create()
    {
        $this->abortUnlessUserHasPermission();

        return view('news.create');
    }

    public function store(Request $request)
    {
        $this->validateFormRequest($request);

        News::createNewsByRequest($request);

        return redirect()->route('news.create')
            ->with('success', UserMessagesDictionary::NEWS_CREATED);
    }

    public function show(News $news)
    {
        $this->abortIfUserIsNotOwnerOfNewsAndNotManager($news);

        return view('news.show', compact('news'));
    }

    public function edit(News $news)
    {
        $this->abortIfUserIsNotOwnerOfNewsAndNotManager($news);

        return view('news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $this->abortIfUserIsNotOwnerOfNewsAndNotManager($news);
        $this->validateFormRequest($request);

        $news->updateNewsByRequest($request);

        return redirect()->route('news.show', $news->id)
            ->with('success', UserMessagesDictionary::NEWS_UPDATED);
    }

    public function destroy(News $news)
    {
        $this->abortIfUserIsNotOwnerOfNewsAndNotManager($news);

        $news->delete();

        return redirect()->route('news.index')->with('success', UserMessagesDictionary::NEWS_DELETED);
    }

    public function approve(Request $request, News $news)
    {
        $this->abortUnlessUserIsManager();

        $news->approve();

        event(new NewsApprovedEvent($news));

        return redirect()->route('news.show', $news->id)
            ->with('success', UserMessagesDictionary::NEWS_APPROVED);
    }

    public function decline(Request $request, News $news)
    {
        $this->abortUnlessUserIsManager();

        $rejectedMaterialLog = RejectedMaterialLog::createRejectedMaterialLog($material);

        $material->delete();

        event(new MaterialRejectedEvent($rejectedMaterialLog));


        return redirect()->route('materials.index')
            ->with('success', UserMessagesDictionary::MATERIAL_REJECTED);
    }


    private function abortIfUserIsNotOwnerOfNewsAndNotManager(News $news): void
    {
        $currentLoggedInUser = auth()->user();

        if (!$currentLoggedInUser->isManager() && $news->createdBy->isNot($currentLoggedInUser)) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }

    private function validateFormRequest(Request $request): void
    {
        $this->validate($request, [
            'title' => ['required', 'max:255'],
            'image' => ['image']
        ]);
    }
}
