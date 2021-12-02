<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    //
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Event::whereDate('inicio','>=',$request->start)->whereDate('fin','<=',$request->end)->get(['id','titulo','inicio','fin']);

            return response()->json($data);
        }
        return view('calendario');
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
        }
    }
}
