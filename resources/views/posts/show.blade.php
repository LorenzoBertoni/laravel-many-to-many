@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Description</th>
                    <th scope="col">Category</th>
                    <th scope="col">Tags</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">{{$post->id}}</th>
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