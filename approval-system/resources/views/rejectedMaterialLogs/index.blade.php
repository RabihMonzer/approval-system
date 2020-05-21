@extends('layouts.app')

@section('content')
    <h2 class="font-weight-bold">Rejected Material</h2>
    <hr>
    @if(empty($rejectedMaterialsLog))
        <h2>No Rejected Materials Yet</h2>
    @else
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Content</th>
                <th scope="col">Created By</th>
                <th scope="col">Rejected By</th>
                <th scope="col">Rejected At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($rejectedMaterialsLog as $rejectedMaterialLog)
                <tr>
                    <td>{{ $rejectedMaterialLog->id }}</td>
                    <td>{{ $rejectedMaterialLog->title }}</td>
                    <td>{{ $rejectedMaterialLog->content }}</td>
                    <td>{{ $rejectedMaterialLog->user->name }}</td>
                    <td>{{ $rejectedMaterialLog->createdBy->name }}</td>
                    <td>{{ $rejectedMaterialLog->created_at }}</td>
                </tr>

            @endforeach
            </tbody>
        </table>
    @endif
@endsection
