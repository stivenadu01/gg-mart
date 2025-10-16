<?php

function findKategori($id)
{
  global $conn;
  $res = $conn->query("SELECT * FROM kategori WHERE id_kategori = $id");
  $result = $res->fetch_assoc();
  return $result;
}
function getAllKategori()
{
  global $conn;
  $sql = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
  $res = $conn->query($sql);

  $kategori = [];
  while ($row = $res->fetch_assoc()) {
    $kategori[] = $row;
  }

  return $kategori;
}

function getKategoriList($page = 1, $limit = 10, $search = '')
{
  global $conn;
  $offset = ($page - 1) * $limit;

  $where = "";
  if ($search !== '') {
    $safe = "%" . $conn->real_escape_string($search) . "%";
    $where = "WHERE nama_kategori LIKE '$safe' OR deskripsi LIKE '$safe'";
  }

  // Hitung total
  $resCount = $conn->query("SELECT COUNT(*) AS total FROM kategori $where");
  $total = $resCount->fetch_assoc()['total'];

  // Ambil data
  $res = $conn->query("
    SELECT id_kategori, nama_kategori, deskripsi
    FROM kategori
    $where
    ORDER BY id_kategori DESC
    LIMIT $limit OFFSET $offset
  ");

  $kategori = [];
  while ($row = $res->fetch_assoc()) {
    $kategori[] = $row;
  }

  return [$kategori, $total];
}

function tambahKategori($data)
{
  global $conn;
  $sql = "INSERT INTO kategori (nama_kategori, deskripsi) VALUES (?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $data['nama_kategori'], $data['deskripsi']);
  $result = $stmt->execute();
  $stmt->close();
  return $result;
}

function editKategori($id, $data)
{
  global $conn;
  $sql = "UPDATE kategori SET nama_kategori = ?, deskripsi = ? WHERE id_kategori = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssi", $data['nama_kategori'], $data['deskripsi'], $id);
  $result = $stmt->execute();
  $stmt->close();
  return $result;
}

function hapusKategori($id)
{
  global $conn;
  $stmt = $conn->prepare("DELETE FROM kategori WHERE id_kategori = ?");
  $stmt->bind_param('i', $id);
  $result = $stmt->execute();
  $stmt->close();
  return $result;
}
