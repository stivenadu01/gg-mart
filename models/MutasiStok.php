<?php

function findMutasiStok($id_mutasi)
{
  global $conn;
  $stmt = $conn->prepare("SELECT * FROM mutasi_stok WHERE id_mutasi = ?");
  $stmt->bind_param("i", $id_mutasi);
  $stmt->execute();
  $res = $stmt->get_result()->fetch_assoc();
  $stmt->close();
  return $res;
}

function getMutasiStokList($page = 1, $limit = 10, $type = '', $search = '')
{
  global $conn;
  $offset = ($page - 1) * $limit;
  $where = [];

  if ($search !== '') {
    $safe = "%" . $conn->real_escape_string($search) . "%";
    $where[] = "(ms.nama_produk LIKE '$safe' OR ms.kode_produk LIKE '$safe' OR ms.keterangan LIKE '$safe')";
  }

  if ($type !== '') {
    $safeType = $conn->real_escape_string($type);
    $where[] = "ms.type = '$safeType'";
  }

  $whereClause = count($where) ? "WHERE " . implode(' AND ', $where) : "";

  $total = $conn->query("SELECT COUNT(*) AS total FROM mutasi_stok ms $whereClause")->fetch_assoc()['total'];

  $sql = "
    SELECT ms.*, p.nama_produk
    FROM mutasi_stok ms
    LEFT JOIN produk p ON ms.kode_produk = p.kode_produk
    $whereClause
    ORDER BY ms.tanggal DESC
    LIMIT $limit OFFSET $offset
  ";
  $res = $conn->query($sql);
  $data = [];
  while ($row = $res->fetch_assoc()) $data[] = $row;

  return [$data, $total];
}

function tambahMutasiStok($data)
{
  global $conn;
  $sql = "INSERT INTO mutasi_stok (kode_produk, nama_produk, type, jumlah, total_pokok, keterangan, harga_pokok, sisa_stok)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "sssiddsi",
    $data['kode_produk'],
    $data['nama_produk'],
    $data['type'],
    $data['jumlah'],
    $data['total_pokok'],
    $data['keterangan'],
    $data['harga_pokok'],
    $data['sisa_stok']
  );
  $res = $stmt->execute();
  $stmt->close();
  return $res;
}

function hapusMutasiStok($id)
{
  global $conn;
  $stmt = $conn->prepare("DELETE FROM mutasi_stok WHERE id_mutasi = ?");
  $stmt->bind_param("i", $id);
  $res = $stmt->execute();
  $stmt->close();
  return $res;
}
