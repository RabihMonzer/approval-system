<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Dictionaries\UserMessagesDictionary;
use App\Events\NewsApprovedEvent;
use App\Events\NewsRejectedEvent;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\News;
use App\RejectedNewsLog;
use App\Validators\UserRoleValidatorTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NewsController extends Controller
{
    use UserRoleValidatorTrait;

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(News::class, 'news');
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

    public function store(StoreNewsRequest $request)
    {
        News::createNewsByRequest($request);

        return redirect()->route('news.create')
            ->with('success', UserMessagesDictionary::NEWS_CREATED);
    }

    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    public function update(UpdateNewsRequest $request, News $news)
    {
        $news->updateNewsByRequest($request);

        return redirect()->route('news.show', $news->id)
            ->with('success', UserMessagesDictionary::NEWS_UPDATED);
    }

    public function destroy(News $news)
    {
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

    public function reject(Request $request, News $news)
    {
        $this->abortUnlessUserIsManager();

        $rejectedNewsLog = RejectedNewsLog::createRejectedNewsLog($news);

        $news->delete();

        event(new NewsRejectedEvent($rejectedNewsLog));

        return redirect()->route('news.index')
            ->with('success', UserMessagesDictionary:: NEWS_REJECTED);
    }
}
