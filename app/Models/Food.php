<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Food extends Model {
    protected $table = 'foods'; protected $guarded = [];
    public function vendor() { return $this->belongsTo(Vendor::class); }
    public function category() { return $this->belongsTo(Category::class); }
}
