<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
  protected $table = "servicio";
  protected $primaryKey = 'idservicio';
  public $timestamps = false;
}