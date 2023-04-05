<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    public function tipodoc()
    {
        return $this->belongsTo('App\Tipo', 'tipodocumento', 'id');
    }


    public function detalleaccion()
    {
        return $this->hasMany('App\Detalledocumento', 'usuario_id', 'id');
    }



    public function scopeFechaDesde($query,$fechadesde){
        if(trim($fechadesde) != ''){
            $query->where('fechacrea', '>=', $fechadesde);
        }
    }
    public function scopeFechaHasta($query,$fechahasta){
        if(trim($fechahasta) != ''){
            $query->where('fechacrea', '<=', $fechahasta);
        }
    }

}




