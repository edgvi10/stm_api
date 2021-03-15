<?php

use EDGVI10\Helpers;
use Linkinfo\Users;
use Slim\Http\Request;
use Slim\Http\Response;

$app->group("/login", function ($app) {
    $app->post("", function (Request $request, Response $response, $argd) {
        $return["success"] = false;

        $data = (object) $request->getParsedBody();

        $select_users["where"]["param_`username`"] = $data->username;
        $select_users["where"]["param_`password`"] = md5($data->password);

        $select_users = Users::list($select_users, true);

        if (count($select_users->users) === 0) :
            $return["message"] = "Combinação usuário e senha inválida";
        else :
            $user = $select_users->users[0];
            if (!$user->active) :
                $return["message"] = "Usuário bloqueado";
            else :
                $user_data = [];
                $user_data["token"] = Helpers::base64url_encode($user->uuid . ";" . date("YmdHis"));

                $user_data["name"] = $user->name;
                $user_data["nickname"] = $user->nickname;
                $user_data["role_name"] = $user->role_name;
                $user_data["email"] = $user->email;
                $user_data["phone"] = $user->phone;
                $user_data["permissions"] = explode(",", $user->permissions);

                $return["success"] = true;
                $return["user"] = $user_data;
            endif;
        endif;

        return $response->withJson($return, 200);
    });
});
