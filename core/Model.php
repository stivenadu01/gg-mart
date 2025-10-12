<?php

class Model
{
  protected $table;
  protected $primaryKey;
  protected $conn;

  public function __construct()
  {
    $this->conn = get_db_connection();
  }



  public function find($id)
  {
    $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  public function insert($data)
  {
    $cols = implode(',', array_keys($data));
    $placeholders = implode(',', array_fill(0, count($data), '?'));
    $stmt = $this->conn->prepare("INSERT INTO {$this->table} ($cols) VALUES ($placeholders)");
    $stmt->bind_param(str_repeat('s', count($data)), ...array_values($data));
    return $stmt->execute();
  }

  public function update($id, $data)
  {
    $sets = implode(',', array_map(fn($k) => "$k = ?", array_keys($data)));
    $stmt = $this->conn->prepare("UPDATE {$this->table} SET $sets WHERE {$this->primaryKey} = ?");
    $stmt->bind_param(str_repeat('s', count($data)) . 's', ...array_merge(array_values($data), [$id]));
    return $stmt->execute();
  }

  public function delete($id)
  {
    $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
    $stmt->bind_param("s", $id);
    return $stmt->execute();
  }
}
