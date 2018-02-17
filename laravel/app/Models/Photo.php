<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Album;
use App\Models\User;

class Photo extends Model
{
    //ritorna la relazione tra la foto e l'album
    public function album(){
        //non serve indicare le chiavi perche' sono di default
        //$this->belongsTo(Album::class, 'album_id','id');
        return $this->belongsTo(Album::class);
        //la relazione contraria e' asMany
    }

    //public function get Path Attribute()
    //creo cosi' il nuovo attributo/proprieta' $path
    public function getPathAttribute(){
        $url = $this->image_path;
        if(stristr($url,'http')===false){
            $url = 'storage/'.$url;
        }
        return $url;
    }

    //ACCESSOR
    //manipola il valore dopo averlo letto
    //uso questa al posto di creare il nuovo attributo PATH qui sopra
    //manipolo il valore di image_path
    //le 2 parole separate da _ diventano una con le 2 maiuscole
    public function getImagePathAttribute($value){
        if(stristr($value,'http')===false){
            $value = 'storage/'.$value;
        }
        return $value;
    }

    //MUTATOR
    //modifica il valore dell'attributo 'name' prima di salvarlo
    public function setNameAttribute($value){
        $this->attributes['name'] = strtoupper($value);
    }

}
