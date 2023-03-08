@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                @endif
                <form method="POST" action="{{route('admin.projects.store')}}">
                    @csrf 

                    <div class="form-group my-2">
                        <label class="fs-2 fw-semibold" for="title">Titolo</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Inserire Titolo">
                    </div>
                    <div class="form-group my-2">
                        <label class="fs-2 fw-semibold" for="description">Descrizione</label>
                        <textarea type="password" class="form-control" name="description" id="description" placeholder="Inserire Descrizione"></textarea>
                    </div>
                    <div class="form-group my-2">
                        <label class="fs-2 fw-semibold" for="type_id">Categorie</label>
                        <select class="form-control" name="type_id" id="type_id">
                            @foreach ($types as $type)
                            <option value="{{$type->id}}">
                                {{$type->name}}
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group my-2">
                        <div class="fs-2 fw-semibold">Tecnologie</div>
                        @foreach ($technologies as $technology)
                        <div class="form-check @error ('technologies') is-invalid @enderror">
                            <input type="checkbox" value="{{$technology->id}}" name="technologies[]">
                            <label class="form-check-label">{{$technology->name}}</label>
                        </div> 
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-success">Salva</button>
                </form>
            </div>
        </div>
    </div>
@endsection
