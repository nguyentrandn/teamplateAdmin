<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class WishListController extends BaseController
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $wish_list = WishList::where('user_id', $user_id)->get();
        return $this->sendResponse($wish_list, 'Get wish list success');
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
        ]);
        try {
            $user_id = auth()->user()->id;
            $wish_product = WishList::where('product_id', $request->product_id)->where('user_id', $user_id)->first();
            if ($wish_product) {
                $wish_product->delete();
                return $this->sendResponse('', 'Remove product in Wish List success');
            } else {
                $wishList = new WishList();
                $wishList->user_id =  $user_id;
                $wishList->product_id = $request->product_id;
                $wishList->save();
                return $this->sendResponse($wishList, 'Add product in Wish List success');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return $this->sendError("Update wish fail");
        }
    }
}
