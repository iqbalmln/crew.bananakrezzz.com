<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class card extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function presensi()
    {
        return $this->belongsTo(presensi::class);
    }

    public function card()
    {
        return $this->belongsTo(card::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
