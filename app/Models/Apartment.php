<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//trait
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use HasFactory;
    //importo il metodo del soft delete
    use SoftDeletes;

    protected $guarded = [
        '_token',
    ];

    //full_cover_img
    public function getFullCoverImgAttribute() {
        // Se c'è una cover_img
        if ($this->cover_img) {
            // Allora mi restituisci il percorso completo
            return asset('storage/'.$this->cover_img);
        } else {
            return null;
        }
    } 

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function services() {
        return $this->belongsToMany(Service::class);
    }

    public function sponsors() {
        return $this->belongsToMany(Sponsor::class);
    }

    public function views()
    {
         return $this->hasMany(View::class);
    }

    public function contacts()
    {
         return $this->hasMany(Contact::class);
    }

}
