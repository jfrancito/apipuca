<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Detalledocumento extends Model
{
    protected $table = 'detalledocumentos';

    public function usuarios()
    {
        return $this->belongsTo('App\Usuario', 'usuario_id', 'id');
    }

    public function tipo()
    {
        return $this->belongsTo('App\Tipo', 'tipo_id', 'id');
    }

}
