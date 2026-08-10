<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
class User extends Authenticatable {
    use Notifiable;
    protected $fillable=['name','email','password','role'];
    protected $hidden=['password','remember_token'];
    public function maintenanceRequests():HasMany{return $this->hasMany(MaintenanceRequest::class,'technician_id');}
    public function isAdmin():bool{return $this->role==='admin';}
    public function isTechnician():bool{return $this->role==='technician';}
}
