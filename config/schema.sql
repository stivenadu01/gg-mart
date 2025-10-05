-- DATABASE
CREATE DATABASE IF NOT EXISTS gg_mart;
USE gg_mart;

-- TABEL user
CREATE TABLE `user` (
  `id_user` INT(11) NOT NULL AUTO_INCREMENT,
  `nama` CHAR(50) NOT NULL,
  `email` CHAR(50) NOT NULL,
  `password` CHAR(255) NOT NULL,
  `no_hp` CHAR(255),
  `role` ENUM('user','admin') NOT NULL DEFAULT 'user',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `uq_user_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABEL produk
CREATE TABLE `produk` (
  `kode_produk` CHAR(11) NOT NULL,
  `nama_produk` CHAR(50) NOT NULL,
  `harga` INT(11) NOT NULL,
  `stok` INT(4) NOT NULL,
  `gambar` CHAR(100) NOT NULL,
  `deskripsi` TEXT NOT NULL,
  `izin_edar` BOOLEAN NOT NULL DEFAULT FALSE,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`kode_produk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABEL transaksi
CREATE TABLE `transaksi` (
  `id_transaksi` CHAR(11) NOT NULL,
  `id_user` INT(11) NOT NULL,
  `tanggal_transaksi` DATE NOT NULL,
  `total_harga` INT(11) NOT NULL,
  `status` ENUM('selesai','belum_dibayar','dibatalkan') NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_transaksi`),
  CONSTRAINT `fk_transaksi_user` FOREIGN KEY (`id_user`)
    REFERENCES `user` (`id_user`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABEL detail_transaksi
CREATE TABLE `detail_transaksi` (
  `id_detail` INT(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` CHAR(11) NOT NULL,
  `kode_produk` CHAR(11) NOT NULL,
  `jumlah` INT(4) NOT NULL,
  `harga_satuan` INT(11) NOT NULL,
  `subtotal` INT(11) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_detail`),
  CONSTRAINT `fk_detail_transaksi_transaksi` FOREIGN KEY (`id_transaksi`)
    REFERENCES `transaksi` (`id_transaksi`)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT `fk_detail_transaksi_produk` FOREIGN KEY (`kode_produk`)
    REFERENCES `produk` (`kode_produk`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE keranjang (
    id_keranjang INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    kode_produk CHAR(11) NOT NULL,
    jumlah INT NOT NULL DEFAULT 1,
    tanggal_ditambahkan DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE CASCADE,
    FOREIGN KEY (kode_produk) REFERENCES produk(kode_produk) ON DELETE CASCADE
);
