<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model {

  public static $rules = [
    // Validation rules
  ];
  protected $fillable = ["first_name", "last_name", "email", "login"];
  protected $dates = [];

  // Relationships

}
