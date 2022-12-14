<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'address',
        'job',
        'birthdate',
        'user_id',
        'code_bank',
        'phone_number',
        'gender',
        'cni',
        'passport_num',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
