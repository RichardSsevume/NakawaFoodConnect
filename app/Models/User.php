<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable {
    use Notifiable;
    protected $guarded = [];
    protected $hidden = ['password', 'remember_token'];
    protected function casts(): array { return ['password' => 'hashed']; }
    public function vendor() { return $this->hasOne(Vendor::class); }
    public function notices() { return $this->hasMany(Notice::class); }
    public function orders() { return $this->hasMany(Order::class, 'student_id'); }
    public static function notify_user($id, $msg) { Notice::create(['user_id' => $id, 'message' => $msg]); }
}
