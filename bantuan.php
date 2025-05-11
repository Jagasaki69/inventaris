<?php
require "function.php";
require "cek.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Bantuan Bencana - BPBD</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">
                Gudang Log dan Alat
                <img src="assets/png/logobpbd.png" alt="Logo BPBD" style="height: 50px; margin-left: 560%;">
            </a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-download"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-upload"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="bantuan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-hands-helping"></i></div>
                                Bantuan Bencana
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Bantuan Bencana</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahBantuan">
                                    Tambah Bantuan Bencana
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Jenis Bencana</th>
                                                <th>Lokasi</th>
                                                <th>Penerima</th>
                                                <th>Barang</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $query = mysqli_query($conn, "SELECT * FROM bantuan_bencana ORDER BY tanggal DESC");
                                            $no = 1;
                                            while($data = mysqli_fetch_array($query)){
                                        ?>
                                            <tr>
                                                <td><?=$no++?></td>
                                                <td><?=$data['tanggal']?></td>
                                                <td><?=$data['jenis_bencana']?></td>
                                                <td><?=$data['lokasi_bencana']?></td>
                                                <td><?=$data['penerima']?></td>
                                                <td><?=$data['jenis_bantuan']?></td>
                                                <td><?=$data['status']?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$data['id_bantuan']?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$data['id_bantuan']?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; BPBD Kabupaten Kudus <?= date('Y') ?></div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!-- Modal Tambah -->
        <div class="modal fade" id="tambahBantuan">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Bantuan Bencana</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Jenis Bencana</label>
                                <input type="text" name="jenis_bencana" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Lokasi Bencana</label>
                                <input type="text" name="lokasi_bencana" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Penerima</label>
                                <input type="text" name="penerima" class="form-control" required>
                            </div>
                            <div id="barang-container">
                                <!-- Container untuk input barang dinamis -->
                            </div>
                            <button type="button" class="btn btn-success" onclick="tambahBarang()">
                                Tambah Barang
                            </button>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="addBantuan">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
        <script>
            // Script untuk menambah input barang secara dinamis
            let barangCount = 0;
            function tambahBarang() {
                barangCount++;
                const container = document.getElementById('barang-container');
                const div = document.createElement('div');
                div.innerHTML = `
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Barang ${barangCount}</label>
                                <select name="barang[]" class="form-control" required>
                                    <option value="">Pilih Barang</option>
                                    <?php
                                        $barang = mysqli_query($conn, "SELECT * FROM stock");
                                        while($b = mysqli_fetch_array($barang)) {
                                            echo "<option value='".$b['idbarang']."'>".$b['namabarang']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jumlah</label>
                                <input type="number" name="jumlah[]" class="form-control" required>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(div);
            }
        </script>
    </body>
</html>