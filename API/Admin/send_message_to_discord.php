<?php
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

// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "Discipline"
$match = new DiscordBot($db);

// Получаем данные
$data = json_decode(file_get_contents("php://input"));

// Устанавливаем значения
$match->matchId = $_GET['id'];

$arr = $match->GetMatchArray($_GET['id']);

if($arr[0]['message_id'] === null) {
    $match->SendMessageDiscord("!addNewMatch ".$_GET['id']);
    // Покажем сообщение о том, что пользователь был создан
    echo json_encode(
        array(
            "message" => "Матч успешно опубликован в Дискорде"
        )
    );
}
else {
    $match->UpdateMessageDiscord();
    // Покажем сообщение о том, что пользователь был создан
    echo json_encode(
        array(
            "message" => "Матч успешно обновлен в Дискорде"
        )
    );
}


http_response_code(200);

