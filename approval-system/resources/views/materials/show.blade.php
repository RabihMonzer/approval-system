@extends('layouts.app')

@section('content')
    <div class="card">
        <h5 class="card-header">{{ $material->type->type }}</h5>
        <div class="card-body">
            <h5 class="card-title">{{ $material->title }}</h5>
            <p class="card-text">{{ $material->content }}</p>
            <p class="card-text"><strong>Status:</strong> {{ $material->status }}</p>
            <p class="card-text"><strong>Created By:</strong> {{ $material->user->name }}</p>

            <div class="d-inline align-bottom">
                <a href="{{ route('materials.edit', $material->id) }}" style="font-size:55px"><i
                        class="fa fa-pencil-square-o p-4"></i></a>
            </div>
            <form action="{{route('materials.destroy', $material->id)}}" method="post" style="display: inline;">
                @csrf
                @method('delete')
                <button type="submit" class="btn text-danger" style="display: inline;">
                    <a style="font-size: 50px"><i class="fa fa-trash p-4"></i></a>
                </button>
            </form>

            <form action="{{ route('material.approve', $material->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('put')
                <button type="submit" class="btn text-success" style="display: inline;">
                    <a style="font-size: 50px;"><i class="fa fa-check p-4"></i></a>
                </button>
            </form>

            <form action="{{ route('material.decline', $material->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('put')
                <button type="submit" class="btn text-warning" style="display: inline;">
                    <a style="font-size: 50px"><i class="fa fa-times p-4"></i></a>
                </button>
            </form>

        </div>
        <div class="card-footer text-muted">
            Created At: {{ $material->created_at }}
        </div>
    </div>
@endsection
