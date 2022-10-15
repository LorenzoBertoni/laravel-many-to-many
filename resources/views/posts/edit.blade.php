@extends('layouts.app')

@section('content')
    <div class="container">
        <form 
        action="{{route('admin.posts.update', ['post' => $post])}}" 
        method="POST"
        enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Titolo</label>
                <input 
                type="text"
                class="form-control"
                id="title"
                name="title"
                value="{{old('title', $post->title)}}"
                >

                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="description">Descrizione</label>
                <textarea 
                name="description"
                id="description"
                class="form-control"
                >
                    {{old('description', $post->description)}}
                </textarea>

                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category">Categoria</label>

                <select 
                name="category_id"
                id="category"
                class="custom-select"
                >
                    <option
                    value=""
                    {{(old('category_id')=="")?'selected':''}}
                    >
                        Nessuna Categoria
                    </option>
                    
                    @foreach ($categories as $category)
                        <option 
                        value="{{$category->id}}"
                        {{(old('category_id', $post->category_id)==$category->id)?'selected':''}}
                        >
                            {{$category->name}}
                        </option>
                    @endforeach
                </select>
                
                @error('category_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <h3 class="text-primary">
                    Seleziona i tag appartenenti a questo post
                </h3>

                @foreach ($tags as $tag)
                    <div class="form-group form-check">
                        @if ($errors->any())
                            <input 
                            type="checkbox"
                            name="tags[]" 
                            id="tag_{{$tag->id}}"
                            class="form-check-input"
                            value="{{$tag->id}}"
                            {{(in_array($tag->id, old('tags', [])))?'checked':''}}
                            >
                        @else
                            <input 
                            type="checkbox"
                            name="tags[]" 
                            id="tag_{{$tag->id}}"
                            class="form-check-input"
                            value="{{$tag->id}}"
                            {{$post->tags->contains($tag)?'checked':''}}
                            >
                        @endif

                        <label 
                        for="tag_{{$tag->id}}"
                        class="form-check-label"
                        >
                            {{$tag->name}}
                        </label>
                    </div>
                @endforeach

                @error('tags')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <h3 class="text-primary">
                    Seleziona un immagine da caricare:
                </h3>

                @if ($post->img_path)
                    <h4 class="text-success">
                        Immagine corrente:
                    </h4>

                    <img 
                    src="{{asset('storage/' . $post->img_path)}}" 
                    alt="{{$post->title}}"
                    class="img-fluid">
                @endif
                
                <div class="input-group mt-3 mb-3">
                    <input 
                    type="file"
                    name="img_path" 
                    id="image"
                    class="form-control"
                    >
                    
                    <label 
                    for="image"
                    class="input-group-text"
                    >
                        File:
                    </label>
                </div>
                
                @error('img_path')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                Applica Modifiche
            </button>
        </form>
    </div>
@endsection