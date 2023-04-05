<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = 'tipos';


    public function usuario()
    {
        return $this->hasMany('App\Usuario', 'tipodocumento', 'id');
    }


    public function detalledocumento()
    {
        return $this->hasMany('App\Detalledocumento', 'tipo_id', 'id');
    }

}
