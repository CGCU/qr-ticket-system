<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

  protected $fillable = ["name", "date"];

  protected $dates = ["date"];

  public static $rules = [
    // Validation rules
  ];

  public function tickets() {
    return $this->hasMany("App\Ticket");
  }

  public function union_products() {
    return $this->hasMany("App\UnionProduct");
  }

}
