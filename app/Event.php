<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model {
  use SoftDeletes;

  public static $rules = [
    // Validation rules
  ];
  protected $fillable = ["name", "date"];
  protected $dates = ["date", 'deleted_at'];

  public function tickets() {
    return $this->hasMany("App\Ticket");
  }

  public function union_products() {
    return $this->hasMany("App\UnionProduct");
  }

}
