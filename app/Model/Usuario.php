<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
	protected $table = "usuario";
	protected $primaryKey = "idusuario";
	public $timestamps = false;
	public $remember_token = false;
	

	protected $fillable = [
		'email','password','idrol'
	];
}