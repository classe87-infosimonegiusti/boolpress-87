@extends('layouts.admin')

@section('page-title', 'Elenco dei tag')

@section('content')

<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nome</th>
        <th scope="col">Slug</th>
        <th scope="col">Numero di post</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($tags as $tag)
            <tr>
                <td>{{$tag->id}}</td>
                <td>{{$tag->name}}</td>
                <td>{{$tag->slug}}</td>
                <td>{{count($tag->posts)}}</td>
            </tr>
        @endforeach
    </tbody>
  </table>


@endsection
