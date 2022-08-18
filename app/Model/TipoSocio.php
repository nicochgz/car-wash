<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class TipoSocio extends Model
{
  protected $table = "tiposocio";
  protected $primaryKey = 'idtiposocio';
  public $timestamps = false;
}