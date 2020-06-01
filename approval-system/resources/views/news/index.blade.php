@extends('layouts.app')

@section('content')
    <h2 class="font-weight-bold">News Dashboard</h2>
    <hr>
    @if(empty($news))
        <br>
        <p>No News Yet</p>
    @else
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Status</th>
                <th scope="col">Created By</th>
                <th scope="col">Created At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($news as $singleNews)
                <tr>
                    <td><a href="{{ route('news.show', $singleNews->id) }}">{{ $singleNews->id }}</a></td>
                    <td>{{ $singleNews->title }}</td>
                    <td>{{ $singleNews->description }}</td>
                    <td>{{ $singleNews->status }}</td>
                    <td>{{ $singleNews->createdBy->name }}</td>
                    <td>{{ $singleNews->created_at }}</td>
                </tr>

            @endforeach
            </tbody>
        </table>
    @endif
@endsection
