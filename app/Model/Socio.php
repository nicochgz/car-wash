<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
  protected $table = "socio";
  protected $primaryKey = 'idsocio';
  public $timestamps = false;
}