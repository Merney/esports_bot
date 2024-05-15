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

// Создание объекта "User"
$country = new DiscordBot($db);

// Получаем данные
$data = json_decode(file_get_contents("php://input"));

// Устанавливаем значения
$country->countryName = $data->countryName;

// Поверка на существование e-mail в БД
// $email_exists = $user->emailExists();

// Создание пользователя
if (
    !empty($country->countryName) &&
    $country->SetCountry()
) {
    // Устанавливаем код ответа
    http_response_code(200);

    // Покажем сообщение о том, что пользователь был создан
    echo json_encode(
        array(
            "message" => "Страна успешно добавлена",
            "countryId" => $country->countryId,
            "contryName" => $country->countryName,
        ), JSON_UNESCAPED_UNICODE
    );
}

// Сообщение, если не удаётся создать пользователя
else {

    // Устанавливаем код ответа
    http_response_code(400);

    // Покажем сообщение о том, что создать пользователя не удалось
    echo json_encode(array("message" => "Невозможно добавить страну"));
}
