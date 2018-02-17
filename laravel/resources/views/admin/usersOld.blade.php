@extends('templates.admin')
@section('content')
<h1>Users</h1>
<table class="table table-striped" id="dataTable">
    <thead>
        <tr>
            <td>Name</td>
            <td>Email</td>
            <td>Role</td>
            <td>Created</td>
            <td>Deleted</td>
            <td>&nbsp;</td>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->role}}</td>
            <td>{{$user->created_at->format('d/m/Y')}}</td>
            <td>
                @if($user->deleted_at)
                    $user->deleted_at->format('d/m/Y')
                @else
                @endif
            </td>
            <td>
                <div class="row">
                    <div class="col-4">
                        <button class="btn btn-primary" title="Update"><i class="fa fa-pencil-square-o"></i></button>
                    </div>
                    <div class="col-4">
                        <button
                                @if($user->deleted_at)
                                    disabled
                                @else
                                @endif
                                class="btn btn-danger" title="Delete"><i class="fa fa-trash-o"></i></button>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-danger" title="Force delete"><i class="fa fa-minus-square-o"></i></button>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection