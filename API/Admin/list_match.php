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

// Создание объекта "DiscordBot"
$tournament = new DiscordBot($db);

// Получаем данные

if(isset($_GET['id']))
    $match = $tournament->GetMatchArray(null, $_GET['id']);
if(isset($_GET['match_id']))
    $match = $tournament->GetMatchArray($_GET['match_id'], null);

$arr = $tournament->GetTournamentArray($match[0]['tournament_id']);

$country = [];
$discipline = [];

$country = array_merge($country, $tournament->GetCountryArray($arr[0]['country_id']));
$discipline = array_merge($discipline, $tournament->GetDisciplineArray($arr[0]['discipline_id']));

// Устанавливаем код ответа
http_response_code(200);

// Выведем массив стран
echo json_encode(
    array(
        "match" => $match,
        "tournament" => $arr,
        "country" => $country,
        "discipline" => $discipline
    ), JSON_UNESCAPED_UNICODE
);