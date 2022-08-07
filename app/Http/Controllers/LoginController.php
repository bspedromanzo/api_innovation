<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $loginAccess = DB::table('collaborators')->where('email', $request['email'])->first();

        if ($loginAccess) {
            if (Crypt::decrypt($loginAccess->password) == $request['password']) {
                return \Response::json(['code' => '200', 'message' => "Colaborador logado com sucesso!", 'token' => "eyJpdiI6IlZEbHIwNmRZTU5Yd0Vuck5ZVmlYNVE9PSIsInZhbHVlIjoiS0FidmVnYndjejVzR0kvRUpwM3Z6UzMzdmkydnJ3V0Nac0cxSUdiRmdCTT0iLCJtYWMiOiJhOWViMTRmNzg1Y2VkZWNjMzBmMzVmMDU4Mjk1MDE3NWU1NzczOTllMDI5YWNjN2I4YzY1YjM3ODM1NGM2MzFkIiwidGFnIjoiIn0=", 'id' => $loginAccess->id, 'type' => $loginAccess->type]);
            } else {
                return \Response::json(['code' => '400', 'message' => "Senha incorreta"]);
            }
        } else {
            return \Response::json(['code' => '400', 'message' => "Problemas na autentificação do usuário (E-mail e/ou senha invalido)"]);
        }

    }
}
