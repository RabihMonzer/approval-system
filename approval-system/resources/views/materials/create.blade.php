@extends('layouts.app')

@section('content')
    <h2 class="font-weight-bold">Create New Material</h2>
    <hr>
    @if(empty($availableMaterialTypes))
        <h2>There are no material types, please go to <a href="{{ route('material-types.create') }}" class="href">this
                link</a> and create a material type before</h2>
    @else

        <div class="w-75 text-left p-4">
            <form method="POST" action="{{ route('materials.store') }}">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input name="title" type="text" class="form-control" id="title" placeholder="Write a title here">
                </div>

                <div class="form-group">

                    <label for="materialTypes">Material Type</label>
                    <input name="materialType" class="form-control" required type="text" list="materialTypes"
                           placeholder="Choose / Create a Material Type"/>
                    <datalist id="materialTypes">
                        @foreach($availableMaterialTypes as $availableMaterialType)
                            <option>{{ $availableMaterialType->type }}</option>
                        @endforeach
                    </datalist>
                </div>

                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content" required class="form-control" id="content" rows="3"
                              placeholder="Write all what you need to publish!"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create Material</button>
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
                @endif
            </div>
        </div>
    @endif
@endsection
