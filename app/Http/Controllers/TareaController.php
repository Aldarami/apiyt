<?php

namespace App\Http\Controllers;

use App\Http\Requests\TareaRequest;
use App\Http\Resources\TareaResource;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request )
    {
        $query = Tarea::orderByDesc('id');
        $busqueda = $request->query('busqueda');
        if( $busqueda )
        {
            $query->where( 'titulo', 'like', "%{$busqueda}%" );
        }
        return TareaResource::collection( $query->paginate( $request->query('per_page') ) );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TareaRequest $request)
    {
        $datos = $request->validated();
        if( $request->file('imagen') )
        {
            $datos['imagen'] = $request->file('imagen')->store('public/imagenes');
        }
        $tarea = Tarea::create( $datos );
        $tarea->refresh();
        return TareaResource::make( $tarea );
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        return TareaResource::make( $tarea );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TareaRequest $request, Tarea $tarea)
    {
        if( $tarea->hecha == Tarea::HECHA )
        {
            return response()->json(['message' => __('No puedes actualizar una tarea hecha')], 400);
        }
        $datos = $request->validated();
        if( $request->file('imagen') )
        {
            if( $tarea->imagen );
            {
                Storage::delete( $tarea->imagen );
            }
            $datos['imagen'] = $request->file('imagen')->store('public/imagenes');
        }
        else
        {
            $datos['imagen'] = $tarea->imagen;
        }
        $tarea->update( $datos );
        return TareaResource::make( $tarea );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        $tarea->delete();
        return response()->json(['message' => __('Eliminao')], 200);
    }

    /**
     * Recupera el registro
     */
    public function restore( $tareaId )
    {
        $tarea = Tarea::withTrashed()->find( $tareaId );
        $tarea->restore();
        return TareaResource::make( $tarea );
    }


    /**
     * Cambia el estado de una tarea a realizada o no realizada
     *
     * @param Tarea $tarea
     * @param int $hecha
     */
    public function cambiarHecha( Tarea $tarea, int $hecha )
    {
        if( ! isset( Tarea::ESTADOS_HECHA[ $hecha ] ) )
        {
            return response()->json(['message' => __('Valor no válido')], 400);
        }
        $tarea->hecha = $hecha;
        $tarea->save();
        return TareaResource::make( $tarea );
    }
}
