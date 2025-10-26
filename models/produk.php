<?php

function findProduk($kode)
{
  global $conn;
  $stmt = $conn->prepare("SELECT * FROM produk WHERE kode_produk = ?");
  $stmt->bind_param("s", $kode);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();
  $stmt->close();
  return $result;
}

function getDropdownProduk($search)
{
  global $conn;
  $search = $conn->real_escape_string($search);
  $sql = "
    SELECT kode_produk, nama_produk, satuan_dasar
    FROM produk 
    WHERE nama_produk LIKE '%$search%' 
       OR kode_produk LIKE '%$search%' 
    ORDER BY nama_produk ASC 
    LIMIT 10
  ";
  $res = $conn->query($sql);
  $produk = [];
  while ($row = $res->fetch_assoc()) {
    $produk[] = $row;
  }
  return $produk;
}


function getProdukList($page = 1, $limit = 10, $search = '', $order_by = 'tanggal_dibuat', $order_dir = 'DESC')
{
  global $conn;
  $offset = ($page - 1) * $limit;

  $allowed_order = ['tanggal_dibuat', 'nama_produk', 'harga_jual', 'stok', 'terjual'];
  if (!in_array($order_by, $allowed_order)) $order_by = 'tanggal_dibuat';
  $order_dir = strtoupper($order_dir) === 'ASC' ? 'ASC' : 'DESC';

  $where = "";
  if ($search !== '') {
    $safe = "%" . $conn->real_escape_string($search) . "%";
    $where = "WHERE (
      p.nama_produk LIKE '$safe' OR
      p.kode_produk LIKE '$safe' OR
      p.deskripsi LIKE '$safe' OR
      k.nama_kategori LIKE '$safe' OR
      k.deskripsi LIKE '$safe'
    )";
  }

  $sqlCount = "
    SELECT COUNT(*) AS total
    FROM produk p
    LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
    $where
  ";
  $total = $conn->query($sqlCount)->fetch_assoc()['total'] ?? 0;

  $sqlData = "
    SELECT 
      p.*, 
      k.nama_kategori
    FROM produk p
    LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
    $where
    ORDER BY $order_by $order_dir
    LIMIT $limit OFFSET $offset
  ";
  $res = $conn->query($sqlData);
  $produk = [];
  while ($row = $res->fetch_assoc()) {
    $produk[] = $row;
  }

  return [$produk, $total];
}

function tambahProduk($data)
{
  global $conn;
  $sql = "INSERT INTO produk (kode_produk, id_kategori, nama_produk, deskripsi, harga_jual, stok, gambar, satuan_dasar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "sissdiss",
    $data['kode_produk'],
    $data['id_kategori'],
    $data['nama_produk'],
    $data['deskripsi'],
    $data['harga_jual'],
    $data['stok'],
    $data['gambar'],
    $data['satuan_dasar']
  );
  $res = $stmt->execute();
  $stmt->close();
  return $res;
}

function editProduk($kode, $data)
{
  global $conn;
  $allowed = ['nama_produk', 'id_kategori', 'deskripsi', 'harga_jual', 'stok', 'terjual', 'gambar', 'satuan_dasar'];
  $set = [];
  $params = [];
  $types = '';

  foreach ($allowed as $col) {
    if (isset($data[$col])) {
      $set[] = "$col = ?";
      $params[] = $data[$col];
      $types .= in_array($col, ['id_kategori', 'stok', 'terjual']) ? 'i' : (in_array($col, ['harga_jual']) ? 'd' : 's');
    }
  }

  if (empty($set)) return false;

  $sql = "UPDATE produk SET " . implode(', ', $set) . " WHERE kode_produk = ?";
  $params[] = $kode;
  $types .= 's';

  $stmt = $conn->prepare($sql);
  $stmt->bind_param($types, ...$params);
  $res = $stmt->execute();
  $stmt->close();
  return $res;
}

function hapusProduk($kode)
{
  global $conn;
  $stmt = $conn->prepare("DELETE FROM produk WHERE kode_produk = ?");
  $stmt->bind_param("s", $kode);
  $res = $stmt->execute();
  $stmt->close();
  return $res;
}

// tambahan
function updateStokProduk($kode)
{
  global $conn;
  $stok = $conn->query("SELECT SUM(sisa_stok) as total FROM mutasi_stok where kode_produk='$kode' AND type='masuk'")->fetch_assoc()['total'];

  return $conn->query("UPDATE produk SET stok = '$stok' WHERE kode_produk='$kode'");
}

function getProdukTrx($search)
{
  global $conn;
  $safe = "%" . $conn->real_escape_string($search) . "%";
  $res = $conn->query("SELECT p.*, k.nama_kategori FROM produk p LEFT JOIN kategori k ON p.id_kategori = k.id_kategori WHERE nama_produk LIKE '$safe' OR kode_produk LIKE '$safe' ORDER BY stok DESC LIMIT 10");
  $data = [];
  while ($row = $res->fetch_assoc()) {
    $data[] = $row;
  }
  return $data;
}

function ubahTerjualProduk($kode, $jumlah)
{
  global $conn;
  return $conn->query("UPDATE produk SET terjual= terjual + '$jumlah' WHERE kode_produk='$kode'");
}
