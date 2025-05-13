<?php
require 'function.php';
require 'cek.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Barang Keluar - BPBD</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <span>Gudang Log dan Alat</span>
            <img src="assets/png/logobpbd.png" alt="Logo BPBD" style="height: 40px; margin-left: 1060px;">
        </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>
                            Stock Barang
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-download"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link active" href="keluar.php">
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
                    <h1 class="mt-4">Barang Keluar</h1>
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                                    <i class="fas fa-plus mr-1"></i>Tambah Barang Keluar
                                </button>
                                <button type="button" class="btn btn-success" onclick="exportKeluarExcel()">
                                    <i class="fas fa-file-excel mr-1"></i>Export Excel
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Penerima</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                            $query = mysqli_query($conn, "SELECT k.*, s.namabarang 
                                                FROM keluar k 
                                                JOIN stock s ON k.idbarang = s.idbarang 
                                                ORDER BY k.tanggal DESC");
                                            while($data = mysqli_fetch_array($query)){
                                            ?>
                                            <tr>
                                                <td><?=date('d-m-Y H:i:s', strtotime($data['tanggal']))?></td>
                                                <td><?=$data['namabarang']?></td>
                                                <td><?=$data['qty']?></td>
                                                <td><?=$data['penerima']?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?=$data['idkeluar']?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete<?=$data['idkeluar']?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                             <!-- Edit Modal -->
                                             <div class="modal fade" id="edit<?=$data['idkeluar']?>">
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
                                                                <input type="text" name="penerima" value="<?=$data['penerima']?>" class="form-control" required>
                                                                <br>
                                                                <input type="number" name="qty" value="<?=$data['qty']?>" class="form-control" required>
                                                                <br>
                                                                <input type="hidden" name="idb" value="<?=$data['idbarang']?>">
                                                                <input type="hidden" name="idk" value="<?=$data['idkeluar']?>">
                                                                <button type="submit" class="btn btn-primary" name="updatebarangkeluar">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    </div>
                                                    </div>
                                                        <!-- Delete Modal -->
                                                        <div class="modal fade" id="delete<?=$data['idkeluar']?>">
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
                                                                    Apakah Anda yakin ingin menghapus <?=$data['namabarang']?>?
                                                                    <input type="hidden" name="idb" value="<?=$data['idbarang']?>">
                                                                    <input type="hidden" name="kty" value="<?=$data['qty']?>">
                                                                    <input type="hidden" name="idk" value="<?=$data['idkeluar']?>">
                                                                    <br>
                                                                    <br>
                                                                    <button type="submit" class="btn btn-danger" name="hapusbarangkeluar">Hapus</button>
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</body>
    <!-- The Modal -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang Keluar</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <form action="" method="post">
                    <div class="modal-body">
                        <select name="barangnya" class="form-control">
                            <?php
                            $ambilsemuadatanya = mysqli_query($conn, "SELECT * FROM stock");
                            while ($fetcharray = mysqli_fetch_array($ambilsemuadatanya)){
                                $namabarangnya = $fetcharray['namabarang'];
                                $idbarangnya = $fetcharray['idbarang']; 
                            ?>
                                <option value="<?php echo $idbarangnya; ?>"><?php echo $namabarangnya; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <br>
                        <input type="number" name="qty" placeholder="Stock" class="form-control" required>
                        <br>
                        <input type="text" name="penerima" placeholder="Penerima" class="form-control" required>
                        <br>
                        <button type="submit" class="btn btn-primary" name="addbarangkeluar">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</html>