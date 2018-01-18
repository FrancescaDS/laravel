@extends('templates.default')
@section('title',$title)
@section('content')
<h1>
    With Blade
    {{$title}}
</h1>

@if($staff)
    <ul>
    @foreach ($staff as $person)
        <li> {{$person['name']}} {{$person['lastname']}}</li>
    @endforeach
    </ul>
@else
    <p>No staff</p>
@endif

<ul>
@forelse($staff as $person)
    <li style="{{$loop->first ? 'color:red':''}}">  {{$loop->remaining}} {{$loop->last}} {{$person['name']}} {{$person['lastname']}}</li>
@empty
    <li>No staff</li>
@endforelse
</ul>

<h2>Staff for</h2>
@for($i=0; $i<count($staff); $i++)
    {{$staff[$i]['name']}} {{$staff[$i]['lastname']}}<br>
@endfor

<h2>Staff while</h2>
@while($person = array_shift($staff))
    {{$person['name']}} {{$person['lastname']}}<br>
@endwhile

@endsection