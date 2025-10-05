<?php
models('produk');
if ($_GET['act'] == 'hapus') {
  $produk = getProdukByKode($_GET['k'] ?? '');
  if (!$produk) {
    set_flash('Error', 'error', "Produk tidak ditemukan.");
  } else {
    hapusProduk($produk['kode_produk']);
    $uploadDir = ROOT_PATH . '/public/uploads/';
    if (!empty($produk['gambar']) && file_exists($uploadDir . $produk['gambar'])) {
      unlink($uploadDir . $produk['gambar']);
    }
    set_flash('Sukses', 'success', "Produk berhasil dihapus.");
  }
  header("Location: " . url('admin/produk'));
  exit;
}

// kalau bukan aksi hapus, berarti simpan (tambah/edit)
// Ambil data dari form
$act           = $_POST['act'] ?? 'tambah';
$kode_produk   = $_POST['kode_produk'] ?? null;
$nama_produk   = trim($_POST['nama_produk']);
$harga         = $_POST['harga'] ?? 0;
$stok          = $_POST['stok'] ?? 0;
$deskripsi     = trim($_POST['deskripsi']);
$izin_edar     = isset($_POST['izin_edar']) ? (int)$_POST['izin_edar'] : 0;
$gambar_lama   = $_POST['gambar_lama'] ?? '';

// --- Validasi dasar ---
$errors = [];

if (strlen($nama_produk) > 100) {
  $errors[] = "Nama produk maksimal 50 karakter.";
}

if (strlen($deskripsi) > 65000) {
  $errors[] = "Deskripsi terlalu panjang (maksimal 65.000 karakter).";
}


if (!is_numeric($harga) || $harga <= 0 || strlen($harga) > 11) {
  $errors[] = "Harga harus berupa angka positif maksimal 11 digit.";
}

if (!is_numeric($stok) || $stok < 0 || strlen($stok) > 5) {
  $errors[] = "Stok harus berupa angka positif maksimal 5 digit.";
}

if (!empty($errors)) {
  foreach ($errors as $error) {
    set_flash('Error', 'error', $error);
  }
}

// --- Upload gambar (jika ada) ---
$gambar_nama = $gambar_lama;
if (!empty($_FILES['gambar']['name'])) {
  $fileName = $_FILES['gambar']['name'];
  $tmpName  = $_FILES['gambar']['tmp_name'];
  $fileSize = $_FILES['gambar']['size'];
  $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
  $allowed  = ['jpg', 'jpeg', 'png', 'webp'];

  if (!in_array($fileExt, $allowed)) {
    set_flash('Error', 'error', "Format gambar tidak didukung. Gunakan JPG, PNG, atau WEBP.");
  }

  if ($fileSize > 2 * 1024 * 1024) { // max 2MB
    set_flash('Error', 'error', "Ukuran gambar terlalu besar (maksimal 2MB).");
  }

  // Simpan file
  $newName = uniqid('IMG_PRD_') . '.' . $fileExt;
  $uploadDir = ROOT_PATH . '/public/uploads/';
  if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
  move_uploaded_file($tmpName, $uploadDir . $newName);

  // Hapus gambar lama (jika ada dan berbeda)
  if ($gambar_lama && file_exists($uploadDir . $gambar_lama)) {
    unlink($uploadDir . $gambar_lama);
  }

  $gambar_nama = $newName;
}

// --- Simpan ke database ---
$data = [
  'nama_produk' => $nama_produk,
  'harga'       => $harga,
  'stok'        => $stok,
  'gambar'      => $gambar_nama,
  'deskripsi'   => $deskripsi,
  'izin_edar'   => $izin_edar,
];
if ($act === 'edit' && $kode_produk) {
  updateProduk($kode_produk, $data);
  set_flash("Produk berhasil diperbarui.", 'success');
} else {
  $kode_produk = uniqid('PRD_') . strtoupper(bin2hex(random_bytes(3)));
  $data['kode_produk'] = $kode_produk;
  tambahProduk($data);
  set_flash("Produk berhasil ditambahkan.", 'success');
}

// --- Redirect kembali ke halaman produk ---
header("Location: " . url('admin/produk'));
exit;
