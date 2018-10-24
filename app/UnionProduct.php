<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnionProduct extends Model {
  use SoftDeletes;

  public static $rules = [
    // Validation rules
  ];
  protected $fillable = ["id", "last_imported"];
  protected $dates = ['last_imported', 'deleted_at'];

  public function event() {
    return $this->belongsTo("App\Event");
  }


}
