<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branches';

    public function Branch()
    {
        return $this->hasOne('App\Models\UserData');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'branch_has_products');
    }
}
