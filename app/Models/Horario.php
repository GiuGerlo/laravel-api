<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';

    protected $fillable = ['id_materia', 'id_teacher', 'day', 'start_time', 'end_time'];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id_materia');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'id_teacher');
    }
}
