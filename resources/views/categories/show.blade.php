@extends('layouts.app')

@section('content')
    <div class="container">
        <a 
        href="{{route('admin.categories.index')}}"
        class="btn btn-primary mb-4"
        >
            Torna alla lista
        </a>
        <h1 class="text-primary">Categoria:</h1>
        <h2>{{$category->name}}</h2>
        <h1 class="text-primary">Slug:</h1>
        <h2>{{$category->slug}}</h2>
    </div>    

    <div class="container">
        <h1 class="text-primary">Correlati:</h1>

        <div class="container d-flex flex-wrap">
            @foreach ($category->posts as $post)
                <div class="card m-3" style="width: 18rem;">
                    <div class="card-body">
                        <h3 class="card-title text-dark">
                            {{$post->title}}
                        </h3>
                        <p class="card-text">
                            {{$post->description}}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection