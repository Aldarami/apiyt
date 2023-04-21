<?php

namespace App\Http\Resources;

use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property \App\Models\Tarea $resource
 */
class TareaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $arreglo =
            [
                'id'            => $this->resource->id,
                'titulo'        => $this->resource->titulo,
                'descripcion'   => $this->resource->descripcion,
                'fecha_limite'  => $this->resource->fecha_limite,
                'hecha'         => $this->resource->hecha,
                'meta'  =>
                    [
                        'imagen'    => Storage::url( $this->resource->imagen ),
                        'hecha'     => Tarea::ESTADOS_HECHA[ $this->resource->hecha ],
                    ],
                'enlaces'   =>
                    [
                        $this->mergeWhen( $this->resource->hecha == Tarea::HECHA_NO,
                        [[
                            'type'      => 'PATCH',
                            'nombre'    => 'marcar_hecha',
                            'url'       => route('tarea.estado.hecha', [$this->resource, Tarea::HECHA], false),
                        ]] ),
                        $this->mergeWhen( $this->resource->hecha == Tarea::HECHA,
                        [[
                            'type'      => 'PATCH',
                            'nombre'    => 'marcar_hecha',
                            'url'       => route('tarea.estado.hecha', [$this->resource, Tarea::HECHA_NO], false),
                        ]] ),
                    ]
            ];
        return $arreglo;
    }
}
