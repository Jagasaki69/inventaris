<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$conn = mysqli_connect("localhost", "root", "", "stockbarang");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Menambahkan barang baru
if (isset($_POST["addnewbarang"])) {
    $namabarang = $_POST["namabarang"];
    $deskripsi = $_POST["deskripsi"];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn, "INSERT INTO stock (namabarang, deskripsi, stock) VALUES ('$namabarang', '$deskripsi', '$stock')");
    if ($addtotable) {
        header('location:index.php');
        exit;
    } else {
        echo "Gagal: " . mysqli_error($conn);
        exit;
    }
}

// Menambahkan barang masuk
if (isset($_POST["barangmasuk"])) {
    $idbarang = $_POST["barangnya"];
    $penerima = $_POST["penerima"];
    $qty = $_POST["qty"];

    // Validasi input
    if (!is_numeric($qty) || $qty <= 0) {
        echo "Jumlah tidak valid.";
        exit;
    }

    $cekstocksekarang = mysqli_query($conn, "SELECT stock FROM stock WHERE idbarang = '$idbarang'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganqty = $stocksekarang + $qty;

    $addtotable = mysqli_query($conn, "INSERT INTO masuk (idbarang, keterangan, qty) VALUES ('$idbarang', '$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock = '$tambahkanstocksekarangdenganqty' WHERE idbarang = '$idbarang'");
    if ($addtotable && $updatestockmasuk) {
        header('location:masuk.php');
        exit;
    } else {
        echo "Gagal: " . mysqli_error($conn);
        exit;
    }
}

// Menghapus barang keluar
if (isset($_POST["addbarangkeluar"])) {
    $idbarang = $_POST["barangnya"];
    $penerima = $_POST["penerima"];
    $qty = $_POST["qty"];

    // Validasi input
    if (!is_numeric($qty) || $qty <= 0) {
        echo "Jumlah tidak valid.";
        exit;
    }

    $cekstocksekarang = mysqli_query($conn, "SELECT stock FROM stock WHERE idbarang = '$idbarang'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $kurangkanstocksekarangdenganqty = $stocksekarang - $qty;

    $addtokeluar = mysqli_query($conn, "INSERT INTO keluar (idbarang, penerima, qty) VALUES ('$idbarang', '$penerima','$qty')");
    $updatestockkeluar = mysqli_query($conn, "UPDATE stock SET stock = '$kurangkanstocksekarangdenganqty' WHERE idbarang = '$idbarang'");
    if ($addtokeluar && $updatestockkeluar) {
        header('location:keluar.php');
        exit;
    } else {
        echo "Gagal: " . mysqli_error($conn);
        exit;
    }
}

// Update info barang
if (isset($_POST["updatebarang"])) {
    $idbarang = $_POST["idbarang"];
    $namabarang = $_POST["namabarang"];
    $deskripsi = $_POST["deskripsi"];

    $update = mysqli_query($conn, "UPDATE stock SET namabarang='$namabarang', deskripsi='$deskripsi' WHERE idbarang='$idbarang'");
    if ($update) {
        header('location:index.php');
        exit;
    } else {
        echo "Gagal: " . mysqli_error($conn);
        exit;
    }
}

// Menghapus barang dari stock
if (isset($_POST["hapusbarang"])) {
    $idb = $_POST['idbarang'];

    $hapus = mysqli_query($conn, "DELETE FROM stock WHERE idbarang='$idb'");
    if ($hapus) {
        header('location:index.php');
        exit;
    } else {
        echo "Gagal: " . mysqli_error($conn);
        exit;
    }
}

// Mengubah data barang masuk
if (isset($_POST['updatebarangmasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];


    $lihatstock = mysqli_query($conn, "SELECT stock FROM stock WHERE idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskr = $stocknya["stock"];

    $qtyskrg = mysqli_query($conn, "SELECT qty FROM masuk WHERE idmasuk='$idm'");
    $qtyData = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtyData["qty"];

    if ($qty > $qtyskrg) {
        $selisih = $qty-$qtyskrg;
        $kurangin = $stockskr + $selisih;
        $kuranginstocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE masuk SET qty='$qty', keterangan='$deskripsi' WHERE idmasuk='$idm'");
            if ($kuranginstocknya&&$updatenya){
                header("location:masuk.php");
            } else{
                echo "Gagal: ";
                header("location:masuk.php");
            }
    } else {
        $selisih = $qtyskrg-$qty;
        $kurangin = $stockskr + $selisih;
        $kuranginstocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE masuk SET qty='$qty', keterangan='$deskripsi' WHERE idmasuk='$idm'");
            if ($kuranginstocknya&&$updatenya){
                header("location:masuk.php");
            } else{
                echo "Gagal: ";
                header("location:masuk.php");
            }

    }

}



// Menghapus barang masuk
if (isset($_POST['hapusbarangmasuk'])) {
    $idb = $_POST['idb']; // ID barang
    $qty = $_POST['kty']; // Jumlah barang
    $idm = $_POST['idm']; // ID transaksi barang masuk

    // Ambil data stok
    $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    // Hitung stok baru
    $selisih = $stock - $qty;

    // Update stok dan hapus data barang masuk
    $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk='$idm'");

    if ($update && $hapusdata) {
        header('location:masuk.php');
        exit;
    } else {
        echo "Gagal: " . mysqli_error($conn);
        exit;
    }
}

// mengubah data barang keluar
if (isset($_POST['updatebarangkeluar'])) {
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

     // Validasi input
     if (!is_numeric($qty) || $qty <= 0) {
        echo "Jumlah tidak valid.";
        exit;
    }

    $lihatstock = mysqli_query($conn, "SELECT stock FROM stock WHERE idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskr = $stocknya["stock"];

    // Ambil jumlah barang keluar sebelumnya
    $qtyskrg = mysqli_query($conn, "SELECT qty FROM keluar WHERE idkeluar='$idk'");
    $qtyData = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtyData["qty"];

    // Hitung stok baru berdasarkan selisih
    if ($qty > $qtyskrg) {
        $selisih = $qty - $qtyskrg;
        if ($stockskr < $selisih) {
            echo "Stok tidak mencukupi.";
            exit;
        }
        $stokbaru = $stockskr - $selisih;
    } else {
        $selisih = $qtyskrg - $qty;
        $stokbaru = $stockskr + $selisih;
    }

    // Update stok dan data barang keluar
    $updateStock = mysqli_query($conn, "UPDATE stock SET stock='$stokbaru' WHERE idbarang='$idb'");
    $updateKeluar = mysqli_query($conn, "UPDATE keluar SET qty='$qty', penerima='$penerima' WHERE idkeluar='$idk'");

    if ($updateStock && $updateKeluar) {
        header("location:keluar.php");
        exit;
    } else {
        echo "Gagal: " . mysqli_error($conn);
        exit;
    }

}



// Menghapus barang keluar
if (isset($_POST['hapusbarangkeluar'])) {
    $idb = $_POST['idb']; // ID barang
    $qty = $_POST['kty']; // Jumlah barang
    $idk = $_POST['idk']; // ID transaksi barang masuk

    // Ambil data stok
    $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    // Hitung stok baru
    $selisih = $stock + $qty;

    // Update stok dan hapus data barang keluar
    $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE FROM keluar WHERE idkeluar='$idk'");

    if ($update && $hapusdata) {
        header('location:keluar.php');
        exit;
    } else {
        echo "Gagal: " . mysqli_error($conn);
        exit;
    }
}
?>