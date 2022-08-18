<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
	protected $table = "sucursal";
	protected $primaryKey = "idsucursal";
	public $timestamps = false;
}