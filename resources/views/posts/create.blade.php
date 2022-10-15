@extends('layouts.app')

@section('content')
    <div class="container">
        <form 
        action="{{route('admin.posts.store')}}" 
        method="POST"
        enctype="multipart/form-data"
        >
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Titolo</label>
                <input 
                type="text"
                class="form-control"
                id="title"
                name="title"
                value="{{old('title')}}"
                required
                max="255"
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
                required
                >
                    {{old('description')}}
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
                        {{(old('category_id')==$category->id)?'selected':''}}
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
                        <input 
                        type="checkbox"
                        name="tags[]" 
                        {{--
                            SE è stato selezionato almeno un tag il browser     risponde con un'array delle relative value
                            ALTRIMENTI non ritorna nulla
                        --}}
                        id="tag_{{$tag->id}}"
                        class="form-check-input"
                        value="{{$tag->id}}"
                        {{(in_array($tag->id, old('tags', [])))?'checked':''}}
                        >

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

            <button type="submit" class="btn btn-primary">Crea</button>
        </form>
    </div>
@endsection