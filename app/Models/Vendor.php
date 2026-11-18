<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Vendor extends Model {
    protected $guarded = [];
    public function user() { return $this->belongsTo(User::class); }
    public function foods() { return $this->hasMany(Food::class); }
    public function orders() { return $this->hasMany(Order::class); }
    public function getRouteKeyName() { return 'slug'; }
}
