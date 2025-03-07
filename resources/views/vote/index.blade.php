@extends('layouts.app')

@section('title', $seo['meta_title'])

@section(section: 'content')
    {{-- @include('layouts.nav') --}}
    @include('homepage.hero')
    @include('homepage.how')
    <div class="mx-8 md:mx-32 lg:mx-0 my-32">
        <div class="my-10">
            @include('homepage.countdown')
        </div>

        @include('homepage.arts')
    </div>
    <div class="mx-8 md:mx-32 my-32">
        @include('homepage.cta')
    </div>
@endsection
