@extends('templates.default')
@section('content')
    <h1>EDIT ALBUM</h1>
    <form>
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" required name="name" id="name" class="form-control" value="" placeholder="Album name">

        </div>
        <div class="form-group">
            <label for="">Description</label>
            <input type="text" required name="description" id="description" class="form-control" value="" placeholder="Album description">

        </div>
    </form>
@stop