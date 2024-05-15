<?php 
    /*session_start();
    if(!isset($_SESSION['id'])) {
        header('Location: login.php');
        exit;
    }

    $data = json_decode(file_get_contents("php://input"), true);
    //$arrays = get_object_vars($data->id);
    echo $data['id'] + $data['score'];*/

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
    $data = json_decode(file_get_contents("php://input"), true);

    // Устанавливаем значения
    $match->roundUsersId = $data['id'];
    $match->roundUsersScore = $data['score'];
    if($match->roundUsersScore == "")
        $match->roundUsersScore = 0;


    // Поверка на существование e-mail в БДa
    // $email_exists = $user->emailExists();

    // Создание пользователя
    if (
        $match->saveDraftScore()
    ) {
        // Устанавливаем код ответа
        http_response_code(200);

        // Покажем сообщение о том, что пользователь был создан
        echo json_encode(
            array(
                "message" => "Матч успешно Обновлен"
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


?>