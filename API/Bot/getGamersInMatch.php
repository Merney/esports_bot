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
include_once $_SERVER['DOCUMENT_ROOT']."/API/Objects/Users.php";
include_once $_SERVER['DOCUMENT_ROOT']."/API/Objects/DiscordBot.php";


// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "DiscordBot"
$users = new Users($db);
$match = new DiscordBot($db);

// Получаем данные

$users->matchId = $_GET['id'];

$participants = $users->getGamers();

/*
    TODO 
    получаю дисциплину, отправляю в GetGamers и получаю данные о рейтинге пользователей и вывожу в дискорд сообщение.
*/

$discipline = $match->GetMatchArray($_GET['id']);

$list = [];

for($i = 0; $i < count($participants['gamers']); $i++) {
    $list[$i] = $users->getUsers($participants['gamers'][$i]['user_id']);

}

// Устанавливаем код ответа
http_response_code(200);

// Выведем массив стран
echo json_encode(
    array(
        "participants" => $participants,
        "users" => $list,
        "score" => $participants['score']
        
    ), JSON_UNESCAPED_UNICODE
);