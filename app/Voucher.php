<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';
    protected $primary = 'id';
    public $timestamps = true;

    public static function rules()
    {
        return [
            'category' => 'required',
            'name'     => 'required',
            'purpose'  => 'required',
        ];
    }

    public function scopeStatus($query, $value)
    {
        return $query->where('status', '=', $value);
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'attended_by', 'id');
    }
}
