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
        <h1 class="text-primary mb-3">Tag</h1>

        <div class="actions container d-flex justify-content-end">
            <a 
            href="{{route('admin.tags.create', ['tag' => $tags])}}"
            class="btn btn-primary mb-3"
            >
                + Crea nuovo tag
            </a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Slug</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tags as $tag)
                    <tr>
                        <th scope="row">{{$tag->id}}</th>
                        <td>{{$tag->name}}</td>
                        <td>{{$tag->slug}}</td>
                        <td class="actions p-2 d-flex justify-content-center align-items-center">
                            <a 
                            href="{{route('admin.tags.show', ['tag' => $tag])}}"
                            class="btn btn-primary"
                            >
                                Vedi correlati
                            </a>
                            <a 
                            href="{{route('admin.tags.edit', ['tag' => $tag])}}"
                            class="btn btn-warning ml-3"
                            >
                                Modifica
                            </a>
                            <form 
                            action="{{route('admin.tags.destroy', ['tag' => $tag])}}"
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