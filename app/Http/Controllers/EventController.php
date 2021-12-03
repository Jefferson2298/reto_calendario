<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    //
    public function index(Request $request){
        if ($request->ajax()) {
            $data = [];
            if ($request->start == null || $request->end == null) {
                $data = Event::all();
            }else{
                $data = Event::whereDate('inicio','>=',$request->start)->whereDate('fin','<=',$request->end)->get(['id','titulo','inicio','fin']);
            }
            $data_conv = $this->convertirDatosParaMostrar($data);

            return response()->json($data_conv);
        }
        return view('calendario');
    }

    private function convertirDatosParaMostrar($datos){
        $datos_convertidos = [];
        foreach ($datos as $key => $dato) {
            $dato_conv = [];
            $dato_conv['id'] = $dato->id;
            $dato_conv['title'] = $dato->titulo;
            $dato_conv['start'] = $dato->inicio;
            $dato_conv['end'] = $dato->fin;
            $datos_convertidos[$key] = $dato_conv;
        }
        return $datos_convertidos;
    }

    public function action(Request $request){
        if ($request->ajax()) {
            if ($request->tipo == 'add') {
                $event = Event::create([
                    'titulo'=>$request->titulo,
                    'inicio'=>$request->inicio,
                    'fin'=>$request->fin
                ]);
                return response()->json($event);
            }
            if ($request->tipo =='update') {
                $event = Event::find($request->id)->update([
                    'titulo'=>$request->titulo,
                    'inicio'=>$request->inicio,
                    'fin'=>$request->fin
                ]);
                return response()->json($event);
            }
        }
    }
}
