<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collaborator;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Crypt;

class CollaboratorController extends Controller
{
    public function index()
    {
        return Collaborator::all();
    }

    public function collaborator(Collaborator $collaborator)
    {
        return $collaborator;
    }

    public function createCollaborator(Request $request)
    {

        $create = false;
        $emailValidate = false;
        $data = $request->all();
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'type' => 'required'
        ];
        $validator = Validator::make($data, $rules);

        $emailVerify = DB::table('collaborators')
            ->where('email', $request['email'])->first();

        if ($emailVerify == NULL) {
            $emailValidate = true;
        }

        if ($validator->passes()) {
            if (!$emailValidate) {
                $message = \Response::json(['code' => '400', 'message' => "E-mail já cadastrado"]);
            } else {
                $create = true;
            }
        } else {
            $message = \Response::json(['code' => '400', 'message' => "Problemas nos dados cadastrais"]);
        }

        if ($create) {
            $collaborator = [
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Crypt::encrypt($request['password']),
                'type' => $request['type']
            ];

            Collaborator::create($collaborator);
            $message = \Response::json(['code' => '200', 'message' => "Colaborador criado com sucesso"]);
        }

        return $message;
    }

    public function updateCollaborator(Request $request)
    {
        $collName = isset($request['name']);
        $collEmail = isset($request['email']);
        $pass = isset($request['password']);
        $collType = isset($request['type']);
        $id = isset($request['id']);
        $info = [];
        $campo = false;
        $message = "";

        if ($id) {
            if ($collName) {
                $info['name'] = $request['name'];
                $campo = true;
            }

            if ($collEmail) {
                $info['email'] = $request['email'];
                $campo = true;
            }

            if ($pass) {
                $info['password'] = Crypt::encrypt($request['password']);
                $campo = true;
            }

            if ($collType) {
                $info['type'] = $request['type'];
                $campo = true;
            }

            if ($campo) {
                DB::table('collaborators')->where('id', $request['id'])->update($info);
                $message = \Response::json(['code' => '200', 'message' => "Colaborador atualizado com sucesso!"]);
            } else {
                $message = \Response::json(['code' => '400', 'message' => "Nenhum campo de alteração foi preenchido!"]);
            }
        } else {
            $message = \Response::json(['code' => '400', 'message' => "ID do colaborador não informado!"]);
        }

        return $message;
    }

    public function deleteCollaborator(Request $request)
    {
        $id = isset($request['id']);
        if ($id) {
            DB::table('collaborators')->where('id', $request['id'])->delete();
            $message = \Response::json(['code' => '200', 'message' => "Colaborador deletado com sucesso!"]);
        } else {
            $message = \Response::json(['code' => '400', 'message' => "ID do colaborador não informado!"]);
        }

        return $message;
    }

    public function updatePassword(Request $request)
    {
        $id = isset($request['id']);
        if ($id) {
            $collaborator = DB::table('collaborators')->where('id', $request['id'])->first();
            $passDB = Crypt::decrypt($collaborator->password);
            $newPass = $request['newPass'];
            $oldPass = $request['oldPass'];

            if ($passDB == $oldPass) {
                $cryptNewPass = Crypt::encrypt($newPass);
                DB::table('collaborators')->where('id', $request['id'])->update(["password" => $cryptNewPass]);
                $message = \Response::json(['code' => '200', 'message' => "Senha alterada com sucesso!"]);
            } else {
                $message = \Response::json(['code' => '400', 'message' => "Senha atual não é igual a do sistema"]);
            }
            
        } else {
            $message = \Response::json(['code' => '400', 'message' => "ID do colaborador não informado!"]);
        }

        return $message;
    }
}
