@extends('layouts.app')

@section('content')

    <a href="/posts" class="btn btn-default">Go Back</a>
    <h1 class="text-center">{{$post->title}}</h1>
     <img class="img-thumbnail mx-auto d-block" src="/storage/cover_image/{{$post->cover_image}}">
    <div class="text-center">
        {!!$post->body!!}
    </div>
    <hr>
        <div class="text-center">
            <p>Written on {{$post ->created_at}} by {{$post->user->name}}</p>
        </div>
    <hr>

    <div class="row justify-content-center">
    {!! Form::open(['action' => ['PostsController@updateNew', $post->id, $post->user_id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary mx-auto d-block'])}}
    {!! Form::close() !!}
    </div>

    <!--Hide if it is a guest-->
    @endsection
