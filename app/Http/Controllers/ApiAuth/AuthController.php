<?php

namespace App\Http\Controllers\ApiAuth;

use App\Http\Controllers\Controller;
use App\User;
use App\Comentarios;
use Facade\FlareClient\Http\Client;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function guardarComentario(Request $request)
    {
        $id = Auth::id();
        $user = new User();
        $user = User::find($id);
        if ($request->user()->tokenCan('user:info') || $request->user()->tokenCan('admin:admin'))
            $comm = new Comentarios();
            $comm->titulo = $request->titulo;
            $comm->comentario = $request->comentario;
            $comm->users_id = $request->usuario;
            $comm->producto_id = $request->producto;
        if ($comm->save()) {
            $respuesta = Http::post('http://192.168.43.61:8000/api/comentario', [
                'titulo'=>$request->titulo,
                'comentario'=>$request->comentario,
                'users_id'=>$request->usuario,
                'producto_id'=>$request->producto,]);
            $mail = app('App\Http\Controllers\Mail\MailController')->comentarioSalvado();
            return response()->json(["comentario" => $comm], 201);
        }
        return response()->json(null, 400);
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if(! $user || ! Hash::check($request->password, $user->password))
        {
            throw ValidationException::withMessages([
                'email|password' => ['Credenciales incorrectas...']
            ]);
        }
        $token = $user ->createToken($request->email,['user:info'])->plainTextToken;
        $respuesta = Http::post('http://192.168.137.21:8000/api/login',['email'=>$request->email,
        'password'=> $request->password]);
        $request->merge(['to' => $token]);
        $mail = app('App\Http\Controllers\Mail\MailController')->Inicio($request)->getOriginalContent();
        return response()->json(["token"=>$token],201);
    }

    public function registro(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required'
        ]);
        $client = new GuzzleHttpClient();
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
       
        if ($user->save()){
            // enviar correo
            $respuesta = Http::post('http://192.168.137.21:8000/api/registro', [
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>$request->password,]);
            $mail = app('App\Http\Controllers\Mail\MailController')->enviaCorreo($request)->getOriginalContent();
            return response()->json(["Usuario"=>$user, "respuesta"=>$respuesta->getBody()],202);
        }
        return abort(422, "fallo al insertar");


    }
}
