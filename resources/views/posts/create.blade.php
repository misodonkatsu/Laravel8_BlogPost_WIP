@extends('layouts.app')

@section('title', 'Create the post')

@section('content')
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf {{-- 悪意のある攻撃から守るトークン --}}
        @include('posts.partials.form')
        <div><input type="submit" value="Create" class="btn btn-primary btn-block"></div>
    </form>
@endsection