<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Photo;

class Album extends Model
{
    //nome classe = nome tabella al singolare con lettera maiuscola
    //tabella -> albums
    //clase -> Album
    //se il nome della tabella non corrisponde
    //si puo' aggiungere la proprieta' protected $table
    //protected $table = 'albums';

    //se la primaryKey non e' 'id'
    //protected $primaryKey = 'nomechiave';

    protected $table = 'albums';
    protected $primaryKey = 'id';
    protected $fillable = ['album_name','description','user_id'];

    //public function get Path Attribute()
    //creo cosi' il nuovo attributo/proprieta' $path
    public function getPathAttribute(){
        $url = $this->album_thumb;
        if(stristr($url,'http')===false){
            $url = 'storage/'.$url;
        }
        return $url;
    }

    //ritorna la relazione tra l'album e le foto
    public function photos(){
        //non serve indicare le chiavi perche' sono di default
        //$this->hasMany(Photo::class,'id','album_id');
        return $this->hasMany(Photo::class);
        //la relazione contraria e' belongsTo
    }


}