<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class UserApiController extends Controller {


	public function actionLogin(Request $request) {

	    header('Content-Type: application/json; charset=utf-8');

	    $name = strtoupper(rtrim(ltrim(request('usuario'))));
	    $password = strtoupper(rtrim(ltrim(request('password'))));

	    if($name == '' or $password == ''){
            return response()->json([
                'mensaje' => 'El nombre o password no debe ser vacia'
            ], 401); 
	    }

		$tusuario 	= 	User::whereRaw('UPPER(name)=?', [$name])
						->where('activo', '=', 1)
						->first();

		if (count($tusuario) > 0) {
	    	$clavedesifrada = strtoupper(Crypt::decrypt($tusuario->password));
	    	if ($clavedesifrada == $password) {

				$tokenResult = $tusuario->createToken('Personal Access Token');

		        $token = $tokenResult->token;
		        $token->expires_at = Carbon::now()->addMinute(1);
		        $token->save();


				$responsecode = 200;
			    $header = array (
		            'Content-Type' 	=> 'application/json; charset=UTF-8',
		            'charset' 		=> 'utf-8'
		        );
		        
		        return response()->json(['usuario' => $tusuario , 'access_token' => $tokenResult->accessToken], 
		        							$responsecode, 
		        							$header, 
		        							JSON_UNESCAPED_UNICODE);
	    	}else{
	    		return response()->json([
	                'mensaje' => 'Usuario o clave incorrecto'
	            ], 401); 
	    	}
		}else{
            return response()->json([
                'mensaje' => 'Usuario o clave incorrecto'
            ], 401); 		
		}
	}


}
