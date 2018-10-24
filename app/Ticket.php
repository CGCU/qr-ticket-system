<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model {
  use SoftDeletes;

  public static $rules = [
    // Validation rules
  ];
  protected $fillable = ["qr", "email_sent", "order_number"];
  protected $dates = ['deleted_at'];

  public function event() {
    return $this->belongsTo("App\Event");
  }

  public function purchaser() {
    return $this->belongsTo("App\Attendee");
  }

  public function attendee() {
    return $this->belongsTo("App\Attendee");
  }

  public function union_product() {
    return $this->belongsTo("App\UnionProduct");
  }
}
