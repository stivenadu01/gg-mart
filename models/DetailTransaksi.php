<?php

function getDetailTransaksi($kode_transaksi)
{
  global $conn;
  $stmt = $conn->prepare("
    SELECT d.*, p.nama_produk 
    FROM detail_transaksi d
    LEFT JOIN produk p ON d.kode_produk = p.kode_produk
    WHERE d.kode_transaksi = ?
  ");
  $stmt->bind_param("s", $kode_transaksi);
  $stmt->execute();
  $res = $stmt->get_result();
  $data = [];
  while ($row = $res->fetch_assoc()) {
    $data[] = $row;
  }
  $stmt->close();
  return $data;
}

function tambahDetailTransaksi($data)
{
  global $conn;
  $sql = "INSERT INTO detail_transaksi (kode_transaksi, kode_produk, jumlah, harga_satuan, harga_pokok, subtotal, subtotal_pokok)
          VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "ssidddd",
    $data['kode_transaksi'],
    $data['kode_produk'],
    $data['jumlah'],
    $data['harga_satuan'],
    $data['harga_pokok'],
    $data['subtotal'],
    $data['subtotal_pokok']
  );
  $res = $stmt->execute();
  $stmt->close();
  return $res;
}

function hapusDetailTransaksi($kode_transaksi)
{
  global $conn;
  $stmt = $conn->prepare("DELETE FROM detail_transaksi WHERE kode_transaksi = ?");
  $stmt->bind_param("s", $kode_transaksi);
  $res = $stmt->execute();
  $stmt->close();
  return $res;
}
