@extends('layouts.app')

@section('title', 'Vote Artwork')

@section(section: 'content')
    {{-- @include('layouts.nav') --}}
    @include('homepage.hero')
    @include('homepage.how')
    <div class="my-32">
        @include('homepage.arts')
    </div>
    <div class="mx-32 my-32">
        @include('homepage.cta')
    </div>
@endsection
