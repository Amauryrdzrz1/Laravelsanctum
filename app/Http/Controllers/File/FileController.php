<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function guardarArchivo(Request $request){
        //sacar user con token
        $id=Auth::id();
        
        $user = new User();
        $user = User::find($id);

        $rutaArchivo = 'default';        
        if($user->email != null){
            $rutaArchivo = $user->email;
        }
        
        if($request->hasFile('archivo')){
            $path = Storage::disk('public')->put($rutaArchivo, $request->archivo);
            $respuesta = Http::post('http://192.168.137.21:8000/api/archivo', [
                'path'=>$request->path]);
            $request->merge(['path'=>$path]);
            $request->merge(['to'=>$user->email]);

            $mail = app('App\Http\Controllers\Mail\MailController')->EnviarArchivo($request)->getOriginalContent();

            return response()->json(["path"=>$request->path],201);
        }
        return response()->json(null,400);

    }

    public function descargaArchivo(Request $request){
        $id=Auth::id();
        $user = new User();
        $user = User::find($id);
        //return Http::get('http://192.168.137.21:8000/api/descarga')['path'=>$request->path];
        abort(401,'No existe el archivo');
    }
}
