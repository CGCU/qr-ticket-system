<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model {

  protected $fillable = ["qr", "email_sent", "order_number"];

  protected $dates = [];

  public static $rules = [
    // Validation rules
  ];

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
