<?php
require "function.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Stock Barang - BPBD</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
</head>
<body class="sb-nav-fixed">
    <!-- Navigation top Bar -->
      <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <span>Gudang Log dan Alat</span>
                <img src="assets/png/logobpbd.png" alt="Logo BPBD" style="height: 40px; margin-left: 1060px;">
            </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    </nav>
    <!-- Sidebar -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link active" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>
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
                        <div class="sb-sidenav-menu-heading">Account</div>
                        <a class="nav-link" href="logout.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Stock Barang</h1>
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    <i class="fas fa-plus"></i> Tambah Barang
                                </button>
                                <button type="button" class="btn btn-success" onclick="exportToExcel()">
                                    <i class="fas fa-file-excel"></i> Export Excel
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive"> 
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Deskripsi</th>
                                            <th>Stock</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM stock");
                                        $i = 1;
                                        while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                            $namabarang = $data['namabarang'];
                                            $deskripsi = $data['deskripsi'];
                                            $stock = $data['stock'];
                                            $idb = $data['idbarang'];
                                        ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$namabarang;?></td>
                                            <td><?=$deskripsi;?></td>
                                            <td><?=$stock;?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idb;?>">
                                                    Edit
                                                </button>
                                                <input type="hidden" name="idbarangygmaudihapus" value="<?=$idb;?>">
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idb;?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                                    <!-- Edit Modal -->
                                                    <div class="modal fade" id="edit<?=$idb;?>">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Barang</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <input type="text" name="namabarang" value="<?=$namabarang;?>" class="form-control" required>
                                                            <br>
                                                            <input type="text" name="deskripsi" value="<?=$deskripsi;?>" class="form-control" required>
                                                            <br>
                                                            <input type="hidden" name="idbarang" value="<?=$idb;?>">
                                                            <button type="submit" class="btn btn-primary" name="updatebarang">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                </div>
                                                </div>
                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete<?=$idb;?>">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Barang</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus <?=$namabarang;?>?
                                                                <input type="hidden" name="idbarang" value="<?=$idb;?>">
                                                                <br>
                                                                <br>
                                                                <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
                                                            </div>
                                                        </form>
                                                </div>
                                                </div>
                                                </div>
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
                        <div class="text-muted">&copy; BPBD Kabupaten Kudus <?= date('Y') ?></div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <form action="" method="post">
                    <div class="modal-body">
                        <input type="text" name="namabarang" placeholder="Nama Barang" class="form-control" required>
                        <br>
                        <input type="text" name="deskripsi" placeholder="Deskripsi Barang" class="form-control" required>
                        <br>
                        <input type="number" name="stock" placeholder="Stock" class="form-control" required>
                        <br>
                        <div class="form-group">
                            <label>Sumber</label>
                            <select name="sumber" class="form-control" required>
                                <option value="">Pilih Sumber</option>
                                <option value="Pembelian APBD">Pembelian APBD</option>
                                <option value="Donasi">Donasi</option>
                                <option value="Hibah">Hibah</option>
                                <option value="CSR">CSR</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        function exportToExcel() {
            window.location.href = 'export_excel.php';
        }
    </script>
</body>
</html>