@extends('templates/default')
@section('title','Blog')

@section('content')
    <h1>BLOG</h1>
    @component('components.card',
        [
        'img_title' => 'Image blog',
        'img_url' => 'http://lorempixel.com/400/200'
        ]
        )
        <p>This is a beautiful image I took last summer</p>
    @endcomponent
    
    @component('components.card')
        @slot('img_title','Second image')
        @slot('img_url','http://lorempixel.com/400/200')
        <p>This is a beautiful image I took last winter</p>
    @endcomponent
    
    @include('components.card')
    
    @include('components.card',
        [
        'img_title' => 'Include con array',
        'img_url' => 'http://lorempixel.com/400/200'
        ]
        )
@endsection

@section('footer')
    @parent
    
@endsection