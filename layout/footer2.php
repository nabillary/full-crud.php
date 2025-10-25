<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- Asset plugin datatables -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>

<!-- Font Awesome -->
<script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"
    integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc"
    crossorigin="anonymous"></script>

<!-- LOad ckeditor cdn -->
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
  CKEDITOR.replace('alamat', {
  filebrowserBrowseUrl: 'assets/ckfinder/ckfinder.html',
  filebrowserUploadUrl: 'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
  height: '400px'
  });
</script>
<!-- HAPUS BAGIAN INI DARI FOOTER - PINDAH KE HALAMAN YANG BUTUH CKEDITOR -->
<!-- CKEditor sudah dipanggil di halaman masing-masing (tambah-mahasiswa.php, ubah-mahasiswa.php, dll) -->

<!-- Datatable client side -->
<script>
  $(document).ready(function() {
      $('#example').DataTable({
          "language": {
              "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
          }
      });
  });
</script>

<!-- Datatable serverside -->
<script>
$(document).ready(function() {
    $('#serverside').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": "mahasiswa-serverside.php?action=table_data",
            "dataType": "json",
            "type": "POST"
        },
        columns: [
            { "data": "no" },
            { "data": "nama" },
            { "data": "prodi" },
            { "data": "jk" },
            { "data": "telepon" },
            { "data": "aksi" }
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
        }
    });
});
</script>

</body>
</html>