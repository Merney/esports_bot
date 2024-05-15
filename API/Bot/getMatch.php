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
$captain = [];

$match->date = date("Y-m-d H:i:s");


if(isset($_GET['id'])) {
    $arr = $match->GetMatchArray($_GET['id']);
    $tournament = $match->GetTournamentArray($arr[0]['tournament_id']);
    $country = $match->GetCountryArray($tournament[0]['country_id']);
    $discipline = $match->GetDisciplineArray($tournament[0]['discipline_id']);

    $contetn = "";
    $component = [];
    $date_start = date("d.m.Y H:s", strtotime($arr[0]['start_date']));
    $reg_start = date("d.m.Y H:s", strtotime($arr[0]['reg_start_date']));
    $reg_end = date("d.m.Y H:s", strtotime($arr[0]['reg_end_date']));
    $reply = 0;
    $match->matchMatchId = $_GET['id'];
    if($arr[0]['status'] == 'scheduled') {
        $content = '> *'.$tournament[0]['title'].'*'.PHP_EOL.'> **Match #'.$arr[0]['id'].'** '.PHP_EOL.'> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: scheduled :: '.PHP_EOL.'`match starts`'.$date_start.''.PHP_EOL.'`registration starts`'.$reg_start.' ';
    }
    if($arr[0]['status'] == 'upcoming') {
        $content = '> *'.$tournament[0]['title'].'*'.PHP_EOL.'> **Match #'.$arr[0]['id'].'** '.PHP_EOL.'> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: upcoming :: '.PHP_EOL.'`match starts` :: '.$date_start.' :: '.PHP_EOL.'`registration starts` :: '.$reg_start.' :: ';
    }
    if($arr[0]['status'] == 'registration') {
        $content = '> *'.$tournament[0]['title'].'*'.PHP_EOL.'> **Match #'.$arr[0]['id'].'** '.PHP_EOL.'> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: registration :: '.PHP_EOL.'`match starts` :: '.$date_start.' :: '.PHP_EOL.'`registration end` :: '.$reg_end.' :: ';
        $component[0]['type'] = 1;
        $component[0]['components'][0]['type'] = 2;
        $component[0]['components'][0]['label'] = "Registration";
        $component[0]['components'][0]['style'] = 1;
        $component[0]['components'][0]['custom_id'] = "register ".$arr[0]['id'];
        
        $component[1]['type'] = 1;
        $component[1]['components'][0]['type'] = 2;
        $component[1]['components'][0]['label'] = "Participants";
        $component[1]['components'][0]['style'] = 1;
        $component[1]['components'][0]['custom_id'] = "participants ".$arr[0]['id'];
        $reply = 1;
        
    }
    if($arr[0]['status'] == 'draft') {
        $captain = $match->draftCaptain();
        $content = '> *'.$tournament[0]['title'].'*'.PHP_EOL.'> **Match #'.$arr[0]['id'].'** '.PHP_EOL.'> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: draft ::'.PHP_EOL.'`match start` '.$date_start;
        $component[0]['type'] = 1;
        $component[0]['components'][0]['type'] = 2;
        $component[0]['components'][0]['label'] = "Team [".$captain['first']."]";
        $component[0]['components'][0]['style'] = 1;
        $component[0]['components'][0]['custom_id'] = "teams_one ".$arr[0]['id'];

        $component[1]['type'] = 1;
        $component[1]['components'][0]['type'] = 2;
        $component[1]['components'][0]['label'] = "Team [".$captain['second']."]";
        $component[1]['components'][0]['style'] = 1;
        $component[1]['components'][0]['custom_id'] = "teams_two ".$arr[0]['id'];
        
        $component[2]['type'] = 1;
        $component[2]['components'][0]['type'] = 2;
        $component[2]['components'][0]['label'] = "Participants";
        $component[2]['components'][0]['style'] = 1;
        $component[2]['components'][0]['custom_id'] = "participants ".$arr[0]['id'];
    }
    if($arr[0]['status'] == 'live') {
        $content = '> *'.$tournament[0]['title'].'*'.PHP_EOL.'> **Match #'.$arr[0]['id'].'** '.PHP_EOL.'> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: **LIVE** ::';
        $component[0]['type'] = 1;
        $component[0]['components'][0]['type'] = 2;
        $component[0]['components'][0]['label'] = "Team [Captain A]";
        $component[0]['components'][0]['style'] = 1;
        $component[0]['components'][0]['custom_id'] = "teams_one ".$arr[0]['id'];

        $component[1]['type'] = 1;
        $component[1]['components'][0]['type'] = 2;
        $component[1]['components'][0]['label'] = "Team [Captain B]";
        $component[1]['components'][0]['style'] = 1;
        $component[1]['components'][0]['custom_id'] = "teams_two ".$arr[0]['id'];
        
        $component[2]['type'] = 1;
        $component[2]['components'][0]['type'] = 2;
        $component[2]['components'][0]['label'] = "Watch Live!";
        $component[2]['components'][0]['style'] = 1;
        $component[2]['components'][0]['custom_id'] = "live ".$arr[0]['id'];
        $reply = 1;
    }
    if($arr[0]['status'] == 'under review') {
        $content = '> *'.$tournament[0]['title'].'*'.PHP_EOL.'> **Match #'.$arr[0]['id'].'** '.PHP_EOL.'> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: under review ::';
        $component[0]['type'] = 1;
        $component[0]['components'][0]['type'] = 2;
        $component[0]['components'][0]['label'] = "Team [Captain A]";
        $component[0]['components'][0]['style'] = 1;
        $component[0]['components'][0]['custom_id'] = "teams_one ".$arr[0]['id'];

        $component[1]['type'] = 1;
        $component[1]['components'][0]['type'] = 2;
        $component[1]['components'][0]['label'] = "Team [Captain B]";
        $component[1]['components'][0]['style'] = 1;
        $component[1]['components'][0]['custom_id'] = "teams_two ".$arr[0]['id'];
    }
    if($arr[0]['status'] == 'completed') {
        $content = '> *'.$tournament[0]['title'].'*'.PHP_EOL.'> **Match #'.$arr[0]['id'].'** '.PHP_EOL.'> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: completed ::'.PHP_EOL.'`match start`'.$date_start;
        $component[0]['type'] = 1;
        $component[0]['components'][0]['type'] = 2;
        $component[0]['components'][0]['label'] = "Result";
        $component[0]['components'][0]['style'] = 1;
        $component[0]['components'][0]['custom_id'] = "result ".$arr[0]['id'];

        $component[1]['type'] = 1;
        $component[1]['components'][0]['type'] = 2;
        $component[1]['components'][0]['label'] = "Highlights";
        $component[1]['components'][0]['style'] = 1;
        $component[1]['components'][0]['custom_id'] = "highlights ".$arr[0]['id'];
        
        $component[2]['type'] = 1;
        $component[2]['components'][0]['type'] = 2;
        $component[2]['components'][0]['label'] = "Participants";
        $component[2]['components'][0]['style'] = 1;
        $component[2]['components'][0]['custom_id'] = "participants ".$arr[0]['id'];
        
    }

    // Устанавливаем код ответа
    http_response_code(200);

    // Выведем массив стран
    echo json_encode(
        array(
            "match" => $arr,
            "tournament" => $tournament,
            "country" => $country,
            "discipline" => $discipline,
            "content" => $content,
            "components" => $component,
            "reply" => $reply
        ), JSON_UNESCAPED_UNICODE
    );
}
if(isset($_GET['message_id'])) {
    $match->matchMatchId = $_GET['match_id'];
    $match->message_id = $_GET['message_id'];

    $match->UpdateMessageId();

}
if(isset($_GET['edit_message'])) {
    $arr = $match->GetMatchArray($_GET['edit_message']);
    $tournament = $match->GetTournamentArray($arr[0]['tournament_id']);
    $contetn = "";
    $component = [];
    $embed = [];
    $date_start = date("d.m.Y H:s", strtotime($arr[0]['start_date']));
    $reg_start = date("d.m.Y H:s", strtotime($arr[0]['reg_start_date']));
    $reg_end = date("d.m.Y H:s", strtotime($arr[0]['reg_end_date']));
    $match->matchMatchId = $_GET['edit_message'];
    $match->disciplineId = $tournament[0]['discipline_id'];
    $reply = 0;
    if($arr[0]['status'] == 'scheduled') {
        $content = '> *'.$tournament[0]['title'].'*'.PHP_EOL.'> **Match #'.$arr[0]['id'].'** '.PHP_EOL.'> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: scheduled :: '.PHP_EOL.'`match starts`'.$date_start.''.PHP_EOL.'`registration starts`'.$reg_start.' '.PHP_EOL.'==============================='.PHP_EOL;
        $content = "";
        $embed['title'] = $tournament[0]['title'];
        $embed['fields'][0]['name'] = 'Match #'.$arr[0]['id'];
        $embed['fields'][0]['value'] = '> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: scheduled :: '.PHP_EOL.'`match starts`'.$date_start.''.PHP_EOL.'`registration starts`'.$reg_start.' '.PHP_EOL.'==============================='.PHP_EOL;
        $embed['image']['url'] = "http://merney.ru/assets/img/1.png";
    }
    if($arr[0]['status'] == 'upcoming') {
        $content = '> *'.$tournament[0]['title'].'*'.PHP_EOL.'> **Match #'.$arr[0]['id'].'** '.PHP_EOL.'> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: upcoming :: '.PHP_EOL.'`match starts` :: '.$date_start.' :: '.PHP_EOL.'`registration starts` :: '.$reg_start.' :: '.PHP_EOL.'==============================='.PHP_EOL;
        $content = "";
        $embed['title'] = $tournament[0]['title'];
        $embed['fields'][0]['name'] = 'Match #'.$arr[0]['id'];
        $embed['fields'][0]['value'] = '> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: upcoming :: '.PHP_EOL.'`match starts`'.$date_start.''.PHP_EOL.'`registration starts`'.$reg_start.' '.PHP_EOL.'==============================='.PHP_EOL;
        $embed['image']['url'] = "http://merney.ru/assets/img/1.png";
    }
    if($arr[0]['status'] == 'registration') {
        $content = '> *'.$tournament[0]['title'].'*'.PHP_EOL.'> **Match #'.$arr[0]['id'].'** '.PHP_EOL.'> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: <font color="red">registration</font> :: '.PHP_EOL.'`match starts` :: '.$date_start.' :: '.PHP_EOL.'`registration end` :: '.$reg_end.' :: '.PHP_EOL;
        
        $content = "";
        $embed['title'] = '*'.$tournament[0]['title'].'*';
        $embed['fields'][0]['name'] = 'Match #'.$arr[0]['id'];
        $embed['fields'][0]['value'] = '[Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: registration :: '.PHP_EOL.'`match starts` :: '.$date_start.' :: '.PHP_EOL.'`registration end` :: '.$reg_end.' :: '.PHP_EOL.'==============================='.PHP_EOL;
        $embed['image']['url'] = "http://merney.ru/assets/img/1.png";

        $component[0]['type'] = 1;
        $component[0]['components'][0]['type'] = 2;
        $component[0]['components'][0]['label'] = "REGISTER NOW";
        $component[0]['components'][0]['style'] = 3;
        $component[0]['components'][0]['custom_id'] = "register ".$arr[0]['id'];
        
        $component[1]['type'] = 1;
        $component[1]['components'][0]['type'] = 2;
        $component[1]['components'][0]['label'] = "Registered Participats";
        $component[1]['components'][0]['style'] = 2;
        $component[1]['components'][0]['custom_id'] = "participants ".$arr[0]['id'];
        //$reply = 1;
        
    }
    if($arr[0]['status'] == 'draft') {
        
        $captain = $match->draftCaptain();
        /*$match->SendMessageDiscord("!dmmessage ".$captain['first_idDiscord']." 1");
        $match->SendMessageDiscord("!dmmessage ".$captain['first_idDiscord']." 2 ".$_GET['edit_message']);
        $match->SendMessageDiscord("!dmmessage ".$captain['second_idDiscord']." 1");*/
        
        $content = '> *'.$tournament[0]['title'].'*'.PHP_EOL.'> **Match #'.$arr[0]['id'].'** '.PHP_EOL.'> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: draft ::'.PHP_EOL.'`match start` ::'.$date_start;
        
        $content = "";
        $embed['title'] = '*'.$tournament[0]['title'].'*';
        $embed['fields'][0]['name'] = 'Match #'.$arr[0]['id'];
        $embed['fields'][0]['value'] = '[Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: draft :: '.PHP_EOL.'`match starts` :: '.$date_start.' :: '.PHP_EOL;
        $embed['image']['url'] = "http://merney.ru/assets/img/1.png";

        $component[0]['type'] = 1;
        $component[0]['components'][0]['type'] = 2;
        $component[0]['components'][0]['label'] = "Team [".$captain['first']."]";
        $component[0]['components'][0]['style'] = 3;
        $component[0]['components'][0]['custom_id'] = "teams_one ".$arr[0]['id'];

        $component[1]['type'] = 1;
        $component[1]['components'][0]['type'] = 2;
        $component[1]['components'][0]['label'] = "Team [".$captain['second']."]";
        $component[1]['components'][0]['style'] = 3;
        $component[1]['components'][0]['custom_id'] = "teams_two ".$arr[0]['id'];
        
        $component[2]['type'] = 1;
        $component[2]['components'][0]['type'] = 2;
        $component[2]['components'][0]['label'] = "Registered Participats";
        $component[2]['components'][0]['style'] = 2;
        $component[2]['components'][0]['custom_id'] = "participants ".$arr[0]['id'];
    }
    if($arr[0]['status'] == 'live') {
        $content = '> *'.$tournament[0]['title'].'*'.PHP_EOL.'> **Match #'.$arr[0]['id'].'** '.PHP_EOL.'> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: **LIVE** ::';

        $content = "";
        $embed['title'] = $tournament[0]['title'];
        $embed['fields'][0]['name'] = 'Match #'.$arr[0]['id'];
        $embed['fields'][0]['value'] = '> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: LIVE :: '.PHP_EOL;
        $embed['image']['url'] = "http://merney.ru/assets/img/1.png";
        
        $component[0]['type'] = 1;
        $component[0]['components'][0]['type'] = 2;
        $component[0]['components'][0]['label'] = "Watch Live!";
        $component[0]['components'][0]['style'] = 1;
        $component[0]['components'][0]['custom_id'] = "live ".$arr[0]['id'];

        $component[1]['type'] = 1;
        $component[1]['components'][0]['type'] = 2;
        $component[1]['components'][0]['label'] = "Teams formation";
        $component[1]['components'][0]['style'] = 1;
        $component[1]['components'][0]['custom_id'] = "teams_formation ".$arr[0]['id'];

        $component[2]['type'] = 1;
        $component[2]['components'][0]['type'] = 2;
        $component[2]['components'][0]['label'] = "Registered Participats";
        $component[2]['components'][0]['style'] = 2;
        $component[2]['components'][0]['custom_id'] = "participants ".$arr[0]['id'];
        //$reply = 1;
    }
    if($arr[0]['status'] == 'under review') {
        $content = '> *'.$tournament[0]['title'].'*'.PHP_EOL.'> **Match #'.$arr[0]['id'].'** '.PHP_EOL.'> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: under review ::';

        $content = "";
        $embed['title'] = $tournament[0]['title'];
        $embed['fields'][0]['name'] = 'Match #'.$arr[0]['id'];
        $embed['fields'][0]['value'] = '> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: under review :: '.PHP_EOL;
        $embed['image']['url'] = "http://merney.ru/assets/img/1.png";

        $component[0]['type'] = 1;
        $component[0]['components'][0]['type'] = 2;
        $component[0]['components'][0]['label'] = "Teams formation";
        $component[0]['components'][0]['style'] = 1;
        $component[0]['components'][0]['custom_id'] = "teams_formation ".$arr[0]['id'];

        $component[1]['type'] = 1;
        $component[1]['components'][0]['type'] = 2;
        $component[1]['components'][0]['label'] = "Registered Participats";
        $component[1]['components'][0]['style'] = 2;
        $component[1]['components'][0]['custom_id'] = "participants ".$arr[0]['id'];
    }
    if($arr[0]['status'] == 'completed') {
        $content = '> *'.$tournament[0]['title'].'*'.PHP_EOL.'> **Match #'.$arr[0]['id'].'** '.PHP_EOL.'> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: completed ::'.PHP_EOL.'`match start`'.$date_start;
        $content = "";
        $embed['title'] = $tournament[0]['title'];
        $embed['fields'][0]['name'] = 'Match #'.$arr[0]['id'];
        $embed['fields'][0]['value'] = '> [Best of '.$arr[0]['round'].' rounds]'.PHP_EOL.'`status` :: completed :: '.PHP_EOL.'`match starts`'.$date_start.''.PHP_EOL;
        $embed['image']['url'] = "http://merney.ru/assets/img/1.png";
        
        $component[0]['type'] = 1;
        $component[0]['components'][0]['type'] = 2;
        $component[0]['components'][0]['label'] = "Result";
        $component[0]['components'][0]['style'] = 1;
        $component[0]['components'][0]['custom_id'] = "result ".$arr[0]['id'];
        
        $component[1]['type'] = 1;
        $component[1]['components'][0]['type'] = 2;
        $component[1]['components'][0]['label'] = "Registered Participats";
        $component[1]['components'][0]['style'] = 1;
        $component[1]['components'][0]['custom_id'] = "participants ".$arr[0]['id'];
        
    }

    // Устанавливаем код ответа
    http_response_code(200);

    // Выведем массив стран
    echo json_encode(
        array(
            "match" => $arr,
            "tournament" => $tournament,
            "content" => $content,
            "embed" => $embed,
            "components" => $component,
            "captain" => $captain,
            "reply" => $reply
        ), JSON_UNESCAPED_UNICODE
    );
}

if(isset($_GET['next_captain'])) {}

