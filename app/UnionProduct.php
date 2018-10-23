<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UnionProduct extends Model {

    protected $fillable = ["id", "last_imported"];

    protected $dates = ['last_imported'];

    public static $rules = [
        // Validation rules
    ];

    public function event()
    {
        return $this->belongsTo("App\Event");
    }


}
