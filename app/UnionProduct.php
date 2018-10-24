<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UnionProduct extends Model {

  public static $rules = [
    // Validation rules
  ];
  protected $fillable = ["id", "last_imported"];
  protected $dates = ['last_imported'];

  public function event() {
    return $this->belongsTo("App\Event");
  }


}
