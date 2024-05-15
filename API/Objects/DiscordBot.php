<?php

namespace object;

use PDO;

class DiscordBot
{
    private $conn;
    
    public $countryId;
    public $countryName;
    public $disciplineId;
    public $disciplineName;
    public $tournomentId;
    public $tournomentTitle;
    public $tournomentDescription;
    public $tournomentStatus;
    public $matchId;
    public $matchStartDate;
    public $matchRegStartDate;
    public $matchRegEndDate;
    public $matchStatus;
    public $roundId;
    public $roundStatus;
    public $roundUsersId;
    public $roundUsersUsersId;
    public $roundUsersRole;
    public $roundUsersStatus;
    public $roundUsersScore;
    public $matchUserId;
    public $matchMatchId;
    public $date_create;
    public $date_modified;
    public $round;
    public $players;
    public $message_id;    
    public $date;
    public $fix_score;

    private $table_name_country = "country";
    private $table_name_discipline = "discipline";
    private $table_name_tournament = "tournament";
    private $table_name_match = "match";
    private $table_name_match_users = "match_users";
    private $table_name_users = "users";
    private $table_name_score = "score";
    private $table_name_round_users = "round_users";


    // Конструктор класса DiscordBot
    public function __construct($db)
    {
        $this->conn = $db;
    }
    
    // Метод для добавления новой страны
    function SetCountry() {
        // Запрос для добавления нового пользователя в БД
        $query = 'INSERT INTO '. $this->table_name_country .'(name) VALUES(:name)';

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Инъекция
        $this->countryName = htmlspecialchars(strip_tags($this->countryName));

        // Привязываем значения
        $stmt->bindParam(':name', $this->countryName);

        // Выполняем запрос
        // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
        if ($stmt->execute()) {
            $this->countryId = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    // Метод вывода всех стран
    function GetCountryArray($id = null) {
        // Запрос на получения списка стран
        $where = "";
        if($id != null)
            $where = " WHERE id=:id";
        $query = "SELECT *
            FROM " . $this->table_name_country . $where;

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);
        
        if($id != null)
            $stmt->bindParam(':id', $id);

        // Выполняем запрос
        $stmt->execute();

        // Получаем количество строк
        $num = $stmt->rowCount();

        // Если есть список стран,
        // Присвоим массиву результаты запроса
        if ($num > 0) {

            // Получаем значения
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);



            // Вернём массив
            return $row;
        }

        // Вернём "false", если стран нет в БД
        return false;
    }
    // Метод для добавления новой дисциплины
    function SetDiscipline() {
        // Запрос для добавления нового пользователя в БД
        $query = 'INSERT INTO '. $this->table_name_discipline .'(name) VALUES(:name)';

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Инъекция
        $this->disciplineName = htmlspecialchars(strip_tags($this->disciplineName));

        // Привязываем значения
        $stmt->bindParam(':name', $this->disciplineName);

        // Выполняем запрос
        // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
        if ($stmt->execute()) {
            $this->disciplineId = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }
    // Метод вывода всех дисциплин
    function GetDisciplineArray($id = null) {
        // Запрос на получения списка стран
        $where = "";
        if($id != null)
            $where = " WHERE id=:id";

        $query = "SELECT *
            FROM " . $this->table_name_discipline . $where;

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        if($id != null)
            $stmt->bindParam(':id', $id);

        // Выполняем запрос
        $stmt->execute();

        // Получаем количество строк
        $num = $stmt->rowCount();

        // Если есть список стран,
        // Присвоим массиву результаты запроса
        if ($num > 0) {

            // Получаем значения
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);



            // Вернём массив
            return $row;
        }

        // Вернём "false", если стран нет в БД
        return false;
    }
    // Метод для добавления нового турнира
    function SetTournament() {
        // Запрос для добавления нового пользователя в БД
        $query = 'INSERT INTO '. $this->table_name_tournament .'(discipline_id, country_id, title, description, status) VALUES(:discipline_id, :country_id, :title, :description, :status)';

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Инъекция
        $this->disciplineId = htmlspecialchars(strip_tags($this->disciplineId));
        $this->countryId = htmlspecialchars(strip_tags($this->countryId));
        $this->tournomentTitle = htmlspecialchars(strip_tags($this->tournomentTitle));
        $this->tournomentDescription = htmlspecialchars(strip_tags($this->tournomentDescription));
        $this->tournomentStatus = htmlspecialchars(strip_tags($this->tournomentStatus));

        // Привязываем значения
        $stmt->bindParam(':discipline_id', $this->disciplineId);
        $stmt->bindParam(':country_id', $this->countryId);
        $stmt->bindParam(':title', $this->tournomentTitle);
        $stmt->bindParam(':description', $this->tournomentDescription);
        $stmt->bindParam(':status', $this->tournomentStatus);

        // Выполняем запрос
        // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
        if ($stmt->execute()) {
            $this->tournomentId = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }
    // Метод вывода всех турниров
    function GetTournamentArray($id = null) {
        // Запрос на получения списка стран
        $where = "";
        if($id != null)
            $where = " WHERE id=:id";
        $query = "SELECT *
            FROM " . $this->table_name_tournament . $where;

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        if($id != null)
            $stmt->bindParam(':id', $id);

        // Выполняем запрос
        $stmt->execute();

        // Получаем количество строк
        $num = $stmt->rowCount();

        // Если есть список стран,
        // Присвоим массиву результаты запроса
        if ($num > 0) {

            // Получаем значения
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);



            // Вернём массив
            return $row;
        }

        // Вернём "false", если стран нет в БД
        return false;
    }

    // Метод для добавления нового турнира
    function SetMatch() {
        // Запрос для добавления нового пользователя в БД
        $query = 'INSERT INTO '. $this->table_name_match .'(tournament_id, start_date, reg_start_date, reg_end_date, status, date_create, date_modified, round, players, fix_score) VALUES(:tournament_id, :start_date, :reg_start_date, :reg_end_date, :status, :date_create, :date_create, :round, :players, :fix_score)';

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Инъекция
        $this->tournomentId = htmlspecialchars(strip_tags($this->tournomentId));
        $this->matchStartDate = htmlspecialchars(strip_tags($this->matchStartDate));
        $this->matchRegStartDate = htmlspecialchars(strip_tags($this->matchRegStartDate));
        $this->matchRegEndDate = htmlspecialchars(strip_tags($this->matchRegEndDate));
        $this->matchStatus = htmlspecialchars(strip_tags($this->matchStatus));
        $this->round = htmlspecialchars(strip_tags($this->round));
        $this->players = htmlspecialchars(strip_tags($this->players));

        // Привязываем значения
        $stmt->bindParam(':tournament_id', $this->tournomentId);
        $stmt->bindParam(':start_date', $this->matchStartDate);
        $stmt->bindParam(':reg_start_date', $this->matchRegStartDate);
        $stmt->bindParam(':reg_end_date', $this->matchRegEndDate);
        $stmt->bindParam(':status', $this->matchStatus);
        $stmt->bindParam(':date_create', $this->date_create);
        $stmt->bindParam(':round', $this->round);
        $stmt->bindParam(':players', $this->players);
        $stmt->bindParam(':fix_score', $this->fix_score);

        // Выполняем запрос
        // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
        if ($stmt->execute()) {
            $this->matchId = $this->conn->lastInsertId();

            return true;
        }

        return false;
    }
    function SendMessageDiscord($commands) {


        $webhookurl = "https://discord.com/api/webhooks/1184606049639080157/Eah8QiAyKKECxJG_2qjb1yvjBSOfjF8FYqwTk1rO0dn_WnZTQ_GaJmdm9M8gpMj_CjjD";


        $timestamp = date("c", strtotime("now"));

        $json_data = json_encode([
            // Message
            "content" => $commands,

            // Text-to-speech
            "tts" => false,

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


        $ch = curl_init( $webhookurl );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec( $ch );
        curl_close( $ch );
    }


    function UpdateMessageDiscord() {


        $webhookurl = "https://discord.com/api/webhooks/1184606049639080157/Eah8QiAyKKECxJG_2qjb1yvjBSOfjF8FYqwTk1rO0dn_WnZTQ_GaJmdm9M8gpMj_CjjD";


        $timestamp = date("c", strtotime("now"));

        $json_data = json_encode([
            // Message
            "content" => "!EditMatch ".$this->matchId,

            // Text-to-speech
            "tts" => false,

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


        $ch = curl_init( $webhookurl );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec( $ch );
        curl_close( $ch );
    }
    // Метод вывода всех турниров
    function GetMatchArray($id = null, $id_tournament = null) {
        // Запрос на получения списка стран
        $where = "";
        if($id != null)
            $where = " WHERE id=:id";
        if($id_tournament != null)
            $where = " WHERE tournament_id=:tournament_id";
        $query = "SELECT *
            FROM " . $this->table_name_match . $where;

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        if($id != null)
            $stmt->bindParam(':id', $id);

        if($id_tournament != null)
            $stmt->bindParam(':tournament_id', $id_tournament);
        // Выполняем запрос
        $stmt->execute();

        // Получаем количество строк
        $num = $stmt->rowCount();

        // Если есть список стран,
        // Присвоим массиву результаты запроса
        if ($num > 0) {

            // Получаем значения
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);



            // Вернём массив
            return $row;
        }

        // Вернём "false", если стран нет в БД
        return false;
    }
    // Метод для добавления нового пользователя в матч
    function SetMatchUsers() {
        // Запрос для добавления нового пользователя в БД
        $query = 'INSERT INTO '. $this->table_name_match_users .'("user_id", "match_id", "date_create") VALUES(:userId, :matchId, :date_create)';

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Привязываем значения
        $stmt->bindParam(':userId', $this->matchUserId);
        $stmt->bindParam(':matchId', $this->matchMatchId);
        $stmt->bindParam(':date_create', $this->date);

        // Выполняем запрос
        // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
        if ($stmt->execute()) {

            return true;
        }

        return false;
    }
    function GetMatchUsers() {
        $query = 'SELECT *
            FROM ' . $this->table_name_match_users . ' WHERE user_id=:userId AND match_id=:matchId';

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Привязываем значения
        $stmt->bindParam(':userId', $this->matchUserId);
        $stmt->bindParam(':matchId', $this->matchMatchId);

        // Выполняем запрос
        $stmt->execute();

        // Получаем количество строк
        $num = $stmt->rowCount();

        // Если есть список стран,
        // Присвоим массиву результаты запроса
        if ($num > 0) {

            // Получаем значения
            $row = $stmt->fetch(PDO::FETCH_ASSOC);


            // Вернём массив
            return $row;
        }

        // Вернём "false", если стран нет в БД
        return false;
    }
    function UpdateMessageId() {
        $sql = 'UPDATE ' . $this->table_name_match . ' SET message_id = :message_id WHERE id = :match_id';
        $stmt = $this->conn->prepare($sql);

        // Привязываем значения
        $stmt->bindParam(':message_id', $this->message_id);
        $stmt->bindParam(':match_id', $this->matchMatchId);

        // Выполняем запрос
        $stmt->execute();
    }
    function UpdateMatch() {
        $sql = 'UPDATE ' . $this->table_name_match . ' SET start_date = :start_date, reg_start_date = :reg_start_date, reg_end_date = :reg_end_date, status = :status, date_modified = :date_modified WHERE id = :match_id';
        $stmt = $this->conn->prepare($sql);

        // Привязываем значения
        $stmt->bindParam(':start_date', $this->matchStartDate);
        $stmt->bindParam(':reg_start_date', $this->matchRegStartDate);
        $stmt->bindParam(':reg_end_date', $this->matchRegEndDate);
        $stmt->bindParam(':status', $this->matchStatus);
        $stmt->bindParam(':date_modified', $this->date_modified);
        $stmt->bindParam(':match_id', $this->matchMatchId);
        

        // Выполняем запрос
        if ($stmt->execute()) {

            return true;
        }

        return false;
    }
    function saveScoreRound() {
        $sql = 'UPDATE ' . $this->table_name_match . ' SET start_date = :start_date, reg_start_date = :reg_start_date, reg_end_date = :reg_end_date, status = :status, date_modified = :date_modified WHERE id = :match_id';
        $stmt = $this->conn->prepare($sql);

        // Привязываем значения
        $stmt->bindParam(':start_date', $this->matchStartDate);
        $stmt->bindParam(':reg_start_date', $this->matchRegStartDate);
        $stmt->bindParam(':reg_end_date', $this->matchRegEndDate);
        $stmt->bindParam(':status', $this->matchStatus);
        $stmt->bindParam(':date_modified', $this->date_modified);
        $stmt->bindParam(':match_id', $this->matchMatchId);


        // Выполняем запрос
        if ($stmt->execute()) {

            return true;
        }

        return false;
    }
    function GetMatchUsersArray() {
        $query = 'SELECT *
            FROM ' . $this->table_name_match_users . ' WHERE match_id=:matchId';

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Привязываем значения
        $stmt->bindParam(':matchId', $this->matchMatchId);

        // Выполняем запрос
        $stmt->execute();

        // Получаем количество строк
        $num = $stmt->rowCount();

        // Если есть список стран,
        // Присвоим массиву результаты запроса
        if ($num > 0) {

            // Получаем значения
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);


            // Вернём массив
            return $row;
        }

        // Вернём "false", если стран нет в БД
        return false;
    }

    function draftCaptain() {
        $query = 'SELECT *
            FROM ' . $this->table_name_match_users . ' WHERE match_id=:matchId';
        // Подготовка запроса
        $stmt = $this->conn->prepare($query);
        // Привязываем значения
        $stmt->bindParam(':matchId', $this->matchMatchId);
        // Выполняем запрос
        $stmt->execute();
        // Получаем значения
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);



        $query_match = 'SELECT *
            FROM ' . $this->table_name_match . ' WHERE id=:matchId';
        // Подготовка запроса
        $stmt_match = $this->conn->prepare($query_match);
        // Привязываем значения
        $stmt_match->bindParam(':matchId', $this->matchMatchId);
        // Выполняем запрос
        $stmt_match->execute();
        // Получаем значения
        $row_match = $stmt_match->fetch(PDO::FETCH_ASSOC);



        $score = [];

        for($i = 0; $i < count($row); $i++) {

            //// ПОЛУЧЕНИЕ ДАННЫХ О ПОЛЬЗОВАТЕЛЕ
            $query_user = 'SELECT *
            FROM ' . $this->table_name_users . ' WHERE discord_id=:discord_id';
            // Подготовка запроса
            $stmt_user = $this->conn->prepare($query_user);
            // Привязываем значения
            $stmt_user->bindParam(':discord_id', $row[$i]['user_id']);
            // Выполняем запрос
            $stmt_user->execute();
            // Получаем значения
            $row_user = $stmt_user->fetch(PDO::FETCH_ASSOC);


            //// ПОЛУЧЕНИЕ ДАННЫХ О РЕЙТИНГЕ ПОЛЬЗОВАТЕЛЯ
            $query_score = 'SELECT *
            FROM ' . $this->table_name_score . ' WHERE id_users=:id_users AND id_discipline=:id_discipline';
            // Подготовка запроса
            $stmt_score = $this->conn->prepare($query_score);
            // Привязываем значения
            $stmt_score->bindParam(':id_users', $row_user['id']);
            $stmt_score->bindParam(':id_discipline', $this->disciplineId);
            // Выполняем запрос
            $stmt_score->execute();
            // Получаем значения
            $row_score = $stmt_score->fetch(PDO::FETCH_ASSOC);

            $score[$row_user['id']] = $row_score['score'];
            $user_name[$row_user['id']] = $row_user['username'];
            $user_idDiscord[$row_user['id']] = $row_user['discord_id'];
            //array_push($uid, $row_user['id']);

        }

        $max1 = 0;
        $max1_id = 0;
        $max2 = 0;
        $max2_id = 0;

        foreach($score as $i => $value) {
            if($max1 < $score[$i]) {
                $max1 = $score[$i];
                $max1_id = $i;
            }
        }
        foreach($score as $i => $value) {
            if($max1_id != $i) {
                if($max2 < $score[$i]) {
                    $max2 = $score[$i];
                    $max2_id = $i;
                }
            }
        }

        $sql_update = 'UPDATE ' . $this->table_name_match_users . ' SET used = :used WHERE match_id = :match_id AND user_id = :user_id';
        $stmt_update = $this->conn->prepare($sql_update);
        // Привязываем значения
        $used = 1;
        $stmt_update->bindParam(':used', $used);
        $stmt_update->bindParam(':match_id', $this->matchMatchId);
        $stmt_update->bindParam(':user_id', $user_idDiscord[$max1_id]);
        // Выполняем запрос
        $stmt_update->execute();



        $sql_update = 'UPDATE ' . $this->table_name_match_users . ' SET used = :used WHERE match_id = :match_id AND user_id = :user_id';
        $stmt_update = $this->conn->prepare($sql_update);
        // Привязываем значения
        $stmt_update->bindParam(':used', $used);
        $stmt_update->bindParam(':match_id', $this->matchMatchId);
        $stmt_update->bindParam(':user_id', $user_idDiscord[$max2_id]);
        // Выполняем запрос
        $stmt_update->execute();


        for($i = 1; $i <= $row_match['round']; $i++) {
            // Запрос для добавления нового пользователя в БД
            $query = 'INSERT INTO '. $this->table_name_round_users .'("match_id", "user_id", "role", "score", "date", "round", "commands") VALUES(:match_id, :user_id, :role, :score, :date, :round, :commands)';
            // Подготовка запроса
            $stmt = $this->conn->prepare($query);
            $role = "captain";
            $score = 0;
            $commands = 1;
            // Привязываем значения
            $stmt->bindParam(':match_id', $this->matchMatchId);
            $stmt->bindParam(':user_id', $max1_id);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':score', $score);
            $stmt->bindParam(':date', $this->date);
            $stmt->bindParam(':round', $i);
            $stmt->bindParam(':commands', $commands);

            // Выполняем запрос
            // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
            $stmt->execute();


            // Запрос для добавления нового пользователя в БД
            $query = 'INSERT INTO '. $this->table_name_round_users .'("match_id", "user_id", "role", "score", "date", "round", "commands") VALUES(:match_id, :user_id, :role, :score, :date, :round, :commands)';
            // Подготовка запроса
            $stmt = $this->conn->prepare($query);
            $role = "captain";
            $score = 0;
            $commands = 2;
            // Привязываем значения
            $stmt->bindParam(':match_id', $this->matchMatchId);
            $stmt->bindParam(':user_id', $max2_id);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':score', $score);
            $stmt->bindParam(':date', $this->date);
            $stmt->bindParam(':round', $i);
            $stmt->bindParam(':commands', $commands);

            // Выполняем запрос
            // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
            $stmt->execute();

        }




        $res['first'] = $user_name[$max1_id];
        $res['second'] = $user_name[$max2_id];
        $res['first_idDiscord'] = $user_idDiscord[$max1_id];
        $res['second_idDiscord'] = $user_idDiscord[$max2_id];
        return $res;

    }
    function saveDraftScore() {
        $sql_update = 'UPDATE ' . $this->table_name_round_users . ' SET score = :score WHERE id = :id';
        $stmt_update = $this->conn->prepare($sql_update);
        // Привязываем значения
        $used = 1;
        $stmt_update->bindParam(':id', $this->roundUsersId);
        $stmt_update->bindParam(':score', $this->roundUsersScore);
        // Выполняем запрос
        $stmt_update->execute();
        return true;
    }
    /*function updateVariableScore() {
        $query = 'SELECT *
            FROM ' . $this->table_name_round_users . '';
        // Подготовка запроса
        $stmt = $this->conn->prepare($query);
        // Выполняем запрос
        $stmt->execute();
        // Получаем значения
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($row); $i++) {
            $users[$row['user_id']] += $row['score'];
        }

        $query_users = 'SELECT *
            FROM ' . $this->table_name_score . ' WHERE id_discipline = :id_discipline';
        // Подготовка запроса
        $stmt_users = $this->conn->prepare($query_users);
        // Привязываем значения
        $id_discipline = 2;
        $stmt->bindParam(':id_discipline', $id_discipline);
        // Выполняем запрос
        $stmt_users->execute();
        // Получаем значения
        $row_users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($row_users); $i++) {
            $users[$row['user_id']] += $row['score'];
            if(isset($users[$row_users['user_id']])) {
                $res = $row_users['score'] + $users[$row_users['user_id']];
                $sql_update = 'UPDATE ' . $this->table_name_score . ' SET variable_score = :variable_score WHERE id = :id';
                
            }
        }

    }*/
    function getListUsersScore() {
        $res = [];
        $query = 'SELECT *
            FROM ' . $this->table_name_tournament . ' WHERE season_id = :season_id';
        // Подготовка запроса
        $stmt = $this->conn->prepare($query);
        // Привязываем значения
        $season_id = 1;
        $stmt->bindParam(':season_id', $season_id);
        // Выполняем запрос
        $stmt->execute();
        // Получаем значения
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for($i = 0; $i < count($row); $i++) {
            $query_match = 'SELECT *
            FROM ' . $this->table_name_match . ' WHERE tournament_id = :tournament_id';
            // Подготовка запроса
            $stmt_match = $this->conn->prepare($query_match);
            // Привязываем значения
            $stmt_match->bindParam(':tournament_id', $row[$i]['id']);
            // Выполняем запрос
            $stmt_match->execute();
            // Получаем значения
            $row_match = $stmt_match->fetchAll(PDO::FETCH_ASSOC);

            for($j = 0; $j < count($row_match); $j++) {
                $query_match_round = 'SELECT *
                FROM ' . $this->table_name_round_users . ' WHERE match_id = :match_id';
                // Подготовка запроса
                $stmt_match_round = $this->conn->prepare($query_match_round);
                // Привязываем значения
                $stmt_match_round->bindParam(':match_id', $row_match[$j]['id']);
                // Выполняем запрос
                $stmt_match_round->execute();
                // Получаем значения
                $row_match_round = $stmt_match_round->fetchAll(PDO::FETCH_ASSOC);

                for($k = 0; $k < count($row_match_round); $k++) {
                    if(!isset($res[$row_match_round[$k]['user_id']])) {
                        $res[$row_match_round[$k]['user_id']] = 0;
                    }
                    $res[$row_match_round[$k]['user_id']] += $row_match_round[$k]['score'];
                }
            }
        }
        $arr = [];
        $x = 0;
        foreach ($res as $key => $row)
        {
            //// ПОЛУЧЕНИЕ ДАННЫХ О РЕЙТИНГЕ ПОЛЬЗОВАТЕЛЯ
            $query_score = 'SELECT *
            FROM ' . $this->table_name_users . ' WHERE id=:id';
            // Подготовка запроса
            $stmt_score = $this->conn->prepare($query_score);
            // Привязываем значения
            $stmt_score->bindParam(':id', $key);
            // Выполняем запрос
            $stmt_score->execute();
            // Получаем значения
            $row_score = $stmt_score->fetch(PDO::FETCH_ASSOC);
            
            $arr[$x]['username'] = $row_score['username'];
            $arr[$x]['score'] = $row;
            $x++;
        }
        usort($arr, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        //array_multisort(array_column($arr, 'score'), SORT_ASC, $array);
        //array_multisort($array_value, SORT_ASC, $array_key, SORT_DESC, $array);
        return $arr;
    }
}
