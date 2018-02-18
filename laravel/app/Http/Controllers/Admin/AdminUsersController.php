<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Models\User;
use DataTables;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //questo lo script per la versione di pdataTable lato client
        //$users = User::orderBy('name')->get();
        //return view('admin/users', compact('users'));
        return view('admin/users');
    }

    private function getUserButtons(User $user)
    {
        $buttonEdit = '<a href="'.route('users.edit',['id'=>$user->id]).'" id="#edit'.$user->id.'" class="btn btn-primary" title="Edit"><i class="fa fa-pencil-square-o"></i></a>&nbsp;';

        if ($user->deleted_at){
            $deleteRoute = route('users.restore',['id'=>$user->id]);
            $iconDelete = '<i class="fa fa-repeat"></i>';
            $titleDelete = 'Restore';
            $btnId = '#restore-'.$user->id;
            $btnClass='btn-default';
        } else {
            $deleteRoute = route('users.destroy',['id'=>$user->id]);
            $iconDelete = '<i class="fa fa-trash-o"></i>';
            $titleDelete = 'Delete';
            $btnId = '#delete-'.$user->id;
            $btnClass='btn-danger';
        }
        $buttonDelete = '<a href="'.$deleteRoute.'" id="'.$btnId.'" class="ajax btn '.$btnClass.'" title="'.$titleDelete.'">'.$iconDelete.'</a>&nbsp;';

        $buttonForceDelete = '<a href="'.route('users.destroy',['id'=>$user->id]).'?hard=1" id="#forcedelete'.$user->id.'" class="ajax btn btn-danger" title="Force delete"><i class="fa fa-minus-square-o"></i></a>';

        return $buttonEdit.$buttonDelete.$buttonForceDelete;
    }

    public function getUsers()
    {
        $users = User::select(['id','name','email','role','created_at','deleted_at'])
            ->orderBy('name')->withTrashed()->get();
        $result = DataTables::of($users)
            ->addColumn('action', function($user){
                return $this->getUserButtons($user);
            })
            ->editColumn('created_at', function($user){
                return $user->created_at->format('d/m/y H:i');
            })
            ->editColumn('deleted_at', function($user ) {
                //analisi data perche' vista come stringa
                /*if (is_null($user->deleted_at)) {
                    $dateDelete = '';
                } else {
                    $dateDelete = date('d/m/Y', strtotime($user->deleted_at));
                }
                return $dateDelete;*/
                //inserendo protected $data nel Modulo User indico che queste sono date
                return $user->deleted_at? $user->deleted_at->format('d/m/Y') : '';


            })
            ->make(true);
        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        return view('admin.edituser', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        $user = new User();
        $user->password = bcrypt($request->input('email'));

        $user->fill($request->only(['email','role','name']));
        $res =  $user->save();
        $messaggio = $res ? 'User successfully created': 'Problem creating users';
        session()->flash('message', $messaggio);
        return redirect()->route('users.edit', ['id'=> $user->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.edituser', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request,User $user )
    {
        $user->fill($request->only(['email','role','name']));
        $res =  $user->save();
        $messaggio = $res ? 'User successfully updated': 'Prolbem saving users';
        session()->flash('message', $messaggio);
        return redirect()->route('users.edit', ['id'=> $user->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $hard = \request('hard', '');

        $res = $hard? $user->forceDelete() : $user->delete();
        return ''.$res;
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $res = $user->restore();
        return ''.$res;
    }


}
