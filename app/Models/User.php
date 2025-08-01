<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Validation\Rule;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'bio',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the validation rules for the username.
     *
     * @return array
     */
    public static function getUsernameValidationRules()
    {
        $forbiddenUsernames = [
            'dashboard', 'home', 'login',
            'register', 'link', 'links', 
            'stats', 'profile'
        ];

        return  [  
            'required',
            'string', 
            'max:255', 
            Rule::unique('users')->ignore(auth()->id()),
            Rule::notIn($forbiddenUsernames),
            'regex:/^[a-zA-Z0-9._]+$/'
        ];
    }

    /**
     * Relationship with View model.
     *
     * @return void
     */
    public function views()
    {
        return $this->hasMany(View::class);
    }

    /**
     * Relationship with Link model.
     *
     * @return void
     */
    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function linkImpression(){
        return $this->hasMany(LinkImpression::class);
    }
}
