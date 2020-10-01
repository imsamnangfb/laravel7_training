<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $table = 'roles';
	protected $fillable = [
		'name','slug','status'
    ];
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
