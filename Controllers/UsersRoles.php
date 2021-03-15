<?php

namespace Linkinfo;

use EDGVI10\DBWalker;
use EDGVI10\Helpers;

class UsersRoles
{
    public static function format($data)
    {

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

        $select_users_roles_sql = $options;
        $select_users_roles_sql["table"] = "`users_roles`";

        $select_users_roles = (object) $db->select($select_users_roles_sql, $debug);

        if (!$select_users_roles->success) :
            $return["message"] = "Falha ao buscar níveis de usuário";
            $return["debug"]["sql"] = $select_users_roles;
        else :
            $users_roles = [];
            foreach ($select_users_roles->data as $row) :
                $row = self::format($row);

                $users_roles[] = $row;
            endforeach;

            $return["success"] = true;
            $return["users_roles"] = $users_roles;
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
