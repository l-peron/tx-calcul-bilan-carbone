<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IdentityController
{
    public function getMe(Request $request)
    {
        $userAssos = $request->session()->get("assos");
        $userFullName = $request->session()->get("fullName");

        return [
            "assos" => $userAssos,
            "fullName" => $userFullName,
        ];
    }
}
