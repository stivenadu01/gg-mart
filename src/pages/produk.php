<?php
models('produk');

// nilai default
$urutkan = $_GET['urutkan'] ?? 'sesuai';
$q = $_GET['q'] ?? '';

// Array Opsi Pengurutan yang lebih menarik
$opsi_urutkan = [
  'sesuai' => 'Paling Sesuai',
  'termahal' => 'Harga Tertinggi',
  'termurah' => 'Harga Terendah',
  'terlaris' => 'Paling Laris (Terjual)',
  'terbaru' => 'Terbaru Ditambahkan',
];

$daftarProduk = getFilteredProduk($q, $urutkan);


$pageTitle = "Produk";
include COMPONENTS_PATH . '/user/header.php';

?>

<div class="container mx-auto sticky top-[3.35rem] z-10 bg-white p-2 px-4 shadow-md">

  <div class="flex justify-between items-center text-sm">
    <p class="text-gray-600 hidden lg:inline-block">
      Menampilkan 1 - <?= count($daftarProduk) ?> barang dari total untuk **<?= $q !== '' ? $q : 'semua produk' ?>**
    </p>

    <div
      class="flex items-center space-x-2"
      x-data="{ 
        urutkan: '<?= $urutkan ?>', 
        q: '<?= $q ?? '' ?>',
        
        // Fungsi yang dijalankan saat select berubah
        handleChange() {
            window.location.href = `?q=${this.q}&urutkan=${this.urutkan}`;
        }
    }">
      <label for="urutkan" class="text-gray-600">Urutkan:</label>

      <select
        id="urutkan"
        name="urutkan"
        x-model="urutkan"
        @change="handleChange()"
        class="appearance-none w-44 bg-white border border-gray-300 rounded-lg px-4 py-2 pr-10
             text-gray-700 font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500
             hover:border-green-400 transition-all duration-200 cursor-pointer">
        <?php foreach ($opsi_urutkan as $value => $label): ?>
          <option value="<?= $value ?>">
            <?= $label ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>

</div>


<?php
include COMPONENTS_PATH . "/produk_card.php"
?>

<?php
include COMPONENTS_PATH . '/user/footer.php';
?>