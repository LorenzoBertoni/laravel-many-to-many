@extends('layouts.app')

@section('content')
    <div class="container">
        <form 
        action="{{route('admin.posts.update', ['post' => $post])}}" 
        method="POST"
        >
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
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
                <label for="description">Description</label>
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
                <label for="category">Category</label>

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

            <button type="submit" class="btn btn-primary">
                Applica Modifiche
            </button>
        </form>
    </div>
@endsection