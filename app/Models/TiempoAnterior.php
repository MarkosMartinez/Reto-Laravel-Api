<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiempoAnterior extends Model
{
    use HasFactory;
    protected $table = 'temperaturas_anteriores';
    protected $primaryKey = ['nombre', 'fecha'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'temperatura',
        'fecha',
    ];
}
