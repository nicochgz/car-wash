<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
	protected $table = "tiposervicio";
	protected $primaryKey = "idtiposervicio";
	public $timestamps = false;
}