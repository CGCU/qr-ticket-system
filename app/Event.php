<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

  public static $rules = [
    // Validation rules
  ];
  protected $fillable = ["name", "date"];
  protected $dates = ["date"];

  public function tickets() {
    return $this->hasMany("App\Ticket");
  }

  public function union_products() {
    return $this->hasMany("App\UnionProduct");
  }

}
