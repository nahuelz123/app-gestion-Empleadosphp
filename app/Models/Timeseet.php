<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeseet extends Model
{
    use HasFactory;

    protected $guarded = [];
    
 /*    protected $fillable = [
        'calendar_id',
        'user_id',
        'type',
        'day_in',
        'day_out',
    ]; */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }
}
