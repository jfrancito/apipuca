<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Tipo;
use App\Usuario;
use App\Detalledocumento;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class UsuarioApiController extends Controller {


    public function actionListarActores() {

        header('Content-Type: application/json; charset=utf-8');
        $listausuaria  =        Usuario::select('id',
                                                'nombretipodocumento as tipo_documento',
                                                'dni',
                                                'nombres',
                                                'apellidos',
                                                'ruc',
                                                'razonsocial',
                                                'celular',
                                                'email',
                                                'ind_politica_de_datos',
                                                'ind_publicidad',
                                                'ind_migrar_tercero',
                                                'contrasenia',
                                                'fechacrea',
                                                'created_at')
                                ->with('detalleaccion:id,usuario_id,nombretipo')
                                ->whereIn('tipo', ['actores'])
                                ->where('activo','=',1)
                                ->orderBy('created_at', 'desc')
                                ->get();
                     
        $responsecode = 200;
        $header = array (
            'Content-Type'  => 'application/json; charset=UTF-8',
            'charset'       => 'utf-8'
        );

        return response()->json(    $listausuaria, 
                                    $responsecode, $header, JSON_UNESCAPED_UNICODE);

    }


    public function actionListarActoresxDniRuc($dniruc) {

        header('Content-Type: application/json; charset=utf-8');
        $listausuaria  =        Usuario::select('id',
                                                'nombretipodocumento as tipo_documento',
                                                'dni',
                                                'nombres',
                                                'apellidos',
                                                'ruc',
                                                'razonsocial',
                                                'celular',
                                                'email',
                                                'ind_politica_de_datos',
                                                'ind_publicidad',
                                                'ind_migrar_tercero',
                                                'contrasenia',
                                                'fechacrea',
                                                'created_at')
                                ->with('detalleaccion:id,usuario_id,nombretipo')
                                ->whereIn('tipo', ['actores'])
                                ->where('activo','=',1)
                                ->where('nombretipodocumento','=',$dniruc)
                                ->orderBy('created_at', 'desc')
                                ->get();

        if(count($listausuaria)<=0){
                return response()->json([
                    'mensaje' => 'Asociados no encontrado'
                ], 400); 
        }

        $responsecode = 200;
        $header = array (
            'Content-Type'  => 'application/json; charset=UTF-8',
            'charset'       => 'utf-8'
        );

        return response()->json(    $listausuaria, 
                                    $responsecode, $header, JSON_UNESCAPED_UNICODE);

    }





    public function actionListarActoresDni($dni) {

        header('Content-Type: application/json; charset=utf-8');

        $listatrabajadores  =       Usuario::where('activo','=',1)
                                    ->where('dni','=',$dni)
                                    ->whereIn('tipo', ['comprador','vendedor'])
                                    ->select('dni','nombres','apellidos','celular','celularwhatsapp','email','tipo','fechacrea','created_at')
                                    ->orderBy('tipo', 'desc')
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        if(count($listatrabajadores)<=0){
                return response()->json([
                    'mensaje' => 'Asociado no encontrado'
                ], 400); 
        }

        $responsecode = 200;
        $header = array (
            'Content-Type'  => 'application/json; charset=UTF-8',
            'charset'       => 'utf-8'
        );
        
        return response()->json($listatrabajadores, $responsecode, $header, JSON_UNESCAPED_UNICODE);

    }



    public function actionListarActoresTipoActor($tipoactor) {

        header('Content-Type: application/json; charset=utf-8');

        $listatrabajadores  =       Usuario::where('activo','=',1)
                                    ->where('tipo','=',$tipoactor)
                                    ->select('dni','nombres','apellidos','celular','celularwhatsapp','email','tipo','fechacrea','created_at')
                                    ->orderBy('tipo', 'desc')
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        if(count($listatrabajadores)<=0){
                return response()->json([
                    'mensaje' => 'Asociados no encontrado'
                ], 400); 
        }

        $responsecode = 200;
        $header = array (
            'Content-Type'  => 'application/json; charset=UTF-8',
            'charset'       => 'utf-8'
        );
        
        return response()->json($listatrabajadores, $responsecode, $header, JSON_UNESCAPED_UNICODE);

    }



	public function actionListarCompradores($fecha_desde,$fecha_hasta) {

	    header('Content-Type: application/json; charset=utf-8');


        $fecha_desde = date_format(date_create($fecha_desde), 'Ymd');
        $fecha_hasta = date_format(date_create($fecha_hasta), 'Ymd');

        $listatrabajadores  =       Usuario::where('activo','=',1)
                                    ->FechaDesde($fecha_desde)
                                    ->FechaHasta($fecha_hasta)
        							->whereIn('tipo', ['comprador'])
                                    ->select('dni','nombres','apellidos','celular','celularwhatsapp','email','tipo','fechacrea','created_at')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
		$responsecode = 200;
	    $header = array (
            'Content-Type' 	=> 'application/json; charset=UTF-8',
            'charset' 		=> 'utf-8'
        );
        
        return response()->json($listatrabajadores, $responsecode, $header, JSON_UNESCAPED_UNICODE);

	}


	public function actionListarVendedores($fecha_desde,$fecha_hasta) {

	    header('Content-Type: application/json; charset=utf-8');

        $fecha_desde = date_format(date_create($fecha_desde), 'Ymd');
        $fecha_hasta = date_format(date_create($fecha_hasta), 'Ymd');

        $listatrabajadores  =       Usuario::where('activo','=',1)
                                    ->FechaDesde($fecha_desde)
                                    ->FechaHasta($fecha_hasta)
        							->whereIn('tipo', ['vendedor'])
                                    ->select('dni','nombres','apellidos','celular','celularwhatsapp','email','tipo','fechacrea','created_at')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
		$responsecode = 200;
	    $header = array (
            'Content-Type' 	=> 'application/json; charset=UTF-8',
            'charset' 		=> 'utf-8'
        );
        
        return response()->json($listatrabajadores, $responsecode, $header, JSON_UNESCAPED_UNICODE);

	}


    public function actionPrueba() {


        $listausuaria  =        Usuario::select('id',
                                                'nombretipodocumento as tipo_documento',
                                                'dni',
                                                'nombres',
                                                'apellidos',
                                                'ruc',
                                                'razonsocial',
                                                'celular',
                                                'fechacrea',
                                                'created_at')
                                ->with('detalleaccion:id,usuario_id,nombretipo')
                                ->orderBy('created_at', 'desc')
                                ->get();
                     
        $responsecode = 200;
        $header = array (
            'Content-Type'  => 'application/json; charset=UTF-8',
            'charset'       => 'utf-8'
        );

        return response()->json(    $listausuaria, 
                                    $responsecode, $header, JSON_UNESCAPED_UNICODE);

        dd($listausuaria);
        // header('Content-Type: application/json; charset=utf-8');


        // $responsecode = 200;
        // $header = array (
        //     'Content-Type'  => 'application/json; charset=UTF-8',
        //     'charset'       => 'utf-8'
        // );
        
        // return response()->json('prueba', $responsecode, $header, JSON_UNESCAPED_UNICODE);

    }




}
