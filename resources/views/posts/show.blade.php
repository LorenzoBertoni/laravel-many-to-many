@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Thumbnail</th>
                    <th scope="col">Titolo</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Descrizione</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Tag</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">{{$post->id}}</th>
                    <th scope="row">
                        @if ($post->img_path)
                            <img 
                            src="{{asset('storage/' . $post->img_path)}}" 
                            alt="{{$post->title}}"
                            class="img-fluid"
                            >
                        @else
                            <img 
                            src="{{asset('fallback-images/posts-fallback.jpg')}}" 
                            alt="{{$post->title}}"
                            class="img-fluid"
                            >
                        @endif
                        
                    </th>
                    <td>{{$post->title}}</td>
                    <td>{{$post->slug}}</td>
                    <td>{{$post->description}}</td>
                    <td>
                        {{($post->category)?$post->category->name:' - '}}
                    </td>
                    <td>
                        @if (count($post->tags))
                            @foreach ($post->tags as $tag)
                                {{$tag->name}} |
                            @endforeach
                        @else
                            <span> - </span>
                        @endif
                    </td>

                    <td class="actions">
                        <a 
                        href="{{route('admin.posts.index')}}"
                        class="btn btn-primary"
                        >
                            Torna alla lista
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection