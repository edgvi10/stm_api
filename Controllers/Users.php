<?php

namespace Linkinfo;

use EDGVI10\DBWalker;
use EDGVI10\Helpers;

class Users
{
    public static function format($data)
    {
        $role = UsersRoles::list(["where" => ["param_`id`" => $data->role_id]]);

        $data->role_name = $role->users_roles[0]->name;

        return $data;
    }

    public static function insert($data, $debug = false)
    {
        global $mysql_access;
        $db = new DBWalker($mysql_access);
        $return["success"] = false;

        return $return;
    }

    public static function list($options, $debug = false)
    {
        global $mysql_access;
        $db = new DBWalker($mysql_access);
        $return["success"] = false;

        if ($debug) $return["debug"]["options"] = $options;

        $select_users_sql = $options;
        $select_users_sql["table"] = "`users`";

        $select_users = (object) $db->select($select_users_sql, $debug);

        if (!$select_users->success) :
            $return["message"] = "Falha ao buscar usuários";
            $return["debug"]["sql"] = $select_users;
        else :
            $users = [];
            foreach ($select_users->data as $row) :
                $row = self::format($row);

                $users[] = $row;
            endforeach;

            $return["success"] = true;
            $return["users"] = $users;
        endif;

        return (object) $return;
    }

    public static function update($uuid, $data, $debug = false)
    {
        global $mysql_access;
        $db = new DBWalker($mysql_access);
        $return["success"] = false;

        return $return;
    }
}
