<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Image;
use App\Models\Store;
use App\Models\Panier;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\UserRegisteredNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'email',
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

    //-- Relation One To Many (Un user avec un role)----
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    //-- Relation One To One (Polymorph) (Un user avec une image) --
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    //-- Relation One To Many (Un User avec plusieurs panier) --
    public function paniers()
    {
        return $this->hasMany(Panier::class);
    }

    //-- Relation One To Many (Un User avec plusieurs Boutique) --
    public function stores_()
    {
        return $this->hasMany(Store::class);
    }

    //-- Relation Many To Many (Un User peut utiliser Plusieurs Store) --
    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_user', 'user_id', 'store_id');
    }

       //-- Ajouter un Utilisateur ----------
       public function saveUser($request) {
        $user = new User;

        $user->role_id = (int) $request->role;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->notify(new UserRegisteredNotification());

        return true;
    }

    //-- Modifier un Utilisateur -------
    public function updateUser($request, $id)
    {
        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->password;
        $user->save();

        return true;
    }

    //-- modifier password --
    public function updatePassword($reques, $id)
    {
        $user = User::where('id', $id)
                    ->update([
                        'password' => Hash::make($request->password)
                    ]);
        return true;
    }

}
