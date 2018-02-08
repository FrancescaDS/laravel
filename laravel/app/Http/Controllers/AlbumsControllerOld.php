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

        //$sql = 'select * from albums WHERE 1=1';
        //$queryBuilder = DB::table('albums')->orderBy('id','desc');
        $queryBuilder = Album::orderBy('id','desc');
        if($request->has('id')){
            //se l'operatore e' '=' si puo' non passare il parametro
            //$queryBuilder->where('id','=',$request->get('id'));
            $queryBuilder->where('id',$request->get('id'));
        }
        if($request->has('album_name')){
            $queryBuilder->where('album_name', 'LIKE', '%'.$request->get('album_name').'%');
        }
        $albums = $queryBuilder->get();
        return view('albums.albums', ['albums' => $albums]);


        /*  $where = [];
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
        $sql .= " ORDER BY id DESC";

        //dd serve per vedere quello che sta nella variabile
        //dd($sql);

        //return DB::select($sql, array_values($where));
        //return DB::select($sql, $where);
        //return DB::select($sql, $where);
        //il metodo select ritorna un array di record

        $albums = DB::select($sql, $where);
        return view('albums.albums', ['albums' => $albums]);*/
    }

    public function delete($id){
       //$res = DB::table('albums')->where('id',$id)->delete();
        //$res = Album::where('id',$id)->delete();

        $res = $album = Album::find($id)->delete();

        return ''.$res;

       //$sql = 'DELETE FROM albums WHERE id= :id';
        //return "chiamata".$id;
        //return DB::delete($sql, ['id' => $id]);
        //il metodo delete ritorna il numero di record che sono stati cancellati
        //return redirect()->back();
    }

    public function show($id){
        $sql = 'SELECT * FROM albums WHERE id= :id';
        return DB::select($sql, ['id' => $id]);
    }

    public function edit($id){
        //$sql = 'SELECT id, album_name, description FROM albums WHERE id = :id';
        //$album = DB::select($sql, ['id' =>$id]);
        //dd($album);
        //dd($album[0]);
        //si passa il primo record per passare solo un oggetto e non un array con un oggetto solo
        //return view('albums.editalbum')->with('album',$album[0]);

        $album = Album::find($id);
        return view('albums.editalbum')->with('album',$album);

    }

    public function store($id){
        //$res = DB::table('albums')->where('id',$id)->update(
       /* $res = Album::where('id',$id)->update(
            [
                'album_name' => request()->input('name'),
                'description' => request()->input('description')
            ]
        );*/

       $album = Album::find($id);
       $album->album_name = request()->input('name');
       $album->description = request()->input('description');
        $res = $album->save();

        /*
         $data = request()->only(['name','description']);
        $data['id']=$id;
        $sql = 'UPDATE albums SET album_name=:name, description=:description';
        $sql .= ' WHERE id=:id';
        $res = DB::update($sql, $data);*
         */
        //$res ritorna il numero di record coinvolti dalla query
        //dd($res);

        $messaggio = $res ? 'Album '.$id.' aggiornato' : 'Album '.$id.' NON aggiornato';
        session()->flash('message', $messaggio);
        return redirect()->route('albums');
    }

    public function create(){
        return view('albums.createalbum');
    }

    public function save(){
        $name = request()->input('name');
        //$res = DB::table('albums')->insert(
        //$res = Album::insert(
        /*$res = Album::create(
            [
                'album_name' => $name,
                'description' => request()->input('description'),
                'user_id' => 1
            ]
        );*/

        $album = new Album();
        $album->album_name = $name;
        $album->description = request()->input('description');
        $album->user_id = 1;
        $res = $album->save();


        //dd(request()->all());
        /*$data = request()->only(['name','description']);
        $data['user_id'] = 1;
        $sql = 'INSERT INTO albums (album_name, description, user_id)';
        $sql .= ' VALUES (:name, :description, :user_id)';
        $res = DB::insert($sql, $data);
        //$res ritorna true o false se la query insert e' andata a buon fine o meno
        $messaggio = $res ? 'Album "'.$data['name'].'" creato' : 'Album "'.$data['name'].'" NON creato';
        */

        $messaggio = $res ? 'Album "'.$name.'" creato' : 'Album "'.$name.'" NON creato';

        session()->flash('message', $messaggio);
        return redirect()->route('albums');
    }

}
