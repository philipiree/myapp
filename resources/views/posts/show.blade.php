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
            <p class="text-center">Written on {{$post ->created_at}} by {{$post->user->name}}</p>
        </div>
    <hr>
    @if(!Auth::guest())
    <!--Hide if it is a guest-->
    @if(Auth::user()->id !== $post->user_id)

    <div class="text-center">
    <a href="/posts/{{$post->id}}/cart" class="btn btn-success col-sm-3">Buy</a>
        <!--Hide if it is not the same poster/user-->
    </div>
    @endif
    @if(Auth::user()->id == $post->user_id)
    <div class="text-left">
    <a href="/posts/{{$post->id}}/edit" class="btn btn-success">Edit</a>

    {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right'])!!}
        {!! Form::hidden('_method', 'DELETE') !!}
        {!! Form::submit('DELETE', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
    </div>
    @endif
    @endif
    @endsection
