<?php

namespace object;

use PDO;

class Users
{
    // Подключение к БД таблице "users"
    private $conn;
    private $table_name = "users";
    private $table_participants = "match_users";
    private $table_round_users = "round_users";
    private $table_score = "score";
    private $table_discipline = "discipline";
    private $table_name_users = "users";

    public $id;
    public $registerDate;
    public $invite;
    public $phone;
    public $email;
    public $password;
    public $discordId;
    public $username;
    public $matchId;

    // Конструктор класса DiscordBot
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function createUsersDiscord() {
        // Запрос для добавления нового пользователя в БД
        $query = 'INSERT INTO '. $this->table_name .'(register_date, discord_id, username) VALUES(:registerDate, :discordId, :username)';

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":registerDate", $this->registerDate);
        $stmt->bindParam(":discordId", $this->discordId);
        $stmt->bindParam(":username", $this->username);

        $stmt->execute();

        $idUser = $this->conn->lastInsertId();

        // Запрос, чтобы проверить, существует ли электронная почта
        $query_row = 'SELECT *
            FROM ' . $this->table_discipline;

        // Подготовка запроса
        $stmt_row = $this->conn->prepare($query_row);

        // Выполняем запрос
        $stmt_row->execute();

        // Получаем значения
        $row = $stmt_row->fetchAll(PDO::FETCH_ASSOC);

        //print_r($row);

        for($i = 0; $i < count($row); $i++) {
                // Запрос для добавления нового пользователя в БД
            $query_score = 'INSERT INTO '. $this->table_score .'(id_discipline, id_users) VALUES(:id_discipline, :id_users)';

            // Подготовка запроса
            $stmt_score = $this->conn->prepare($query_score);

            $stmt_score->bindParam(":id_discipline", $row[$i]['id']);
            $stmt_score->bindParam(":id_users", $idUser);
            // Выполняем запрос
            $stmt_score->execute();   
        }

        return true;        
    }

    function userExistDiscord() {

        // Запрос, чтобы проверить, существует ли электронная почта
        $query = 'SELECT *
            FROM ' . $this->table_name . ' WHERE  "discord_id" = :discordId';

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Инъекция
        $this->discordId=htmlspecialchars(strip_tags($this->discordId));

        // Привязываем значение e-mail
        //$stmt->bindParam(1, $this->discordId);
        $stmt->bindParam(':discordId', $this->discordId);

        // Выполняем запрос
        $stmt->execute();

        // Получаем количество строк
        $num = $stmt->rowCount();

        // Если электронная почта существует,
        // Присвоим значения свойствам объекта для легкого доступа и использования для php сессий
        if ($num > 0) {

            // Получаем значения
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Присвоим значения свойствам объекта
            $this->id = $row["id"];

            // Вернём "true", потому что в базе данных существует электронная почта
            return true;
        }

        // Вернём "false", если адрес электронной почты не существует в базе данных
        return false;
    }

    function getParticipants() {
        // Запрос, чтобы проверить, существует ли электронная почта
        $query = 'SELECT *
            FROM ' . $this->table_participants . ' WHERE  "match_id" = :match_id';

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Привязываем значение e-mail
        //$stmt->bindParam(1, $this->discordId);
        $stmt->bindParam(':match_id', $this->matchId);

        // Выполняем запрос
        $stmt->execute();

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $res['participants'] = $row;

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

            //// ПОЛУЧЕНИЕ ДАННЫХ О ПОЛЬЗОВАТЕЛЕ
            $query_gamers = 'SELECT *
            FROM ' . $this->table_score . ' WHERE id_users=:id_users';
            // Подготовка запроса
            $stmt_gamers = $this->conn->prepare($query_gamers);
            // Привязываем значения
            $stmt_gamers->bindParam(':id_users', $row_user['id']);
            // Выполняем запрос
            $stmt_gamers->execute();
            // Получаем значения
            $row_gamers = $stmt_gamers->fetch(PDO::FETCH_ASSOC);

            $res['score'][$row_user['id']] = $row_gamers;
        }

        return $res;

    }

    function getCommandsDraft($commands, $round = 1) {
        // Запрос, чтобы проверить, существует ли электронная почта
        $query = 'SELECT *
            FROM ' . $this->table_round_users . ' WHERE  "match_id" = :match_id AND "commands" = :commands AND "round" = :round ORDER BY "id" ASC';

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Привязываем значение e-mail
        //$stmt->bindParam(1, $this->discordId);
        $stmt->bindParam(':match_id', $this->matchId);
        $stmt->bindParam(':commands', $commands);
        $stmt->bindParam(':round', $round);

        // Выполняем запрос
        $stmt->execute();

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $res['gamers'] = $row;

        for($i = 0; $i < count($row); $i++) {
            //// ПОЛУЧЕНИЕ ДАННЫХ О ПОЛЬЗОВАТЕЛЕ
            $query_user = 'SELECT *
            FROM ' . $this->table_name_users . ' WHERE id=:id';
            // Подготовка запроса
            $stmt_user = $this->conn->prepare($query_user);
            // Привязываем значения
            $stmt_user->bindParam(':id', $row[$i]['user_id']);
            // Выполняем запрос
            $stmt_user->execute();
            // Получаем значения
            $row_user = $stmt_user->fetch(PDO::FETCH_ASSOC);
            $res['users_info'][$row_user['id']] = $row_user;

            //// ПОЛУЧЕНИЕ ДАННЫХ О ПОЛЬЗОВАТЕЛЕ
            $query_gamers = 'SELECT *
            FROM ' . $this->table_score . ' WHERE id_users=:id_users';
            // Подготовка запроса
            $stmt_gamers = $this->conn->prepare($query_gamers);
            // Привязываем значения
            $stmt_gamers->bindParam(':id_users', $row_user['id']);
            // Выполняем запрос
            $stmt_gamers->execute();
            // Получаем значения
            $row_gamers = $stmt_gamers->fetch(PDO::FETCH_ASSOC);

            $res['score'][$row_user['id']] = $row_gamers;
        }

        return $res;

    }

    function getGamers() {
        // Запрос, чтобы проверить, существует ли электронная почта
        $query = 'SELECT *
            FROM ' . $this->table_participants . ' WHERE  "match_id" = :match_id AND "used" = :used';

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Привязываем значение e-mail
        //$stmt->bindParam(1, $this->discordId);
        $used = 0;
        $stmt->bindParam(':match_id', $this->matchId);
        $stmt->bindParam(':used', $used);

        // Выполняем запрос
        $stmt->execute();

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

            //// ПОЛУЧЕНИЕ ДАННЫХ О ПОЛЬЗОВАТЕЛЕ
            $query_gamers = 'SELECT *
            FROM ' . $this->table_score . ' WHERE id_users=:id_users';
            // Подготовка запроса
            $stmt_gamers = $this->conn->prepare($query_gamers);
            // Привязываем значения
            $stmt_gamers->bindParam(':id_users', $row_user['id']);
            // Выполняем запрос
            $stmt_gamers->execute();
            // Получаем значения
            $row_gamers = $stmt_gamers->fetch(PDO::FETCH_ASSOC);

            $res['score'][$row_user['id']] = $row_gamers;
        }

        $res['gamers'] = $row;
        return $res;

    }

    function deleteParticipants($id) {
        // Запрос, чтобы проверить, существует ли электронная почта
        $query = 'DELETE FROM ' . $this->table_participants . ' WHERE  "id" = :id';

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Привязываем значение e-mail
        //$stmt->bindParam(1, $this->discordId);
        $stmt->bindParam(':id', $id);

        // Выполняем запрос
        $stmt->execute();

    }

    function getUsers($id_discord = null) {
        // Запрос, чтобы проверить, существует ли электронная почта
        $query = 'SELECT *
            FROM ' . $this->table_name . ' WHERE  "discord_id" = :discord_id';

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Привязываем значение e-mail
        //$stmt->bindParam(1, $this->discordId);
        $stmt->bindParam(':discord_id', $id_discord);

        // Выполняем запрос
        $stmt->execute();

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        return $res;
    }
}