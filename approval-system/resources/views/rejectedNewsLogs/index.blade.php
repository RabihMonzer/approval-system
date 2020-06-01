@extends('layouts.app')

@section('content')
    <h2 class="font-weight-bold">Rejected Material</h2>
    <hr>
    @if(empty($rejectedNewsLogs))
        <h2>No Rejected News Yet</h2>
    @else
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Image</th>
                <th scope="col">News Owner</th>
                <th scope="col">Rejected By</th>
                <th scope="col">Rejected At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($rejectedNewsLogs as $rejectedNewsLog)
                <tr>
                    <td>{{ $rejectedNewsLog->id }}</td>
                    <td>{{ $rejectedNewsLog->title }}</td>
                    <td>{{ $rejectedNewsLog->description }}</td>
                    <td>{{ $rejectedNewsLog->image }}</td>
                    <td>{{ $rejectedNewsLog->owner->name }}</td>
                    <td>{{ $rejectedNewsLog->rejectedBy->name }}</td>
                    <td>{{ $rejectedNewsLog->created_at }}</td>
                </tr>

            @endforeach
            </tbody>
        </table>
    @endif
@endsection
