<?php

function getTransaksiList($page = 1, $limit = 10, $search = null, $start = null, $end = null, $metode = null,  $order_by = 'tanggal_transaksi', $order_dir = 'DESC')
{
  global $conn;
  $offset = ($page - 1) * $limit;

  $conditions = [];

  // filter search
  if ($search) {
    $safe = "%" . $conn->real_escape_string($search) . "%";
    $conditions[] = "kode_transaksi LIKE '$safe'";
  }

  // filter tanggal
  if ($start && $end) {
    $safeStart = $conn->real_escape_string($start);
    $safeEnd = $conn->real_escape_string($end);
    $conditions[] = "DATE(tanggal_transaksi) BETWEEN '$safeStart' AND '$safeEnd'";
  }
  // filter metode bayar
  if ($metode) {
    $safeMetode = $conn->real_escape_string($metode);
    $conditions[] = "metode_bayar = '$safeMetode'";
  }
  // search id transaksi
  if ($search) {
    $safeSearch = "%" . $conn->real_escape_string($search) . "%";
    $where = "WHERE p.nama_produk LIKE '$safeSearch' OR k.nama_kategori LIKE '$safeSearch'";
  }


  $where = '';
  if (count($conditions) > 0) {
    $where = "WHERE " . implode(" AND ", $conditions);
  }

  // hitung total
  $resCount = $conn->query("SELECT COUNT(*) AS total FROM transaksi $where");
  $total = $resCount->fetch_assoc()['total'];

  // ambil data
  $res = $conn->query("
      SELECT t.*, u.nama AS kasir
      FROM transaksi t
      LEFT JOIN user u ON t.id_user = u.id_user
      $where
      ORDER BY t.$order_by $order_dir
      LIMIT $limit OFFSET $offset
    ");

  $data = [];
  while ($row = $res->fetch_assoc()) {
    $data[] = $row;
  }

  return [$data, $total];
}


function findTransaksi($id_transaksi)
{
  global $conn;
  $sql = "SELECT * FROM transaksi WHERE id_transaksi=$id_transaksi";
  $result = $conn->query($sql);
  $result = $result->fetch_assoc();
  return $result;
}

function tambahTransaksi($data)
{
  global $conn;
  $sql = "INSERT INTO transaksi (id_user, total_harga, status, kode_transaksi, metode_bayar) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "iisss",
    $data['id_user'],
    $data['total_harga'],
    $data['status'],
    $data['kode_transaksi'],
    $data['metode_bayar']
  );
  $stmt->execute();
  $insert_id = $stmt->insert_id;
  $stmt->close();
  return $insert_id; // kembalikan id transaksi baru
}

function updateTransaksi($id_transaksi, $data)
{
  global $conn;
  $sql = "UPDATE transaksi SET total_harga=?, status=?, metode_bayar=? WHERE id_transaksi=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "issi",
    $data['total_harga'],
    $data['status'],
    $data['metode_bayar'],
    $id_transaksi
  );
  $res = $stmt->execute();
  $stmt->close();
  return $res;
}

function hapusTransaksi($id_transaksi)
{
  global $conn;
  $stmt = $conn->prepare("DELETE FROM transaksi WHERE id_transaksi=?");
  $stmt->bind_param("i", $id_transaksi);
  $res = $stmt->execute();
  $stmt->close();
  return $res;
}



// tambahan
function getPendapatanByDate($date)
{
  global $conn;
  $safe = $conn->real_escape_string($date);
  $sql = "
    SELECT COALESCE(SUM(total_harga), 0) AS pendapatan
    FROM transaksi
    WHERE DATE(tanggal_transaksi) = '{$safe}'
  ";
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
    JOIN transaksi t ON dt.id_transaksi = t.id_transaksi
    WHERE DATE(t.tanggal_transaksi) = '{$safe}'
  ";
  $res = $conn->query($sql);
  return intval($res ? $res->fetch_assoc()['total_item'] : 0);
}
