<?php
use object\Users;
use object\DiscordBot;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Заголовки
header("Access-Control-Allow-Origin: http://authentication-jwt/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Подключение к БД
// Файлы, необходимые для подключения к базе данных
include_once $_SERVER['DOCUMENT_ROOT']."/API/Config/Database.php";
include_once $_SERVER['DOCUMENT_ROOT']."/API/Objects/DiscordBot.php";
include_once $_SERVER['DOCUMENT_ROOT']."/API/Objects/Users.php";

// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "Discipline"
$users = new Users($db);
$bot = new DiscordBot($db);
$discordId = $_GET['discordId'];
$matchId = $_GET['matchId'];
$username = $_GET['username'];

$users->discordId = $discordId;
$users->username = $username;

$users->registerDate = date("Y-m-d H:i:s");
$bot->date = date("Y-m-d H:i:s");
//echo $users->registerDate;
if($users->userExistDiscord() === false) {
    $users->createUsersDiscord();
}
$bot->matchUserId = $discordId;
$bot->matchMatchId = $matchId;


if(!$bot->GetMatchUsers()) {
    if($bot->SetMatchUsers()) {
        // Устанавливаем код ответа
        http_response_code(200);

        // Выведем массив стран
        echo json_encode(
            array(
                "message" => "**Match #".$matchId."**".PHP_EOL."You have successfully registered!"
            ), JSON_UNESCAPED_UNICODE
        );
    }
}
else {
    // Устанавливаем код ответа
    http_response_code(200);

    // Выведем массив стран
    echo json_encode(
        array(
            "message" => "**Match #".$matchId."**".PHP_EOL."You are already registered to this match!"
        ), JSON_UNESCAPED_UNICODE
    );
}


