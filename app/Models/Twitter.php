<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Twitter extends Model
{
    use HasFactory;

    protected $table = 'twitter';

    protected $fillable = [
        'title',
        'link',
        'content_date'
    ];

    protected $dates = [
        'content_date'
    ];

    protected $casts = [
        'content_date' => 'date',
    ];

    /* FORMAT TANGGAL */
    public function getFormattedTwitterDateAttribute()
    {
        return Carbon::parse($this->content_date)->format('d F Y');
    }

    /* FORMAT TANGGAL CONTENT CREATED */
    public function getFormattedCreatedAttribute()
    {
        return $this->created_at->format('d F Y H:i');
    }
}