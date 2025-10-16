<script>
  const baseUrl = <?= json_encode(BASE_URL) ?>;
  const assetsUrl = <?= json_encode(ASSETS_URL) ?>;
  const uploadsUrl = <?= json_encode(UPLOADS_URL) ?>;

  const currentUser = <?= json_encode($_SESSION['user'] ?? null) ?>;

  function formatRupiah(angka) {
    angka = new Intl.NumberFormat('id-ID').format(angka);
    return 'Rp' + angka;
  }

  function formatDate(dateStr) {
    const options = {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric',
    };
    const date = new Date(dateStr);
    return date.toLocaleDateString('id-ID', options);
  }

  function formatDateTime(dateStr) {
    const options = {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit'
    };
    const date = new Date(dateStr);
    return date.toLocaleDateString('id-ID', options);
  }
</script>