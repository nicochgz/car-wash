<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Estacion extends Model
{
  protected $table = "estacion";
  protected $primaryKey = 'idestacion';
  public $timestamps = false;
}