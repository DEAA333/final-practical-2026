<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Customer extends Model {
    protected $fillable=['name','email','phone','address'];
    public function maintenanceRequests():HasMany{return $this->hasMany(MaintenanceRequest::class);}
    public function ratings():HasMany{return $this->hasMany(Rating::class);}
}
