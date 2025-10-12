<?php
function get_db_connection()
{
  // 4. Database Connection
  $host = $_ENV['DB_HOST'];
  $user = $_ENV['DB_USER'];
  $pass = $_ENV['DB_PASS'];
  $name = $_ENV['DB_NAME'];

  try {
    $conn = new mysqli($host, $user, $pass, $name);
    return $conn;
  } catch (Throwable $th) {
    die("Database connection failed");
  }
}
