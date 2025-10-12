<?php

function findKategori($id)
{
  $conn = get_db_connection();
  $stmt = $conn->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();
  $stmt->close();
  $conn->close();
  return $result;
}
function getAllKategori()
{
  $conn = get_db_connection();
  $sql = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
  $res = $conn->query($sql);

  $kategori = [];
  while ($row = $res->fetch_assoc()) {
    $kategori[] = $row;
  }

  $conn->close();
  return $kategori;
}

function getKategoriList($page = 1, $limit = 10, $search = '')
{
  $conn = get_db_connection();
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

  $conn->close();
  return [$kategori, $total];
}

function tambahKategori($data)
{
  $conn = get_db_connection();
  $sql = "INSERT INTO kategori (nama_kategori, deskripsi) VALUES (?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $data['nama_kategori'], $data['deskripsi']);
  $result = $stmt->execute();
  $stmt->close();
  $conn->close();
  return $result;
}

function editKategori($id, $data)
{
  $conn = get_db_connection();
  $sql = "UPDATE kategori SET nama_kategori = ?, deskripsi = ? WHERE id_kategori = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssi", $data['nama_kategori'], $data['deskripsi'], $id);
  $result = $stmt->execute();
  $stmt->close();
  $conn->close();
  return $result;
}

function hapusKategori($id)
{
  $conn = get_db_connection();
  $stmt = $conn->prepare("DELETE FROM kategori WHERE id_kategori = ?");
  $stmt->bind_param('i', $id);
  $result = $stmt->execute();
  $stmt->close();
  $conn->close();
  return $result;
}
