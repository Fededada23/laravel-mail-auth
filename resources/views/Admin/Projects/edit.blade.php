@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 my-5">
                <h4>Modifica progetto</h4>
            </div>
            <div class="col-12">
                <form action="{{route('admin.projects.update', $project->slug)}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <div class="control-label">
                            Titolo
                        </div>
                        <input type="text" class="form-control" placeholder="titolo" name="title" id="title" value="{{old('$project->title') ?? $project->title}}">
                        @error('title')
                            <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group my-3">
                        <div class="control-label">
                            Descrizione
                        </div>
                        <textarea class="form-control" placeholder="descrizione progetto" name="description" id="description">{{old('$project->description') ?? $project->description}}</textarea>
                        @error('description')
                            <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group m-2">
                        <label class="fs-2 fw-semibold" for="type_id">Categorie</label>
                        <select class="form-control" name="type_id" id="type_id">
                            <option value="">Seleziona categoria</option>
                            @foreach ($types as $type)
                            <option value="{{$type->id}}"
                                {{$type->id == old('type_id', $project->type_id) ? 'selected' : ''}}>
                                {{$type->name}}
                            </option>  
                            @endforeach
                        </select>
                        @error('type_id')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group m-2">
                        <div class="fs-2 fw-semibold">Technologies</div>
                        @foreach ($technologies as $technology)
                        <div class="form-check @error('technologies') is-invalid @enderror">
                            @if($errors->any())
                            <input type="checkbox" value="{{$technology->id}}" name="technologies[]" {{in_array($technology->id, old('technologies', [])) ? 'checked' : ''}} class="form-check-input">
                            <label class="form-check-label">{{$technology->name}}</label>
                            @else
                            <input type="checkbox" value="{{$technology->id}}" name="technologies[]" {{$project->technologies->contains($technology) ? 'checked' : ''}} class="form-check-input">
                            @endif <label class="form-check-label">{{$technology->name}}</label>
                        </div>
                        @endforeach
                        @error('technologies')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Modifica</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection    
