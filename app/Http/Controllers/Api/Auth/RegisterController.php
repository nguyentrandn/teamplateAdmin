<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RegisterController extends BaseController
{
    public function register(RegisterRequest $request)
    {
        try {
            $address = [
                'address1' => $request->address1,
                'address2' => $request->address2,
                'address3' => $request->address3,
            ];
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->vat_number = $request->vat_number;
            $user->address = json_encode($address);
            $user->branch_id = config('apps.common.branch.JHB');
            $user->customer_type_id = config('apps.common.customer_type.RETAILER');
            $user->save();
            return  $this->sendResponse($user, 'Register success');
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return $this->sendError("Register fail");
        }
    }
}
