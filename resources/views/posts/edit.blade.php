@extends('layouts.app')

@section('title', 'Update the post')

@section('content')
    <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="POST">
        @csrf {{-- 悪意のある攻撃から守るトークン --}}
        @method('PUT')
        @include('posts.partials.form')
        <div><input type="submit" value="Update" class="btn btn-primary btn-block"></div>
    </form>
@endsection