<?php

function getAllUsers()
{
  $conn = get_db_connection();
  $result = $conn->query("SELECT * FROM user");
  $user = [];
  while ($row = $result->fetch_assoc()) {
    $user[] = $row;
  }
  $conn->close();
  return $user;
}

function createUser($name, $email, $hashedPassword)
{
  $conn = get_db_connection();
  $stmt = $conn->prepare("INSERT INTO user (nama, email,  password) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $name, $email, $hashedPassword);
  $success = $stmt->execute();
  $stmt->close();
  $conn->close();
  return $success;
}

function getUserByEmail($email)
{
  $conn = get_db_connection();
  $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
  $stmt->close();
  $conn->close();
  return $user;
}
