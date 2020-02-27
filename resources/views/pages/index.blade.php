@extends('layouts.layout')

@section('content')
    <h1>Welcome to We Are The Arsenal Blog</h1>
    <a href="{{route('posts.index')}}">See Posts</a>
    <a href="{{route('posts.create')}}">Create a new Post</a>
@endsection