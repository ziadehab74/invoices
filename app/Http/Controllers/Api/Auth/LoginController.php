<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LoginController extends ApiController
{

    public function loginForm(Request $request)
    {
        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->failedResponse('', 'login failed');
        }
        $user = auth()->user()->id;
        $token = $request->user()->createToken("invoices")->plainTextToken;
        return $this->successResponse(['user' => auth()->user(), 'token' => $token], 'login succeed');
    }

}
