@extends('layouts.admin')

@section('page-title', "Modifica: $post->title")

@section('content')

    <form method="POST" action="{{ route('admin.posts.update', ['post' => $post->slug]) }}" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Titolo</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror " id="title" name="title" value="{{old('title', $post->title)}}">
            @error('title')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="cover_image" class="form-label">Seleziona immagine di copertina</label>


            @if ($post->cover_image)
            <div class="my-img-wrapper">
                <img class="img-thumbnail my-img-thumb" src="{{asset('storage/' . $post->cover_image)}}" alt="{{$post->title}}"/>
                <a href="{{route('admin.posts.deleteImage', ['slug' => $post->slug])}}" class="my-img-delete btn btn-danger">X</a>
            </div>
            @endif

            <input type="file" class="form-control @error('cover_image') is-invalid @enderror " id="cover_image" name="cover_image">

            @error('cover_image')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Seleziona categoria</label>
            <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
                <option @selected(old('category_id', $post->category_id)=='') value="">Nessuna categoria</option>
                @foreach ($categories as $category)
                    <option @selected(old('category_id', $post->category_id)==$category->id) value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Testo dell'articolo</label>
            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content">{{old('content', $post->content)}}</textarea>
            @error('content')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            @foreach($tags as $tag)

                @if ($errors->any())
                    <input id="tag_{{$tag->id}}" @if (in_array($tag->id , old('tags', []))) checked @endif type="checkbox" name="tags[]" value="{{$tag->id}}">
                @else
                    <input id="tag_{{$tag->id}}" @if ($post->tags->contains($tag->id)) checked @endif type="checkbox" name="tags[]" value="{{$tag->id}}">
                @endif

                <label for="tag_{{$tag->id}}" class="form-label">{{$tag->name}}</label>
                <br>
            @endforeach
            @error('tags')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Salva</button>

    </form>

@endsection
