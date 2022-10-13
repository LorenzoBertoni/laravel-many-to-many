@extends('layouts.app')

@section('content')
    <div class="container">
        <a 
        href="{{route('admin.tags.index')}}"
        class="btn btn-primary mb-4"
        >
            Torna alla lista
        </a>
        <h1 class="text-primary">Tag:</h1>
        <h2>{{$tag->name}}</h2>
        <h1 class="text-primary">Slug:</h1>
        <h2>{{$tag->slug}}</h2>
    </div>    

    <div class="container">
        <h1 class="text-primary">Correlati:</h1>

        @if (count($tag->posts))
            <div class="container d-flex flex-wrap">
                @foreach ($tag->posts as $post)
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
        @else
            <div class="container">
                <h3>Nessun post correlato</h3>
            </div>
        @endif
    </div>
@endsection