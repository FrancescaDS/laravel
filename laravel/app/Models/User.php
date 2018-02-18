<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Album;
use App\Models\AlbumCategory;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role'
    ];

    //indica che questi campi devono essere date (tipo carbon)
    // e qundi applicabili i formati
    //se no li vede come stringhe
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function getFullNameAttribute()
    {
        //se ci fosse anche il cognome si potrebbe concatenare qui
        return $this->name;
    }

    public function albumCategories()
    {
        return $this->hasMany(AlbumCategory::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
