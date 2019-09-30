@extends('layouts.app')

@section('content')

    <a href="/posts" class="btn btn-default">Go Back</a>
    <h1>{{$post->title}}</h1>
     <img class="img-thumbnail mx-auto d-block" src="/storage/cover_image/{{$post->cover_image}}">
    <div class="text-center">
        {!!$post->body!!}
    </div>
    <hr>
        <div class="text-center">
            <p>Written on {{$post ->created_at}} by {{$post->user->name}}</p>
        </div>
    <hr>
    <div class="text-center">
        <a href="/posts/{{$post->id}}/cart" class="btn btn-success col-sm-3">Buy</a>
    </div>
    <!--Hide if it is a guest-->
    @endsection
