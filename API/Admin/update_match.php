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
$match->matchStartDate = $data->start_date;
$match->matchRegStartDate = $data->reg_start_date;
$match->matchRegEndDate = $data->reg_end_date;
$match->matchStatus = $data->status;
$match->matchMatchId = $_GET['id'];

$match->date_modified = date("Y-m-d H:i");

// Поверка на существование e-mail в БДa
// $email_exists = $user->emailExists();

// Создание пользователя
if (
    !empty($match->matchStartDate) &&
    !empty($match->matchRegStartDate) &&
    !empty($match->matchRegEndDate) &&
    !empty($match->matchStatus) &&
    $match->UpdateMatch()
) {
    $list_users = [];
    if($match->matchStatus == "completed") {
        $list_users = $match->getListUsersScore();
    }
    // Устанавливаем код ответа
    http_response_code(200);

    // Покажем сообщение о том, что пользователь был создан
    echo json_encode(
        array(
            "message" => "Матч успешно Обновлен",
            "list" => $list_users
        )
    );
}

// Сообщение, если не удаётся создать пользователя
else {

    // Устанавливаем код ответа
    http_response_code(400);

    // Покажем сообщение о том, что создать пользователя не удалось
    echo json_encode(array("message" => "Невозможно обновить матч"));
}
