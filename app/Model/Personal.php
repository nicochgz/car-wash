<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
  protected $table = "personal";
  protected $primaryKey = 'idpersonal';
  public $timestamps = false;
}