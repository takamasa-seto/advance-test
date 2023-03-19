<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = ['fullname', 'gender', 'email', 'postcode', 'address', 'building_name', 'opinion'];

    public function scopeNameSearch($query, $name)
    {
        if (!empty($name)) {
            $query->where('fullname', 'like', '%' . $name . '%');
        }
    }

    public function scopeGenderSearch($query, $gender)
    {
        if (!empty($gender)) {  /* 0はemptyとなる */
            $query->where('gender', $gender);
        }
    }

    public function scopeEmailSearch($query, $email)
    {
        if (!empty($email)) {
            $query->where('email', 'like', '%' . $email . '%');
        }
    }

    public function scopeDateFromSearch($query, $from)
    {
        if (!empty($from)) {
            $query->where('created_at', '>', $from);
        }
    }

    public function scopeDateToSearch($query, $to)
    {
        if (!empty($to)) {
            $query->where('created_at', '<', $to);
        }
    }
}
