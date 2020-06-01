@extends('layouts.app')

@section('content')
    <h2 class="font-weight-bold">Create News</h2>
    <hr>
    <div class="w-75 text-left p-4">
        <form method="POST" action="{{ route('materials.store') }}">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input name="title" type="text" class="form-control" id="title" placeholder="Write a title here">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" required class="form-control" id="description" rows="3"
                          placeholder="Write a description here"></textarea>
            </div>

            <div class="form-group">
                <label for="imageInput">File input</label>
                <input data-preview="#preview" name="input_img" type="file" id="imageInput">
                <img class="col-sm-6" id="preview"  src="">
            </div>

            <button type="submit" class="btn btn-primary">Create News</button>
        </form>

        <div class="m-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        </div>
    </div>
    @endif
@endsection
