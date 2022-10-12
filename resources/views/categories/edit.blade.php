@extends('layouts.app')

@section('content')
    <div class="container">
        <form 
        action="{{route('admin.categories.update', ['category' => $category])}}" 
        method="POST"
        >
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input 
                type="text"
                class="form-control"
                id="name"
                name="name"
                value="{{old('name', $category->name)}}"
                required
                >

                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Applica Modifiche</button>
        </form>
    </div>
@endsection