@extends('layouts.layout')

@section('content')
    <a href="/posts" class="btn btn-default">Go Back</a>
    <h1>{{$post->title}}</h1>
    <img style="width:100%" src="/storage/images/{{$post->image}}">
    <br><br>
    <div>
        {!!$post->body!!}
    </div>
    <hr>
    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
            <a href="/posts/{{$post->slug}}/edit" class="btn btn-default">Edit</a>
            <form action="{{route('posts.destroy', $post->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" >Delete</button>
            </form>
        @endif
    <div>Likes: {{$likes}}</div>
    <div><a href="{{route('posts.like', $post->slug)}}">Like<i class="fas fa-thumbs-up" aria-hidden="true"></i></a></div><br><br>
    <div>
    Comments:<br>
    @if(count($comments)>0)
        @foreach($comments as $comment)
        <div>
        {{$comment->body}}<br>By:<small>{{$comment}}</small>
        </div>
        @endforeach
    @else
        <p>No comments yet</p>
    @endif
    </div>
    @endif
    <form action="{{route('posts.comment', $post->slug)}}" method="post">
        @csrf
        <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="body">Comment</label>
                        <textarea id="body" class="form-control" required name="body" rows="4"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit">COMMENT</button>
    </form>
@endsection