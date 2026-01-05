<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, Notifiable;
    protected $fillable = ['user_id'];

    // Tambahkan ini di dalam class Order di Models/Order.php
    public function getStatusColorAttribute()
    {
        

        return match($this->status) {
            'pending'   => 'warning',
            'completed' => 'success',
            'cancelled' => 'danger',
            default     => 'primary',
        };
    }
}
