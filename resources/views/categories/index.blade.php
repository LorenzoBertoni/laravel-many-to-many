@extends('layouts.app')

@section('content')
{{-- ***Alert stampati in caso di inserimento/modifica 
    *dei dati nel DB --}}
    <div class="container">
        @if (session('created'))
            <div class="alert alert-success">
                {{session('created')}}
            </div>
        @endif
    </div>
    <div class="container">
        @if (session('edited'))
            <div class="alert alert-success">
                {{session('edited')}}
            </div>
        @endif
    </div>
    <div class="container">
        @if (session('cancelled'))
            <div class="alert alert-danger">
                {{session('cancelled')}}
            </div>
        @endif
    </div>
{{-- ***Alert stampati in caso di inserimento/modifica 
            *dei dati nel DB --}}
    <div class="container">
        <div class="actions container d-flex justify-content-end">
            <a 
            href="{{route('admin.categories.create', ['category' => $categories])}}"
            class="btn btn-primary mb-3"
            >
                + Crea nuova categoria
            </a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <th scope="row">{{$category->id}}</th>
                        <td>{{$category->name}}</td>
                        <td>{{$category->slug}}</td>
                        <td class="actions p-2 d-flex justify-content-center align-items-center">
                            <a 
                            href="{{route('admin.categories.edit', ['category' => $category])}}"
                            class="btn btn-warning"
                            >
                                Modifica
                            </a>
                            <form 
                            action="{{route('admin.categories.destroy', ['category' => $category])}}"
                            method="POST"
                            >
                                @csrf
                                @method('DELETE')

                                <button 
                                type="submit"
                                class="btn btn-danger ml-3"
                                onclick="return confirm('L\'eliminazione dei dati è permanente. Confermando eliminerai l\'elemento selezionato. Desideri procedere?')"
                                >
                                    Elimina
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection