<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\CorreoRegistro;
use App\Mail\DescargaArchivo;
use App\Mail\MandarArchivo;
use App\Mail\MandarToken;
use App\Mail\ComentarioSalvado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function enviaCorreo(Request $request){
        
        // Mail::to($request->user())->send(new CorreoRegistro());
        Mail::to('amauryrdzrz@gmail.com')->send(new CorreoRegistro($request->to));
        return response()->json(["to"=>$request->to], 200);
    }
    public function Inicio(Request $request){
        
        // Mail::to($request->user())->send(new CorreoRegistro());
        Mail::to('amauryrdzrz@gmail.com')->send(new MandarToken($request->to));
        return response()->json(["to"=>$request->to], 200);
    }
    public function EnviarArchivo(Request $request){
        
        // Mail::to($request->user())->send(new CorreoRegistro());
        Mail::to('amauryrdzrz@gmail.com')->send(new MandarArchivo($request->to,$request->path));
        return response()->json(["to"=>$request->to], 200);
    }
    public function DescargaArchivo(Request $request){
        
        // Mail::to($request->user())->send(new CorreoRegistro());
        Mail::to('amauryrdzrz@gmail.com')->send(new DescargaArchivo($request->to));
        return response()->json(["to"=>$request->to], 200);
    }
    public function comentarioSalvado(){
        
        // Mail::to($request->user())->send(new CorreoRegistro());
        Mail::to('amauryrdzrz@gmail.com')->send(new ComentarioSalvado());
    }
}
