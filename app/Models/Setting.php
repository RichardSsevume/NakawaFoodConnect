<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Setting extends Model {
    public $timestamps = false; public $incrementing = false; protected $primaryKey = 'key'; protected $keyType = 'string'; protected $guarded = [];
    public static function get($k, $d = null) { return optional(static::find($k))->value ?? $d; }
    public static function put($k, $v) { static::updateOrCreate(['key' => $k], ['value' => $v]); }
}
