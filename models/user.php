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

function createUser($name, $email, $no_hp, $hashedPassword)
{
  $conn = get_db_connection();
  $stmt = $conn->prepare("INSERT INTO user (nama, email, no_hp, password) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $name, $email, $no_hp, $hashedPassword);
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

function emailExists($email)
{
  $conn = get_db_connection();
  $stmt = $conn->prepare("SELECT id_user FROM user WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();
  $exists = $stmt->num_rows > 0;
  $stmt->close();
  $conn->close();
  return $exists;
}
