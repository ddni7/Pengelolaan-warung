<?php
require '../ceklogin.php';


//hitung jumlah produk
$h1 = mysqli_query($c, "select * from produk");
$h2 = mysqli_num_rows($h1); //jumlah produk 
?>
<html>

<head>
    <title>Stock Barang</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    <style>
        .abc {
            width: 100px;
        }

        .abc:hover {
            transform: scale(1.5);
            transition: 0.3s ease;
        }
    </style>

</head>

<body>
    <div class="container">
        <h2>Stock Barang</h2>
        <h4>(Inventory)</h4>
        <div class="data-tables datatable-dark">

            <table class="table table-hover" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $ambil = mysqli_query($c, "select *from produk");
                    $i = 1;



                    while ($p = mysqli_fetch_array($ambil)) {
                        $namaproduk = $p['namaproduk'];
                        $deskripsi = $p['deskripsi'];
                        $harga = $p['harga'];
                        $stok = $p['stok'];
                        $idproduk = $p['idproduk'];

                        //cek ada gambar atau tidak
                        $gambar = $p['image']; //ambil gambar
                        if ($gambar == null) {
                            //jika tidak ada gambar
                            $img = 'No Photo!';
                        } else {

                            //jika ada gambar
                            $img = '<img src="../images/' . $gambar . '" class="abc">';
                        }


                    ?>

                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $img; ?></td>
                            <td><?= $namaproduk; ?></td>
                            <td><?= $deskripsi ?></td>
                            <td>Rp<?= number_format($harga); ?></td>
                            <td><?= $stok; ?></td>

                        </tr>


                    <?php
                    }; //ereun while
                    ?>


                </tbody>
            </table>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#datatablesSimple').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'print'
                ]
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>



</body>

</html>