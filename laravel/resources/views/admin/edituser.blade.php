@extends('templates.admin')
@section('content')
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1>User insert/update</h1>

            @if(session()->has('message'))
                <div class="alert alert-info" role="alert">
                    <strong>{{session('message')}}</strong>
                </div>
            @endif

            <div class="badge badge-danger">
                {{$errors}}
            </div>
            @if($user->id)
                <form action="{{route('users.update', $user->id)}}" method="POST" enctype="multipart/form-data">
                 {{method_field('PATCH')}}
            @else
                 <form action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
            @endif

        <div class="form-group">
            <label for="name">Name</label>
            <input required type="text" name="name" id="name" class="form-control" value="{{old('name')?old('name'):$user->name}}" placeholder="Your name">
            @if($errors->get('name'))
                <div class="badge badge-danger">
                    @foreach($errors->get('name') as $error)
                        {{$error}}<br>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input required type="email" name="email" id="email" class="form-control" value="{{old('email')?old('email'):$user->email}}" placeholder="Your email">
            @if($errors->get('email'))
                <div class="badge badge-danger">
                    @foreach($errors->get('email') as $error)
                        {{$error}}<br>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select required name="role" id="role" class="form-control">
                <option value="">Seleziona</option>
                <option value="user"
                        {{( old('role')   == 'user' || $user->role =='user')?'selected':''}}
                >User</option>
                <option value="admin"   {{( old('role') == 'admin' || $user->role=='admin')?'selected':''}}>Admin</option>
            </select>
            @if($errors->get('role'))
                <div class="badge badge-danger">
                    @foreach($errors->get('role') as $error)
                        {{$error}}<br>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="form-group text-center">
            {{csrf_field()}}
            <a href="{{route('user-list')}}"  class="btn btn-" >BACK</a>
            <button  class="btn btn-default" id="reset" type="reset">RESET</button>
            <button   class="btn btn-success"  id="save">SAVE</button>
        </div>
        <input type="hidden" name="id" value="{{$user->id}}">

    </form>
</div>
</div>
@endsection