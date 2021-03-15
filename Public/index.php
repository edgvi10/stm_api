<?php

error_reporting(E_ALL ^ E_NOTICE);

use EDGVI10\DBWalker;
use \Slim\App as App;
use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;

use \EDGVI10\Helpers;

require __DIR__ . "/../vendor/autoload.php";

Helpers::cors();

if (!file_exists(__DIR__ . "/../.env")) :
    header("Content-Type:application/json;charset=utf8");
    exit(json_encode([
        "sucess" => false,
        "message" => "No `.env` file found",
    ]));
else :
    $env = Helpers::getEnv(__DIR__ . "/../.env");

    $mysql_access = [
        $env->mysql_host,
        $env->mysql_user,
        $env->mysql_pass,
        $env->mysql_base,
    ];
endif;

define("ROOT_PATH", __DIR__ . "/../");
define("PUBLIC_PATH", __DIR__ . "/");
define("DEBUG", false);

setlocale(LC_TIME, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$config = ["settings" => ["displayErrorDetails" => true]];

$app = new App($config);

$app->get("[/]", function (Request $request, Response $response, array $args) {
    $return["success"] = true;
    $pkg = (object) json_decode(file_get_contents(__DIR__ . "/../composer.json"));

    $package["description"] = $pkg->description;
    $package["version"] = $pkg->version;
    $package["authors"] = $pkg->authors;

    $return["package"] = $package;

    return $response->withJson($return, 200);
});

include_once __DIR__ . "/../Routes/login.php";
$app->group("/{user_uuid}", function ($app) {
    // include_once __DIR__ . "/../Routes/_raw.php";
    // include_once __DIR__ . "/../Routes/siteinfo.php";
    // include_once __DIR__ . "/../Routes/navigation.php";
    // include_once __DIR__ . "/../Routes/pages.php";
    // include_once __DIR__ . "/../Routes/posts.php";
});
/* */
// Run application
$app->run();
