<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    // Specify the table associated with the model (optional if table name is pluralized)
    protected $table = 'donations';

    // Specify which attributes should be mass assignable
    protected $fillable = [
        'name',
        'email',
        'school_name',
        'city',
        'state',
        'zip_code',
        'plan',
        'amount',
        'payment_status',
        'transaction_id',
    ];


}
