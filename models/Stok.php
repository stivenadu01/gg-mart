<?php

function getAllStok()
{
  global $conn;
  $sql = "
    SELECT s.id_stok, s.kode_produk, p.nama_produk, s.tipe, s.jumlah, s.keterangan, s.tanggal
    FROM stok s
    LEFT JOIN produk p ON s.kode_produk = p.kode_produk
    ORDER BY s.tanggal DESC
  ";
  $res = $conn->query($sql);

  $stok = [];
  while ($row = $res->fetch_assoc()) {
    $stok[] = $row;
  }
  return $stok;
}

function tambahStok($data)
{
  global $conn;
  $sql = "INSERT INTO stok (kode_produk, tipe, jumlah, keterangan, tanggal)
          VALUES (?, ?, ?, ?, NOW())";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "ssis",
    $data['kode_produk'],
    $data['tipe'],
    $data['jumlah'],
    $data['keterangan']
  );
  $result = $stmt->execute();
  $stmt->close();
  return $result;
}

function hapusStok($id)
{
  global $conn;
  $sql = "DELETE FROM stok WHERE id_stok = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $result = $stmt->execute();
  $stmt->close();
  return $result;
}
