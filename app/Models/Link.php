<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    /**
     * Fillable fields.
     *
     * @return void
     */
    protected $fillable = [
        'user_id',
        'title',
        'url',
        'order',
    ];
    
    /**
     * Relationship with Click model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function click() {
        return $this->hasMany(Click::class);
    }

    /**
     * Relationship with Click model (this week's clicks).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function thisWeekClicks()
    {
        return $this->hasMany(Click::class)
                    ->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
    }

    /**
     * Relationship with Click model (last week's clicks).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lastWeekClicks()
    {
        return $this->hasMany(Click::class)
                    ->whereBetween('created_at', [
                        Carbon::now()->subWeek()->startOfWeek(),
                        Carbon::now()->subWeek()->endOfWeek()
                    ]);
    }

    /**
     * Relationship with User model.
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
