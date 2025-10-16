<?php

function getDetailTransaksi($id_transaksi)
{
  global $conn;
  $stmt = $conn->prepare("
    SELECT d.*, p.nama_produk 
    FROM detail_transaksi d
    JOIN produk p ON d.kode_produk = p.kode_produk
    WHERE d.id_transaksi = ?
  ");
  $stmt->bind_param("i", $id_transaksi);
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

  $sql = "INSERT INTO detail_transaksi (id_transaksi, kode_produk, jumlah, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "isiii",
    $data['id_transaksi'],
    $data['kode_produk'],
    $data['jumlah'],
    $data['harga_satuan'],
    $data['subtotal']
  );
  $res = $stmt->execute();
  return $res;
}

function hapusDetailTransaksi($id_transaksi)
{
  global $conn;
  $stmt = $conn->prepare("DELETE FROM detail_transaksi WHERE id_transaksi=?");
  $stmt->bind_param("i", $id_transaksi);
  $res = $stmt->execute();
  $stmt->close();
  return $res;
}
