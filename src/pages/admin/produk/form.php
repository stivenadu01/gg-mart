<?php
$act = $_GET['act'] ?? 'tambah';
$id  = $_GET['id'] ?? null;
$pageTitle = ($act === 'edit') ? "Edit Produk" : "Tambah Produk";

include INCLUDES_PATH . "admin/layout/header.php";
?>

<div x-data="produkFormPage('<?= $act ?>', '<?= $id ?>')" x-init="initPage()"
  class="p-6 lg:p-10 bg-gray-50 min-h-screen">
  <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
    <!-- HEADER -->
    <div class="flex items-center justify-between">
      <h1 class="text-2xl font-bold text-gray-800" x-text="formTitle"></h1>
      <a href="<?= url('admin/produk') ?>" class="text-sm text-gray-500 hover:text-gg-primary">← Kembali</a>
    </div>

    <!-- FORM -->
    <form @submit.prevent="submitForm" enctype="multipart/form-data" class="space-y-5">
      <!-- NAMA PRODUK -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
        <input type="text" x-model="form.nama_produk"
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-gg-primary focus:outline-none" placeholder="Nama produk" required>
      </div>

      <!-- KATEGORI -->
      <div x-data="{ open: false, keyword: '', filtered: [], selectedName: '' }"
        x-init="$watch('keyword', val => {
       filtered = kategori.filter(k => k.nama_kategori.toLowerCase().includes(val.toLowerCase()));
     })">
        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>

        <div class="relative">
          <!-- Input pencarian -->
          <input type="text"
            x-model="keyword"
            @focus="open = true"
            @blur="setTimeout(() => open = false, 200)"
            @input="open = true"
            @change="form.id_kategori = (kategori.find(k => k.nama_kategori === keyword)?.id_kategori || '')"
            placeholder="Ketik untuk mencari kategori..."
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-gg-primary focus:outline-none"
            autocomplete="off">

          <!-- Dropdown hasil -->
          <div x-show="open && filtered.length > 0"
            class="absolute z-20 mt-1 w-full bg-white border-gg-primary/50 border-2 rounded-lg shadow-lg max-h-48 overflow-y-auto">
            <template x-for="k in filtered" :key="k.id_kategori">
              <div @click="keyword = k.nama_kategori; form.id_kategori = k.id_kategori; open = false"
                class="px-3 py-2 hover:bg-gg-primary/50 cursor-pointer"
                x-text="k.nama_kategori"></div>
            </template>
          </div>
        </div>
      </div>


      <!-- HARGA -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
        <input type="number" x-model="form.harga"
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-gg-primary focus:outline-none" placeholder="Contoh: 25000" required>
      </div>

      <!-- STOK -->
      <div :class="isEdit ? 'hidden' : 'block'">
        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Awal</label>
        <input type="number" x-model="form.stok"
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-gg-primary focus:outline-none" placeholder="0">
      </div>

      <!-- DESKRIPSI -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
        <textarea x-model="form.deskripsi" rows="4"
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-gg-primary focus:outline-none"></textarea>
      </div>

      <!-- GAMBAR -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
        <input type="file" @change="onFileChange" accept="image/*"
          class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none">
        <template x-if="preview">
          <img :src="preview" alt="Preview Gambar" class="mt-3 w-40 h-40 object-cover rounded-lg shadow">
        </template>
      </div>

      <!-- TOMBOL -->
      <div class="flex justify-end gap-3">
        <a href="<?= url('admin/produk') ?>"
          class="px-5 py-2 border rounded-lg text-gray-600 hover:bg-gray-100 transition">Batal</a>
        <button type="submit"
          class="px-5 py-2 bg-gg-primary text-white rounded-lg hover:bg-gg-primary-hover transition"
          x-text="isEdit ? 'Simpan Perubahan' : 'Tambah Produk'"></button>
      </div>
    </form>
  </div>
</div>

<script>
  function produkFormPage(act, id) {
    return {
      form: {
        nama_produk: '',
        id_kategori: '',
        harga: '',
        stok: '',
        deskripsi: '',
        gambar: null
      },
      kategori: [],
      preview: null,
      isEdit: act === 'edit',
      formTitle: act === 'edit' ? 'Edit Produk' : 'Tambah Produk',

      async initPage() {
        await this.fetchKategori();
        if (this.isEdit && id) await this.fetchProduk(id);
      },

      async fetchKategori() {
        const res = await fetch(`<?= url('api/kategori') ?>?mode=all`);
        const data = await res.json();
        if (data.success) this.kategori = data.data;
      },

      async fetchProduk(kode) {
        let res = await fetch(`<?= url('api/produk') ?>?k=${kode}`);
        res = await res.json();
        if (res.success) {
          const data = res.data;
          this.form = {
            nama_produk: data.nama_produk,
            id_kategori: data.id_kategori,
            harga: data.harga,
            stok: data.stok,
            deskripsi: data.deskripsi,
            gambar: null
          };
          if (data.gambar) {
            this.preview = `<?= BASE_URL ?>/uploads/${data.gambar}`;
          }
        }
      },

      onFileChange(e) {
        const file = e.target.files[0];
        if (file) {
          this.form.gambar = file;
          this.preview = URL.createObjectURL(file);
        }
      },

      async submitForm() {
        // pastikan kategori valid
        const validKategori = this.kategori.some(k => k.id_kategori == this.form.id_kategori);
        if (!validKategori) {
          alert("Pilih kategori yang valid dari daftar!");
          return;
        }
        const formData = new FormData();
        formData.append("nama_produk", this.form.nama_produk);
        formData.append("harga", this.form.harga);
        formData.append("stok", this.form.stok || 0);
        formData.append("id_kategori", this.form.id_kategori || '');
        formData.append("deskripsi", this.form.deskripsi || '');

        if (this.form.gambar instanceof File) {
          formData.append("gambar", this.form.gambar);
        }

        if (this.isEdit) {
          formData.append("_method", "PUT");
        }

        const url = this.isEdit ?
          `<?= url('api/produk') ?>?k=${id}` :
          `<?= url('api/produk') ?>`;

        const res = await fetch(url, {
          method: "POST", // selalu POST
          body: formData
        });

        const data = await res.json();
        if (data.success) {
          alert(this.isEdit ? "Produk berhasil diupdate!" : "Produk berhasil ditambahkan!");
          window.location.href = "<?= url('admin/produk') ?>";
        } else {
          alert("Gagal menyimpan produk: " + data.message);
        }
      },

    };
  }
</script>

<?php include INCLUDES_PATH . "admin/layout/footer.php"; ?>