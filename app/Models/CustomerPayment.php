<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    use HasFactory;

    protected $table = 'payment_history';
    protected $primaryKey = 'id';
    protected $fillable = ['owner_name', 'iban', 'customer_id'];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
