<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transection extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
