<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use SoftDeletes;
    protected $fillable = [
         'user_id',
        'code',
        'name',
        'phone_number',
        'table_number',
        'payment_method',
        'total_price',
        'status',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = Auth::user();
            if ($user && $user->role === 'store') {
                 $model->user_id = $user->id;
            }
        });

        static::updating(function ($model) {
            $user = Auth::user();
            if ($user && $user->role === 'store') {
                $model->user_id = $user->id;
            }
        });
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
