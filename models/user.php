<?php

function getUsers()
{
  global $conn;
  $result = $conn->query("SELECT * FROM user");
  $user = [];
  while ($row = $result->fetch_assoc()) {
    $user[] = $row;
  }
  return $user;
}

function tambahUser($name, $email, $hashedPassword)
{
  global $conn;
  $stmt = $conn->prepare("INSERT INTO user (nama, email,  password) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $name, $email, $hashedPassword);
  $success = $stmt->execute();
  $stmt->close();
  return $success;
}

function findUserByEmail($email)
{
  global $conn;
  $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
  $stmt->close();
  return $user;
}
