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
        <title>Bantuan Bencana - BPBD</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
    </head>
    <body class="sb-nav-fixed">
        <!-- Top Navigation -->
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <span>Gudang Log dan Alat</span>
                <img src="assets/png/logobpbd.png" alt="Logo BPBD" style="height: 40px; margin-left: 1060px;">
            </a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>

        <div id="layoutSidenav">
            <!-- Side Navigation -->
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
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-upload"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link active" href="bantuan.php">
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

            <!-- Main Content -->
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Bantuan Bencana</h1>
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahBantuan">
                                        <i class="fas fa-plus mr-1"></i>Tambah Bantuan
                                    </button>
                                    <button type="button" class="btn btn-success" onclick="location.href='exportbantuan.php'">
                                        <i class="fas fa-file-excel mr-1"></i>Export
                                    </button>
                                </div>
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
                                            $query = mysqli_query($conn, "SELECT b.*, 
                                                GROUP_CONCAT(CONCAT(s.namabarang, ' (', d.jumlah, ')') SEPARATOR ', ') as detail_barang
                                                FROM bantuan_bencana b
                                                LEFT JOIN detail_bantuan d ON b.id_bantuan = d.id_bantuan
                                                LEFT JOIN stock s ON d.id_barang = s.idbarang
                                                GROUP BY b.id_bantuan
                                                ORDER BY b.tanggal DESC");
                                            $no = 1;
                                            while($data = mysqli_fetch_array($query)){
                                        ?>
                                            <tr>
                                                <td><?=$no++?></td>
                                                <td><?=date('d/m/Y H:i', strtotime($data['tanggal']))?></td>
                                                <td><?=$data['jenis_bencana']?></td>
                                                <td><?=$data['lokasi_bencana']?></td>
                                                <td><?=$data['penerima']?></td>
                                                <td><?=$data['detail_barang']?></td>
                                                <td><?=$data['status']?></td>
                                                <td>
                                                     <div class="d-flex flex-column">
                                                    <button type="button" class="btn btn-info btn-sm mb-1" data-toggle="modal" 
                                                            data-target="#updateStatus<?=$data['id_bantuan']?>">
                                                        Update Status
                                                    </button>
                                                    <button type="button" class="btn btn-warning btn-sm mb-1" data-toggle="modal" 
                                                            data-target="#edit<?=$data['id_bantuan']?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" 
                                                            data-target="#delete<?=$data['id_bantuan']?>">
                                                        Delete
                                                    </button>
                                                </div>
                                                </td>
                                            </tr>

                                            <!-- Modal Update Status -->
                                            <div class="modal fade" id="updateStatus<?=$data['id_bantuan']?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Update Status Bantuan</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_bantuan" value="<?=$data['id_bantuan']?>">
                                                                <div class="form-group">
                                                                    <label>Status</label>
                                                                    <select name="status" class="form-control" required>
                                                                        <option value="Diproses" <?=$data['status']=='Diproses'?'selected':''?>>Diproses</option>
                                                                        <option value="Dikirim" <?=$data['status']=='Dikirim'?'selected':''?>>Dikirim</option>
                                                                        <option value="Diterima" <?=$data['status']=='Diterima'?'selected':''?>>Diterima</option>
                                                                        <option value="Selesai" <?=$data['status']=='Selesai'?'selected':''?>>Selesai</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary" name="updateStatus">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Edit Bantuan -->
                                            <div class="modal fade" id="edit<?=$data['id_bantuan']?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Bantuan Bencana</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_bantuan" value="<?=$data['id_bantuan']?>">
                                                                <div class="form-group">
                                                                    <label>Jenis Bencana</label>
                                                                    <input type="text" name="jenis_bencana" class="form-control" 
                                                                           value="<?=$data['jenis_bencana']?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Lokasi Bencana</label>
                                                                    <textarea name="lokasi_bencana" class="form-control" required><?=$data['lokasi_bencana']?></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Penerima</label>
                                                                    <input type="text" name="penerima" class="form-control" 
                                                                           value="<?=$data['penerima']?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Kontak Penerima</label>
                                                                    <input type="text" name="kontak_penerima" class="form-control" 
                                                                           pattern="[0-9+\-\s]+" value="<?=$data['kontak_penerima']?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-warning" name="editBantuan">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Delete Bantuan -->
                                            <div class="modal fade" id="delete<?=$data['id_bantuan']?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Bantuan Bencana</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_bantuan" value="<?=$data['id_bantuan']?>">
                                                                <p>Apakah Anda yakin ingin menghapus data bantuan ini?</p>
                                                                <p>Jenis Bencana: <b><?=$data['jenis_bencana']?></b></p>
                                                                <p>Lokasi: <b><?=$data['lokasi_bencana']?></b></p>
                                                                <p>Penerima: <b><?=$data['penerima']?></b></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger" name="deleteBantuan">Delete</button>
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
                            <div class="text-muted">Copyright &copy; BPBD Kabupaten Kudus <?= date('Y') ?></div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!-- Modal Tambah Bantuan -->
        <div class="modal fade" id="modalTambahBantuan">
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
                                <textarea name="lokasi_bencana" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Penerima</label>
                                <input type="text" name="penerima" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Kontak Penerima</label>
                                <input type="text" name="kontak_penerima" class="form-control" pattern="[0-9+\-\s]+" required>
                            </div>
                            <div id="barang-container">
                                <!-- Container untuk barang bantuan -->
                            </div>
                            <button type="button" class="btn btn-success btn-sm" onclick="tambahBarang()">
                                + Tambah Barang
                            </button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="addBantuan">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

        <!-- Custom JavaScript -->
        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable();
            });

            function tambahBarang() {
                const container = document.getElementById('barang-container');
                const div = document.createElement('div');
                div.className = 'form-row mb-2';
                div.innerHTML = `
                    <div class="col-md-5">
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
                    <div class="col-md-5">
                        <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-block" onclick="this.parentElement.parentElement.remove()">X</button>
                    </div>
                `;
                container.appendChild(div);
            }

            function exportBantuanExcel() {
                window.location.href = 'export_bantuan.php';
            }
        </script>
    </body>
</html>