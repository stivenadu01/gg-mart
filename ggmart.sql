-- =====================================================
-- DATABASE: gg_mart
-- =====================================================
CREATE DATABASE IF NOT EXISTS gg_mart;
USE gg_mart;

-- =====================================================
-- TABLE: user
-- =====================================================
CREATE TABLE user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    tanggal_dibuat DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- =====================================================
-- TABLE: kategori
-- =====================================================
CREATE TABLE kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    deskripsi TEXT
);

-- =====================================================
-- TABLE: produk
-- =====================================================
CREATE TABLE produk (
    kode_produk CHAR(12) PRIMARY KEY,
    id_kategori INT,
    nama_produk VARCHAR(150) NOT NULL,
    deskripsi TEXT,
    harga INT NOT NULL,
    stok INT DEFAULT 0,
    terjual INT DEFAULT 0,
    gambar VARCHAR(255),
    tanggal_dibuat DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_produk_kategori
        FOREIGN KEY (id_kategori)
        REFERENCES kategori(id_kategori)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

-- =====================================================
-- TABLE: transaksi
-- =====================================================
CREATE TABLE transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    tanggal_transaksi DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_harga INT NOT NULL,
    status ENUM('pending','diproses','dikirim','selesai','batal') DEFAULT 'pending',
    kode_transaksi CHAR(15) UNIQUE,
    metode_bayar ENUM('QRIS','TUNAI') DEFAULT 'TUNAI',
    CONSTRAINT fk_transaksi_user
        FOREIGN KEY (id_user)
        REFERENCES user(id_user)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- =====================================================
-- TABLE: detail_transaksi
-- =====================================================
CREATE TABLE detail_transaksi (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT NOT NULL,
    kode_produk CHAR(12),
    jumlah INT DEFAULT 1,
    harga_satuan INT NOT NULL,
    subtotal INT NOT NULL,

    CONSTRAINT fk_detail_transaksi
        FOREIGN KEY (id_transaksi)
        REFERENCES transaksi(id_transaksi)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_detail_produk
        FOREIGN KEY (kode_produk)
        REFERENCES produk(kode_produk)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);
