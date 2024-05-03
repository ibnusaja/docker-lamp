<?php
require 'connect.php';

$query = mysqli_query($connect, "SELECT MAX(kode) as kode FROM autocode");
$data = mysqli_fetch_array($query);
$kode_baru = $data['kode'];
$urutan = substr($kode_baru, 5, 3);

$urutan++;

$huruf = "KODE-";
$kode_baru = $huruf . sprintf("%03s", $urutan);
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Praktikum IV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <?php
    if (isset($_POST['nama_barang']) || isset($_POST['harga'])) {
        if ($_POST['nama_barang'] == "" || $_POST['harga'] == "") {
            $nama_barang = 'Nama Barang masih kosong';
            $harga = 'Harga masih kosong';
            $cek = true;
        } else {
            require 'connect.php';
            $kode = $_POST['kode'];
            $nama_barang = $_POST['nama_barang'];
            $harga = $_POST['harga'];
            mysqli_query($connect, "INSERT INTO autocode(kode,nama_barang,harga) VALUES('$kode','$nama_barang','$harga')");
            $cek = false;
        }
    } else {
        $cek = false;
    }
    ?>

    <div class="container">
        <div class="row justify-content-center mt-4 gy-4">
            <?php if ($cek == true) : ?>
                <div class="col-lg-12">
                    <div class="alert alert-danger" role="alert">
                        Data Gagal di tambahkan
                        <ul>
                            <li><?= $nama_barang ?></li>
                            <li><?= $harga ?></li>
                        </ul>
                    </div>
                </div>
            <?php elseif ($cek == false && $_SERVER["REQUEST_METHOD"] == "POST") : ?>
                <div class="col-lg-12">
                    <div class="alert alert-success" role="alert">
                        Data Berhasil Ditambahkan
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-lg-4">
                <div class="card text-center">
                    <div class="card-header">
                        Praktikum VI
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">INPUT DATA BARANG</h5>
                        <form method="post" action="">
                            <div class="row gy-3 p-4">
                                <div class="col-sm-12">
                                    <input readonly type="text" class="form-control" name="kode" value="<?= $kode_baru; ?>">
                                </div>
                                <div class="col-sm-12">
                                    <input autofocus required type="text" class="form-control" placeholder="Nama Barang" name="nama_barang">
                                </div>
                                <div class="col-sm-12">
                                    <input required type="text" class="form-control" placeholder="Harga" name="harga">
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="col-12 btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card text-center">
                    <div class="card-header">
                        Praktikum VI
                        <form action="index.php" method="GET" class="d-flex mt-3 row">
                            <div class="input group mb-3">
                                <input type="text" class="from control" placeholder="Cari" name="cari">
                                <button class="btn btn-secondary col-3" type="submit" value="cari">Cari</button>
                            </div>
                        </form>
                        <a href="cetak.php" type="submit" class="col-2 btn btn-primary">Cetak</a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">DATA BARANG</h5>
                        <?php
                        $batas = 5;
                        $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
                        $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;
                        $sebelumnya = $halaman - 1;
                        $selanjutnya = $halaman + 1;
                        $data = mysqli_query($connect, "SELECT * FROM autocode");
                        $jumlah_data = mysqli_num_rows($data);
                        $total_halaman = ceil($jumlah_data / $batas);
                        if (isset($_GET['cari'])) {
                            $cari = $_GET['cari'];
                            $data_barang = mysqli_query($connect, "SELECT * FROM autocode WHERE nama_barang LIKE '%" . $cari . "%'");
                        } else {
                            $data_barang = mysqli_query($connect, "SELECT * FROM autocode LIMIT $halaman_awal, $batas");
                        }
                        ?>
                        <div class="table-responsive p-4">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Barang</th>
                                        <th>Harga</th>
                                        <th>Ubah</th>
                                        <th>Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data_barang as $key => $item) : ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $item['kode'] ?></td>
                                            <td><?= $item['nama_barang'] ?></td>
                                            <td><?= $item['harga'] ?></td>
                                            <td><a href="#" class="col-12 btn btn-warning text-white">Ubah</a></td>
                                            <td><a href="#" class="col-12 btn btn-danger">Hapus</a></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center text-white" style="background-color: #219ebc;">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" <?php if ($halaman > 1) : ?> href="?halaman=<?=$sebelumnya; ?>" <?php endif; ?>>
                                        sebelumnya
                                    </a>
                                </li>
                                <?php for ($nomor_halaman = 1; $nomor_halaman <= $total_halaman; $nomor_halaman++) : ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?halaman=<?=$nomor_halaman?>"><?= $nomor_halaman; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item">
                                    <a class="page-link" <?php if ($halaman < $total_halaman) : ?> href="?halaman=<?=$selanjutnya; ?>" <?php endif; ?>>
                                        selanjutnya
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
