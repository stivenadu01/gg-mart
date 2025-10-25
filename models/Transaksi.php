<?php

function getTransaksiList($page = 1, $limit = 10, $search = null, $start = null, $end = null, $metode = null, $order_by = 'tanggal_transaksi', $order_dir = 'DESC')
{
  global $conn;
  $offset = ($page - 1) * $limit;
  $conditions = [];

  if ($search) {
    $safe = "%" . $conn->real_escape_string($search) . "%";
    $conditions[] = "t.kode_transaksi LIKE '$safe'";
  }

  if ($start && $end) {
    $safeStart = $conn->real_escape_string($start);
    $safeEnd = $conn->real_escape_string($end);
    $conditions[] = "DATE(t.tanggal_transaksi) BETWEEN '$safeStart' AND '$safeEnd'";
  }

  if ($metode) {
    $safeMetode = $conn->real_escape_string($metode);
    $conditions[] = "t.metode_bayar = '$safeMetode'";
  }

  $where = count($conditions) > 0 ? "WHERE " . implode(" AND ", $conditions) : "";

  $total = $conn->query("SELECT COUNT(*) AS total FROM transaksi t $where")->fetch_assoc()['total'] ?? 0;

  $res = $conn->query("
      SELECT t.*, u.nama AS kasir
      FROM transaksi t
      LEFT JOIN user u ON t.id_user = u.id_user
      $where
      ORDER BY t.$order_by $order_dir
      LIMIT $limit OFFSET $offset
    ");

  $data = [];
  while ($row = $res->fetch_assoc()) $data[] = $row;

  return [$data, $total];
}

function findTransaksi($kode_transaksi)
{
  global $conn;
  $stmt = $conn->prepare("SELECT * FROM transaksi WHERE kode_transaksi = ?");
  $stmt->bind_param("s", $kode_transaksi);
  $stmt->execute();
  $res = $stmt->get_result()->fetch_assoc();
  $stmt->close();
  return $res;
}

function tambahTransaksi($data)
{
  global $conn;
  $sql = "INSERT INTO transaksi (kode_transaksi, id_user, total_harga, total_pokok, status, metode_bayar)
          VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "siddss",
    $data['kode_transaksi'],
    $data['id_user'],
    $data['total_harga'],
    $data['total_pokok'],
    $data['status'],
    $data['metode_bayar']
  );
  $res = $stmt->execute();
  $stmt->close();
  return $res;
}

function hapusTransaksi($kode_transaksi)
{
  global $conn;
  $stmt = $conn->prepare("DELETE FROM transaksi WHERE kode_transaksi = ?");
  $stmt->bind_param("s", $kode_transaksi);
  $res = $stmt->execute();
  $stmt->close();
  return $res;
}

function getPendapatanByDate($date)
{
  global $conn;
  $safe = $conn->real_escape_string($date);
  $sql = "SELECT COALESCE(SUM(total_harga), 0) AS pendapatan FROM transaksi WHERE DATE(tanggal_transaksi) = '$safe'";
  $res = $conn->query($sql);
  return floatval($res ? $res->fetch_assoc()['pendapatan'] : 0);
}

function getProdukTerjualByDate($date)
{
  global $conn;
  $safe = $conn->real_escape_string($date);
  $sql = "
    SELECT COALESCE(SUM(dt.jumlah), 0) AS total_item
    FROM detail_transaksi dt
    JOIN transaksi t ON dt.kode_transaksi = t.kode_transaksi
    WHERE DATE(t.tanggal_transaksi) = '$safe'
  ";
  $res = $conn->query($sql);
  return intval($res ? $res->fetch_assoc()['total_item'] : 0);
}
