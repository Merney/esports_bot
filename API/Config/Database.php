<?php

class Database
{
  // Учётные данные базы данных
  private $host = "localhost";
  private $db_name = "esports";
  private $username = "postgres";
  private $password = "989814140202i";
  public $conn;

  // Получаем соединение с базой данных
  public function getConnection()
  {
    $this->conn = null;

    try {
      $this->conn = new PDO("pgsql:host=" . $this->host . ";port=5432;dbname=" . $this->db_name, $this->username, $this->password);
    } catch (PDOException $exception) {
      echo "Ошибка соединения с БД: " . $exception->getMessage();
    }

    return $this->conn;
  }
}
