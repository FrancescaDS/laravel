<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use DB;

class AlbumsController extends Controller
{
    public function index(Request $request)
    {
        //return Album::all();

        /*query grezza - raw query
        da usare quando il querybuilder non soddisfa le esigenze
        se la query da fare e' complicata
        passare i valori con i segnaposto come sotto
        per evitare problemi di queryinjection*/
        $sql = 'select * from albums WHERE 1=1';
        $where = [];
        if($request->has('id')){
            $where['id'] = $request->get('id');
            //$sql .= " AND id=?";
            $sql .= " AND id=:id";
        }
        if($request->has('album_name')){
            $where['album_name'] = $request->get('album_name');
            //$sql .= " AND album_name=?";
            $sql .= " AND album_name=:album_name";
        }

        //dd serve per vedere quello che sta nella variabile
        //dd($sql);

        //return DB::select($sql, array_values($where));
        //return DB::select($sql, $where);
        //return DB::select($sql, $where);
        //il metodo select ritorna un array di record

        $albums = DB::select($sql, $where);
        return view('albums.albums', ['albums' => $albums]);
    }

    public function delete($id){
        $sql = 'DELETE FROM albums WHERE id= :id';
        //return "chiamata".$id;
        return DB::delete($sql, ['id' => $id]);
        //il metodo delete ritorna il numero di record che sono stati cancellati
        //return redirect()->back();
    }

    public function show($id){
        $sql = 'SELECT * FROM albums WHERE id= :id';
        return DB::select($sql, ['id' => $id]);
    }

    public function edit($id){
        return view('albums.editalbum');
    }

    public function store($id){
        //
    }

}
