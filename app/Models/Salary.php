<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    const STATUS_PAID = 1;
    const STATUS_UN_PAID = 0;

    protected $table = 'salary';

    protected $fillable = [
        'user_id',
        'status', // 1: paid, 0: unpaid
        'salary',
        'month',
        'created_at',
        'updated_at'
    ];
}
