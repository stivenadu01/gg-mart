<?php
models('produk');

$act = $_GET['act'] ?? null;

switch ($act) {
  case 'tambah':
    tambahKeranjang();
    break;

  case 'hapus':
    hapusKeranjang();
    break;

  case 'update':
    updateKeranjang();
    break;

  default:
    redirect_back();
    break;
}
redirect_back();

function tambahKeranjang()
{

  // pastikan user login
  if (!isset($_SESSION['user'])) {
    set_flash('Silakan login untuk menambahkan ke keranjang!');
    redirect('login');
    return;
  }

  $id_user = $_SESSION['user']['id_user'];
  $kode_produk = $_POST['kode_produk'] ?? null;
  $jumlah = (int)($_POST['jumlah'] ?? 1);

  if (!$kode_produk) {
    set_flash('Produk tidak valid!');
    redirect('produk');
    return;
  }

  // Pastikan produk ada
  $produk = getProdukByKode($kode_produk);
  if (!$produk) {
    set_flash('Produk tidak ditemukan!');
    redirect('produk');
    return;
  }

  // Cek apakah produk sudah ada di keranjang user ini
  $stmt = $conn->prepare("SELECT * FROM keranjang WHERE id_user = ? AND kode_produk = ?");
  $stmt->bind_param("is", $id_user, $kode_produk);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
    // Jika sudah ada, tambahkan jumlah
    $newJumlah = $row['jumlah'] + $jumlah;
    $update = $conn->prepare("UPDATE keranjang SET jumlah = ? WHERE id_keranjang = ?");
    $update->bind_param("ii", $newJumlah, $row['id_keranjang']);
    $update->execute();
  } else {
    // Jika belum ada, tambahkan baris baru
    $insert = $conn->prepare("INSERT INTO keranjang (id_user, kode_produk, jumlah) VALUES (?, ?, ?)");
    $insert->bind_param("isi", $id_user, $kode_produk, $jumlah);
    $insert->execute();
  }

  set_flash('Produk berhasil ditambahkan ke keranjang!');
  redirect('keranjang');
}

function hapusKeranjang()
{
  global $conn;

  if (!isset($_SESSION['user'])) {
    set_flash('Silakan login terlebih dahulu!');
    redirect('login');
    return;
  }

  $id_user = $_SESSION['user']['id_user'];
  $kode_produk = $_GET['k'] ?? null;

  if (!$kode_produk) {
    set_flash('Produk tidak valid!');
    redirect('keranjang');
    return;
  }

  $stmt = $conn->prepare("DELETE FROM keranjang WHERE id_user = ? AND kode_produk = ?");
  $stmt->bind_param("is", $id_user, $kode_produk);
  $stmt->execute();

  set_flash('Produk dihapus dari keranjang!');
  redirect('keranjang');
}

function updateKeranjang()
{
  global $conn;

  if (!isset($_SESSION['user'])) {
    set_flash('Silakan login terlebih dahulu!');
    redirect('login');
    return;
  }

  $id_user = $_SESSION['user']['id_user'];
  if (isset($_POST['jumlah']) && is_array($_POST['jumlah'])) {
    foreach ($_POST['jumlah'] as $kode_produk => $jumlah) {
      $jumlah = max(1, (int)$jumlah);
      $stmt = $conn->prepare("UPDATE keranjang SET jumlah = ? WHERE id_user = ? AND kode_produk = ?");
      $stmt->bind_param("iis", $jumlah, $id_user, $kode_produk);
      $stmt->execute();
    }
    set_flash('Keranjang diperbarui!');
  }

  redirect('keranjang');
}
