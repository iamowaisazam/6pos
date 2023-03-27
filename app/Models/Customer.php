<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transection;
use App\Models\SaleInvoice;


class Customer extends Model
{
    use HasFactory;

    public function orders()
    {
        return $this->hasMany(Order::class,'user_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    

}
