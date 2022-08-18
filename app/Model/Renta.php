<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Renta extends Model
{
	protected $table = "renta";
	protected $primaryKey = "idrenta";
	public $timestamps = false;
}