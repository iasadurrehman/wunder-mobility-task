<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $fillable = ['id', 'firstName', 'lastName', 'telephone', 'address', 'zip', 'city'];

    public function customerPayment() {
       return $this->hasMany(CustomerPayment::class, 'customer_id', 'id');
    }
}
