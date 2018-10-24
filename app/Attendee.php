<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendee extends Model {
  use SoftDeletes;

  public static $rules = [
    // Validation rules
  ];
  protected $fillable = ["first_name", "last_name", "email", "login"];
  protected $dates = ['deleted_at'];
}
