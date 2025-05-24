<?php
require "function.php";

// Periksa koneksi database
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Hapus atau sesuaikan logika di cek.php jika diperlukan
// require "cek.php"; // Pastikan file ini tidak memblokir akses tanpa alasan
?>
<!DOCTYPE html>
<html>
<head>
    <title>Export Data Bantuan Bencana</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="container">
        <h2>Data Bantuan Bencana</h2>
        <a href="bantuan.php" class="btn btn-danger" style="margin-bottom: 20px;">Kembali</a>
        <div class="data-tables datatable-dark">
            <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis Bencana</th>
                        <th>Lokasi</th>
                        <th>Penerima</th>
                        <th>Barang</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conn, "SELECT b.*, 
                        GROUP_CONCAT(CONCAT(s.namabarang, ' (', d.jumlah, ')') SEPARATOR ', ') as detail_barang
                        FROM bantuan_bencana b
                        LEFT JOIN detail_bantuan d ON b.id_bantuan = d.id_bantuan
                        LEFT JOIN stock s ON d.id_barang = s.idbarang
                        GROUP BY b.id_bantuan
                        ORDER BY b.tanggal DESC");
                    $i = 1;
                    while($data = mysqli_fetch_array($query)){
                    ?>
                        <tr>
                            <td><?=$i++?></td>
                            <td><?=date('d/m/Y H:i', strtotime($data['tanggal']))?></td>
                            <td><?=$data['jenis_bencana']?></td>
                            <td><?=$data['lokasi_bencana']?></td>
                            <td><?=$data['penerima']?></td>
                            <td><?=$data['detail_barang']?></td>
                            <td><?=$data['status']?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#mauexport').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });
    });
    </script>

</body>
</html>