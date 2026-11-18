<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model {
    protected $guarded = [];
    const FLOW = ['pending' => ['accepted', 'rejected'], 'accepted' => ['preparing'], 'preparing' => ['ready'], 'ready' => ['out_for_delivery'], 'out_for_delivery' => ['delivered']];
    public function student() { return $this->belongsTo(User::class, 'student_id'); }
    public function vendor() { return $this->belongsTo(Vendor::class); }
    public function hostel() { return $this->belongsTo(Hostel::class); }
    public function items() { return $this->hasMany(OrderItem::class); }
    public function history() { return $this->hasMany(OrderHistory::class)->latest('id'); }
    public function log($status, $uid) { $this->history()->create(['status' => $status, 'user_id' => $uid]); }
}
