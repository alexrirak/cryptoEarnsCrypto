<?php

namespace App\Models;

use App\Mail\MagicLoginLink;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'provider',
        'provider_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'isAdmin',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'isAdmin' => 'boolean'
    ];

    /**
     * Indicates whether the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * User constructor. Sets id to a uuid on creation
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->id = (string) Str::uuid();
    }

    /**
     * Association with LoginToken
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loginTokens()
    {
        return $this->hasMany(LoginToken::class);
    }

    /**
     * Returns two initials based on the user's name
     * @return string
     */
    public function initials(): string
    {
        $words = explode(" ", $this->name );
        $initials = null;
        $initials .= $words[0][0];
        if(count($words) > 1)
            $initials .= $words[count($words)-1][0];
        return Str::upper($initials);
    }

    public function sendLoginLink()
    {
        $plaintext = Str::random(32);
        $token = $this->loginTokens()->create([
                                                  'token' => hash('sha256', $plaintext),
                                                  'expires_at' => now()->addMinutes(15),
                                              ]);

        Mail::to($this->email)->queue(new MagicLoginLink($plaintext, $token->expires_at));
    }
}
