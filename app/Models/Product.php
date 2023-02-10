<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_has_products');
    }

    public function productPrice()
    {
       return $this->hasOne(ProductPrice::class);
    }


    public function UsedProductPrice()
    {
        return $this->hasOne('App\Models\UsedProductPrice');
    }

    public function prodcuQty()
    {
       return $this->hasOne('App\Models\ProductQuantity');
    }

    public function UsedProductQuantity()
    {
        return $this->hasOne('App\Models\UsedProductQuantity');
    }

    public function prodcuTaxs()
    {
       return $this->hasOne('App\Models\ProductTax');
    }

    public function prodcuTaxsLog()
    {
       return $this->hasMany('App\Models\Logs\TaxLog');
    }

    public function prodcuPricesLog()
    {
       return $this->hasMany('App\Models\Logs\PriceLog');
    }

    public function prodcuQuantitiesLog()
    {
       return $this->hasMany('App\Models\Logs\QuantityLog');
    }

    public function ProductVideo()
    {
        return $this->hasOne('App\Models\ProductVideo');
    }



    public function admin()
    {
        return $this->belongsTo('App\Admin');
    }

    public function Category()
    {
        return $this->belongsTo('App\Models\Category');
    }

   public function productLink()
   {
       return $this->hasOne('App\Models\ProductLink');
   }

}
