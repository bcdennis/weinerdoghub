<?php

namespace Smile\Core\Persistence\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'confirmation_code',
        'avatar', 'smiles',
        'status',
        'blocked',
        'permission',

        // Cache fields
        'likes', 'dislikes', 'points', 'comments', 'posts',

        // Preferences
        'language', 'nsfw', 'last_comment',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Bind dates
     *
     * @var array
     */
    protected $dates = ['created_at'];

    /**
     * Get user activity
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity()
    {
        return $this->hasMany('Smile\Core\Persistence\Models\Activity')
            ->with(['post'])
            ->latest();
    }

    /**
     * User posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('Smile\Core\Persistence\Models\Post');
    }

    /**
     * Append url to the avatar url
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        $avatar = $this->attributes['avatar'];

        return $avatar;
    }

}
