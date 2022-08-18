<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
  protected $table = "producto";
  protected $primaryKey = 'idproducto';
  public $timestamps = false;
}