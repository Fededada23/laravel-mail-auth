@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 mb-3">
                <a class="btn btn-primary" href="{{route('admin.projects.create')}}">Aggiungi progetto</a>
            </div>
            <div class="col-12">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message')}}
                    </div>
                @endif
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Titolo</th>
                            <th scope="col">slug</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <th scope="row">{{ $project->id }}</th>
                                <td>{{ $project->title }}</td>
                                <td>{{ $project->slug }}</td>
                                <td>
                                    <a href="{{route('admin.projects.edit', $project->slug)}}" title="Modifica project" class="btn btn-sm btn-square btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{route('admin.projects.show', $project->slug)}}" title="Visualizza project" class="btn btn-sm btn-square btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form class="d-inline-block" action="{{route('admin.projects.destroy', $project->slug)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-square">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>   
                            </tr>                 
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@include('admin.partials.modals')
@endsection