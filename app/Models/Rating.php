<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Rating extends Model {
    protected $fillable=['maintenance_request_id','customer_id','rating','comment'];
    public function maintenanceRequest():BelongsTo{return $this->belongsTo(MaintenanceRequest::class);}
    public function customer():BelongsTo{return $this->belongsTo(Customer::class);}
}
