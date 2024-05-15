<?php
session_start();
use object\Admin;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
  // Заголовки
  header("Access-Control-Allow-Origin: http://merney.ru/");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  // Файлы необходимые для соединения с БД
  include_once $_SERVER['DOCUMENT_ROOT']."/API/Config/Database.php";
  include_once $_SERVER['DOCUMENT_ROOT']."/API/Objects/Admin.php";

  // Получаем соединение с базой данных
  $database = new Database();
  $db = $database->getConnection();
  // Создание объекта "Admin"
  $user = new Admin($db);

  // Получаем данные
  $data = json_decode(file_get_contents("php://input"));


  // Устанавливаем значения
  $user->token = $data->token;
  $token_exists = $user->tokenExists();
// Существует ли электронная почта и соответствует ли пароль тому, что находится в базе данных
  if ($token_exists) {
      $_SESSION['id'] = $user->id;
    // Код ответа
    http_response_code(200);
    echo json_encode(
      array(
        "message" => "Успешный вход в систему, через пару секунд вас перенаправит",
        "userId" => $user->id,
          "surname" => $user->surname,
          "name" => $user->name,
          "photo" => $user->photo,
          "role" => $user->role,
      ), JSON_UNESCAPED_UNICODE
    );
  }
  else {
      // Код ответа
      http_response_code(400);
      echo json_encode(
          array(
              "message" => "Такого токена не существует"
          ), JSON_UNESCAPED_UNICODE
      );
  }
