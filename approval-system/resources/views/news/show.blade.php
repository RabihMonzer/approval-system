@extends('layouts.app')

@section('content')

    <div class="card">
        <img height="400px" src="{{asset('storage/images/'. $news->image)}}" class="card-img-top" alt="No Image">
        <div class="card-body">
            <h3 class="card-title">{{ $news->title }}</h3>
            <p class="card-text">{{ $news->description }}</p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Status: </strong>{{ $news->status }}</li>
            <li class="list-group-item"><strong>Created By: </strong>{{ $news->createdBy->name }}</li>
            <li class="list-group-item"><strong>Created At: </strong>{{ $news->created_at }}</li>
        </ul>
        <div class="card-body">

            <div class="d-inline align-bottom"><a href="{{ route('news.edit', $news->id) }}" style="font-size:55px"><i
                    class="fa fa-pencil-square-o p-4"></i></a>
            </div>

            <form action="{{ route('news.destroy', $news->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('delete')
                <button type="submit" class="btn text-warning" style="display: inline;">
                    <a style="font-size: 50px"><i class="fa fa-trash p-4"></i></a>
                </button>
            </form>

            @if(auth()->user()->isManager())

                @if(\App\Dictionaries\NewsStatusDictionary::APPROVED !== $news->status)
                    <form action="{{ route('news.approve', $news->id) }}" method="POST"
                          style="display: inline;">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn text-success" style="display: inline;">
                            <a style="font-size: 50px;"><i class="fa fa-check p-4"></i></a>
                        </button>
                    </form>

                    <form action="{{ route('news.reject', $news->id) }}" method="POST"
                          style="display: inline;">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn text-danger" style="display: inline;">
                            <a style="font-size: 50px"><i class="fa fa-times p-4"></i></a>
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>

@endsection
