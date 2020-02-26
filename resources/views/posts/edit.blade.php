@extends('layouts.layout')

@section('content')
<h2 class="text-center pt-5 mt-5 pb-4">Edit Post</h2>
<form action="{{route('posts.update', $post->id)}}" method="post" enctype='multipart/form-data'>
    @csrf
    @method('PUT')
    <div class="col-md-10 offset-md-1">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title">Post Title</label>
                    <input id="title" class="form-control" required type="text" name="title" value="{{$post->title}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="body">Post Body</label>
                    <textarea id="body" class="form-control" required name="body" rows="4">{{$post->body}}</textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="image">Cover Image</label>
                    <input id="image" type='file' class="form-control" required name="image">
                </div>
            </div>
        </div>
    </div>
    <button type="submit">EDIT POST</button>
</form>
@endsection