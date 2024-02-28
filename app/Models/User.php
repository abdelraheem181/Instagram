<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'bio',
        'url',
        'status',
        'password',
        'language',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
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
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function posts()
      {
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
      }

      public function comments()
      {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'DESC');
      }
      public function follows()
      {
          return $this->belongsToMany(User::class, 'follows', 'user_id', 'following_user_id');
      }
      public function followers()
      {
          return $this->belongsToMany(User::class, 'follows', 'user_id', 'following_user_id');
      }
      public function following(User $user)
      {
          return $this->follows()->where('following_user_id', $user->id)->exists();
      }
      public function setAccepted(User $user)
      { 
        if ($user->status == "public"){
          DB::table('follows')
          ->where('user_id', $this->id)
          ->where('following_user_id', $user->id)
          ->update([
              'accepted' => true,

          ]);
        }
       
      }
      public function accepted(User $user)
      {
          if ($this->status == "public") {
              return true;
          } 
          else {
              return (bool) DB::table('follows')
                  ->where('user_id', $user->id)
                  ->where('following_user_id', $this->id)
                  ->where('accepted', true)->count();
          }
      }
      public function FollowReq()
      {
          if ($this->status == "private") {
              return $this->followers()
                  ->where('following_user_id', $this->id)
                  ->where('accepted', false)
                  ->latest()->paginate(5);
          }
          return null;
      }
      public function pendingFollowReq()
      {
          return $this->follows()
              ->where('user_id', $this->id)
              ->where('accepted', false)
              ->latest()->paginate(5);
      }
     public function followingAndAccepted(User $user)
     {
        return $this->follows()->where('following_user_id', $user->id)->where('accepted', true)->exists();
     }

     public function toggleAccepted(User $user, $state)
     {
         return DB::table('follows')
             ->where('user_id', $user->id)
             ->where('following_user_id', $this->id)
             ->update([
                 'accepted' => $state,
             ]);
     }
     public function home()
     {
        $ids = $this->follows()->where('accepted', true)->get()->pluck('id');
        return Post::whereIn('user_id', $ids)->latest()->paginate(9);
     }
     public function iFollow()
     {
        return $this->follows()
        ->where('user_id',$this->id)
        ->where('accepted',true)
        ->latest()->get();
     }
     public function otherUsers()
     {
       
       $ifollow = $this->iFollow()->pluck('id')->toArray();
       $pendingFollow = $this->pendingFollowReq()->pluck('id')->toArray();
       array_push($ifollow,$this->id);
       $others = array_merge($ifollow, $pendingFollow);
       return User::whereNotIn('id' , $others)->latest()->get();

     }

   
     public function explore()
     {
        $ifoll = $this->iFollow()->pluck('id')->toArray();
        array_push($ifoll, $this->id);
        $public = User::where('status', 'public')->pluck('id')->toArray();
        $others = array_merge($ifoll,$public);

        return Post::whereNotIn('user_id', $others)->latest()->paginate(9);
     }
    
  
    }