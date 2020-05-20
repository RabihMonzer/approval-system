@extends('layouts.app')

@section('content')
    <h2 class="font-weight-bold">Dashboard</h2>
    <hr>
    @if(empty($materials))
        <h2>No Materials Yet</h2>
    @else
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Content</th>
                <th scope="col">Type</th>
                <th scope="col">Status</th>
                <th scope="col">Created By</th>
                <th scope="col">Created At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($materials as $material)
                <tr>
                    <td><a href="{{ route('materials.show', $material->id) }}">{{ $material->id }}</a></td>
                    <td>{{ $material->title }}</td>
                    <td>{{ $material->content }}</td>
                    <td>
                        <a href="{{ route('material-types.show', $material->materialType->id) }}">{{ $material->materialType->type }}</a>
                    </td>
                    <td>{{ $material->status }}</td>
                    <td>{{ $material->user->name }}</td>
                    <td>{{ $material->created_at }}</td>
                </tr>

            @endforeach
            </tbody>
        </table>
    @endif
@endsection
