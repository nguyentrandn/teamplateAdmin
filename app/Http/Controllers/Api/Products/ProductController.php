<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\PaginateResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function latest_product(Request $request)
    {
        $branch_id = config('apps.common.branch.JHB');
        $paginate_size = $request->paginate_size ? $request->paginate_size : 5;
        $products = new Product();
        $products = $products->where('product_status',config('apps.common.visibility_status.show'));
        $products = $products->orderBy('created_at', 'desc');
        $products = $products->whereHas('branches',function ($query)use($branch_id) {
            $query->where('branches.id', $branch_id);
        });
        $products = $products->with(['productPrice' => function($q) use($branch_id) {
            $q->where('branch_id', $branch_id);
        }])->paginate($paginate_size);
        return $this->sendResponse(new PaginateResource($products), 'list product');
    }
}