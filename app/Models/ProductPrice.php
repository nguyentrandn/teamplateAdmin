<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $table = 'product_prices';
    
    public function product()
    {
        $this->belongsTo(Product::class);
    }

    /**
     *  get dealer price attribute custom
     * 
     * @return price
     * */
    public function getDealerPriceAttribute()
    {
        return round( $this->attributes['dealer_price'], 2 );
    }

    /**
     *  get retailer price attribute custom
     * 
     * @return price
     * */
    public function getRetailerPriceAttribute()
    {
        return round( $this->attributes['retailer_price'], 2 );
    }

    /**
     *  get customer price attribute custom
     * 
     * @return price
     * */
    public function getCustomerPriceAttribute()
    {
        return round( $this->attributes['customer_price'], 2 );
    }
}
