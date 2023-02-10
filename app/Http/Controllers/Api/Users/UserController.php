<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends BaseController
{
    public function profile()
    {
        $user = auth()->user();
        return $this->sendResponse($user, 'Show profile of user success');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $address = [
                'address1' => $request->address1,
                'address2' => $request->address2,
                'address3' => $request->address3,
            ];
            $user= auth()->user();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->vat_number = $request->vat_number;
            $user->address = json_encode($address);
            $user->save();
            return $this->sendResponse($user, 'Update success');
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return $this->sendError("Update fail");
        }
    }
}
