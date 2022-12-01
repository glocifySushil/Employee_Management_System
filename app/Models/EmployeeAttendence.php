<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendence extends Model
{
    use HasFactory;
    protected $fillable = [
        'punch_in',
        'in',
        'punch_in_ip',
        'punch_in_out',
           
            'created_at',
            'updated_at',
    ];
}
