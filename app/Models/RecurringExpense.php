<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringExpense extends Model
{
    use HasFactory;



    protected $fillable = [
        'amount', 'frequency', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
