<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property int $hecha
 * @property \Carbon\Carbon $fecha_limite
 * @property string $imagen
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class Tarea extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'tareas';
    public $fillable = ['titulo', 'descripcion', 'hecha', 'fecha_limite', 'imagen'];
    public $dates = ['fecha_limite'];

    public const HECHA = 1, HECHA_NO = 0;
    public const ESTADOS_HECHA = ['Sin hacer', 'Hecha'];

    public const VALIDACIONES =
        [
            'titulo'        => 'required|min:6|max:100',
            'descripcion'   => 'nullable|max:1000',
            'fecha_limite'  => 'nullable|date_format:Y-m-d\\TH:i:s',
            'imagen'        => 'nullable|file|mimes:jpg,png',
        ];
}
