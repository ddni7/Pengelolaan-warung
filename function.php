<?php 

session_start();

//koneksii
$c = mysqli_connect('localhost','root','','warungaman');

//loginn
if (isset($_POST['login'])){
    //initiate variable
    $username = $_POST['username'];
    $password = $_POST['password'];

    $cek = mysqli_query($c,"SELECT * FROM user WHERE username='$username' and password='$password' ");
    $hitung = mysqli_num_rows($cek);

    if($hitung>0){
        //jika data ditemukan.bisa login

        $_SESSION['login']='True';
        header('location:home.php');
    } else{
        //jika tidak.tidak bisa loguin

        echo '
        <script> alert("username&Password salah"); 
        window.location.href="login.php"
        </script>
        ';
        
    }
}

//kuerii tambah barang baru
if(isset($_POST['tambahbarang'])){
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    //soall gambarr
    $allowed_extension = array('png','jpg');
    $nama = $_FILES['file']['name'];//ambil nama file gambar
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot));//ngambil ekstensinya
    $ukuran = $_FILES['file']['size'];//ngambil size filenya
    $file_tmp = $_FILES['file']['tmp_name'];//ngambil lokasi filenya

    //penamaan file --> dienkripsi
    $image = md5(uniqid($nama,true) . time()). '.'. $ekstensi;//menggabungkan nama file yg di enkripsi dngn ekstensinya

    //proses upload gambar 
    if(in_array($ekstensi, $allowed_extension) === true){
        //validasi ukuran filenya
        if($ukuran < 15000000){
            move_uploaded_file($file_tmp, 'images/' .$image);

            $insert = mysqli_query($c, "insert into produk (namaproduk,deskripsi,stok,harga,image)values('$namaproduk','$deskripsi','$stok','$harga','$image')") or die(mysqli_error($c));

            if ($insert) {
                header('location:stok.php');
            } else {

                echo '
                <script> alert("Gagal menambah barang baru"); 
                window.location.href="stok.php"
                </script>
                ';
            }
        }else{
            //kalau filenya lebih dari 15mb
            echo '
                <script> alert("Ukuran terlalu besar"); 
                window.location.href="stok.php"
                </script>
                ';
        }

    }else{
        //kalau file tidak png / jpg
        echo '
                <script> alert("File harus png/jpg"); 
                window.location.href="stok.php"
                </script>
                ';
    }
    
}


//kuerii tambah pelanggan
if (isset($_POST['tambahpelanggan'])) {
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];

    $insert = mysqli_query($c,
        "insert into pelanggan (namapelanggan,notelp,alamat)values('$namapelanggan','$notelp','$alamat')"
    ) or die(mysqli_error($c));

    if ($insert) {
        header('location:pelanggan.php');
    } else {

        echo '
        <script> alert("Gagal menambah pelanggan baru"); 
        window.location.href="pelanggan.php"
        </script>
        ';
    }
}

//kuerii tambah pesanan
if (isset($_POST['tambahpesanan'])) {
    $idpelanggan = $_POST['idpelanggan'];

    $insert = mysqli_query(
        $c,
        "insert into pesanan (idpelanggan)values('$idpelanggan')"
    ) or die(mysqli_error($c));

    if ($insert) {
        header('location:index.php');
    } else {

        echo '
        <script> alert("Gagal menambah pesanan baru"); 
        window.location.href="index.php"
        </script>
        ';
    }
}

//kuerii add produkk
//produkk di pilihh di pesanann
if (isset($_POST['addproduk'])) {
    $idproduk = $_POST['idproduk'];
    $idp = $_POST['idp'];//id pesanann nya kade omatt
    $qty = $_POST['qty'];//jumlah yg mau di keluarin

    //hitung stok sekarang ada berapa
    $hitung1 = mysqli_query($c,"select * from produk where idproduk='$idproduk'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stoksekarang=$hitung2['stok'];//stokk barang saat ini 

    if($stoksekarang>=$qty){

        //kurangi stokk ny dengan  jumlah yg akan di keluarkan
        $selisih = $stoksekarang-$qty;


        //stokk nya cukupp
        $insert = mysqli_query($c, "insert into detailpesanan (idpesanan,idproduk,qty)values('$idp','$idproduk','$qty')");
        $update = mysqli_query($c,"update produk set stok='$selisih' where idproduk='$idproduk'");

        if ($insert&&$update) {
            header('location:view.php?idp=' . $idp);
        } else {

            echo '
        <script> alert("Gagal menambah pesanan baru"); 
        window.location.href="view.php?idp=.' . $idp . '"
        </script>
        ';
        }
    }else {
        //stokk ga cukupp
        echo '
        <script> alert("Stok barang tidak cukup"); 
        window.location.href="view.php?idp='.$idp. '"
        </script>
        ';
    }
}


//menambah barangg masukk
if(isset($_POST['barangmasuk'])){
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];

    //cari tahuuu stok skrng brp
    $caristok = mysqli_query($c, "select * from produk where idproduk='$idproduk'");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2['stok'];

    //hitung
    $newstok = $stoksekarang+$qty;

    $insertb = mysqli_query($c, "insert into masuk (idproduk,qty) values('$idproduk','$qty')");
    $updatetb = mysqli_query($c,"update produk set stok='$newstok' where idproduk='$idproduk'");

    if($insertb&&$updatetb){
        header('location:masuk.php');
    }else{
        echo '
        <script> alert("Gagal"); 
        window.location.href="masuk.php"
        </script>
        ';
    }

}

//hapuss produk pesanan
if(isset($_POST['hapusprodukpesanan'])){
    $idp = $_POST['idp'];//idditeailpesanan
    $idpr = $_POST['idpr'];
    $idorder = $_POST['idorder'];

    //cek qty sekarang
    $cek1 = mysqli_query($c,"select * from detailpesanan where iddetailpesanan='$idp'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['qty'];

    //cek stok sekarang
    $cek3 = mysqli_query($c,"select * from produk where idproduk='$idpr'");
    $cek4 = mysqli_fetch_array($cek3);
    $stoksekarang = $cek4['stok'];

    $hitung = $stoksekarang+$qtysekarang;

    $update = mysqli_query($c,"update produk set stok='$hitung' where idproduk='$idpr'");//kanggo update stok
    $hapus = mysqli_query($c,"delete from detailpesanan where idproduk='$idpr' and iddetailpesanan='$idp'");

    if($update&&$hapus){
        header('location:view.php?idp=' . $idorder);
    }else{
        echo '
        <script> alert("Gagal menghapus barang"); 
        window.location.href="view.php?idp=' . $idorder . '"
        </script>
        ';
    }
}


//editt barang
if(isset($_POST['editbarang'])){
    $np = $_POST['namaproduk'];
    $desc = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $idp = $_POST['idp']; //idproduk


    //soall gambarr
    $allowed_extension = array('png', 'jpg');
    $nama = $_FILES['file']['name']; //ambil nama file gambar
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot)); //ngambil ekstensinya
    $ukuran = $_FILES['file']['size']; //ngambil size filenya
    $file_tmp = $_FILES['file']['tmp_name']; //ngambil lokasi filenya

    //penamaan file --> dienkripsi
    $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi;//menggabungkan nama file yg di enkripsi dngn ekstensinya

    if($ukuran==0){
        //jika tidak ingin upload gambar
        $query = mysqli_query($c, "update produk set namaproduk='$np', deskripsi='$desc', harga='$harga' where idproduk='$idp' ");

        if ($query) {
            header('location:stok.php');
        } else {
            echo '
        <script> alert("Gagal"); 
        window.location.href="stok.php"
        </script>
        ';
        }
    } else{
        //jika ingin
        move_uploaded_file($file_tmp, 'images/' . $image);
        $query = mysqli_query($c, "update produk set namaproduk='$np', deskripsi='$desc', harga='$harga', image='$image' where idproduk='$idp' ");

        if ($query) {
            header('location:stok.php');
        } else {
            echo '
        <script> alert("Gagal"); 
        window.location.href="stok.php"
        </script>
        ';
        }
    }


}


//hapuss barangg dan gmbr
if(isset($_POST['hapusbarang'])){
    $idp = $_POST['idp'];

    //cari dlu gambarnya
    $gambar = mysqli_query($c,"select * from produk where idproduk='$idp'");
    $get = mysqli_fetch_array($gambar);
    $img = 'images/' .$get['image'];
    unlink($img);

    $query = mysqli_query($c,"delete from produk where idproduk='$idp'");
    if ($query) {
        header('location:stok.php');
    } else {
        echo '
        <script> alert("Gagal"); 
        window.location.href="stok.php"
        </script>
        ';
    }
}

//editt pelanggan
if (isset($_POST['editpelanggan'])) {
    $np = $_POST['namapelanggan'];
    $nt = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    $id = $_POST['idpl']; //idpelanggan

    $query = mysqli_query($c, "update pelanggan set namapelanggan='$np', notelp='$nt', alamat='$alamat' where idpelanggan='$id' ");

    if ($query) {
        header('location:pelanggan.php');
    } else {
        echo '
        <script> alert("Gagal"); 
        window.location.href="pelanggan.php"
        </script>
        ';
    }
}

//hapuss pelanggan
if (isset($_POST['hapuspelanggan'])) {
    $idpl = $_POST['idpl'];

    $query = mysqli_query($c, "delete from pelanggan where idpelanggan='$idpl'");
    if ($query) {
        header('location:pelanggan.php');
    } else {
        echo '
        <script> alert("Gagal"); 
        window.location.href="pelanggan.php"
        </script>
        ';
    }
}


//editt data barang masuk
if (isset($_POST['editdatabarangmasuk'])) {
    $qty = $_POST['qty'];
    $idm = $_POST['idm']; //idmasuk
    $idp = $_POST['idp'];//idproduk


    //mencari qty skrng brp
    $caritahu = mysqli_query($c,"select * from masuk where idmasuk='$idm'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    //cari tahuuu stok skrng brp
    $caristok = mysqli_query($c,"select * from produk where idproduk='$idp'");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2['stok'];


    if($qty >= $qtysekarang){
        //kalau inputan user lebih besar dari pda yg skrng tercatat
        //harus menghitung selisih
        $selisih = $qty-$qtysekarang;
        $newstok = $stoksekarang+$selisih;

        $query1 = mysqli_query($c, "update masuk set qty='$qty' where idmasuk='$idm' ");
        $query2 = mysqli_query($c, "update produk set stok='$newstok' where idproduk='$idp' ");

        if ($query1&&$query2) {
            header('location:masuk.php');
        } else {
            echo '
        <script> alert("Gagal"); 
        window.location.href="masuk.php"
        </script>
        ';
        }


    }else{
        //kalau lebih kecill
        //hitung selisih
        $selisih = $qtysekarang-$qty;
        $newstok = $stoksekarang-$selisih;

        $query1 = mysqli_query($c, "update masuk set qty='$qty' where idmasuk='$idm' ");
        $query2 = mysqli_query($c, "update produk set stok='$newstok' where idproduk='$idp' ");

        if ($query1 && $query2) {
            header('location:masuk.php');
        } else {
            echo '
        <script> alert("Gagal"); 
        window.location.href="masuk.php"
        </script>
        ';
        }
    }


    // $query1 = mysqli_query($c, "update masuk set qty='$qty' where idmasuk='$idm' ");

    // if ($query) {
    //     header('location:pelanggan.php');
    // } else {
    //     echo '
    //     <script> alert("Gagal"); 
    //     window.location.href="pelanggan.php"
    //     </script>
    //     ';
    // }
}




//hapus data barang masukk
if (isset($_POST['hapusdatabarangmasuk'])) {
    $idm = $_POST['idm'];
    $idp = $_POST['idp'];


    //mencari qty skrng brp
    $caritahu = mysqli_query($c, "select * from masuk where idmasuk='$idm'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];//whattt the hell mennn

    //cari tahuuu stok skrng brp
    $caristok = mysqli_query($c, "select * from produk where idproduk='$idp'");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2['stok'];

    //hitung selisih
    $newstok = $stoksekarang-$qtysekarang;

    $query1 = mysqli_query($c, "delete from masuk where idmasuk='$idm' ");
    $query2 = mysqli_query($c, "update produk set stok='$newstok' where idproduk='$idp' ");

    if ($query1&&$query2) {
        header('location:masuk.php');
    } else {
        echo '
        <script> alert("Gagal"); 
        window.location.href="masuk.php"
        </script>
        ';
    }

}


//hapus order
if (isset($_POST['hapusorder'])) {
    $ido = $_POST['ido'];//idorder

    $cekdata = mysqli_query($c,"select * from detailpesanan dp where idpesanan='$ido'");

    while ($ok=mysqli_fetch_array($cekdata)) {
        //membalikan stokk
        $qty = $ok['qty'];
        $idproduk = $ok['idproduk'];
        $iddp =$ok['iddetailpesanan'];

        //cari tahuuu stok skrng brp
        $caristok = mysqli_query($c, "select * from produk where idproduk='$idproduk'");
        $caristok2 = mysqli_fetch_array($caristok);
        $stoksekarang = $caristok2['stok'];

        $newstok = $stoksekarang+$qty;
        
        $queryupdate = mysqli_query($c, "update produk set stok='$newstok' where idproduk='$idproduk' ");

        //hapus data
        $kueridelete = mysqli_query($c, "delete from detailpesanan where iddetailpesanan='$iddp' ");


    }

    $query = mysqli_query($c, "delete from pesanan where idorder='$ido'");
    if ($queryupdate&&$kueridelete&&$query) {
        header('location:index.php');
    } else {
        echo '
        <script> alert("Gagal"); 
        window.location.href="index.php"
        </script>
        ';
    }
}


//mengubah data detail pesanan
if (isset($_POST['editdetailpesanan'])) {
    $qty = $_POST['qty'];
    $iddp = $_POST['iddp']; //idmasuk
    $idpr = $_POST['idpr']; //idproduk
    $idp = $_POST['idp']; //idpesanan


    //mencari qty skrng brp
    $caritahu = mysqli_query($c, "select * from detailpesanan where iddetailpesanan='$iddp'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    //cari tahuuu stok skrng brp
    $caristok = mysqli_query($c, "select * from produk where idproduk='$idpr'");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2['stok'];


    if ($qty >= $qtysekarang) {
        //kalau inputan user lebih besar dari pda yg skrng tercatat
        //harus menghitung selisih
        $selisih = $qty - $qtysekarang;
        $newstok = $stoksekarang - $selisih;

        $query1 = mysqli_query($c, "update detailpesanan set qty='$qty' where iddetailpesanan='$iddp' ");
        $query2 = mysqli_query($c, "update produk set stok='$newstok' where idproduk='$idpr' ");

        if ($query1 && $query2) {
            header('location:view.php?idp='.$idp);
        } else {
            echo '
        <script> alert("Gagal"); 
        window.location.href=view.php?idp=' . $idp . '"
        </script>
        ';
        }
    } else {
        //kalau lebih kecill
        //hitung selisih
        $selisih = $qtysekarang - $qty;
        $newstok = $stoksekarang + $selisih;

        $query1 = mysqli_query($c, "update detailpesanan set qty='$qty' where iddetailpesanan='$iddp' ");
        $query2 = mysqli_query($c, "update produk set stok='$newstok' where idproduk='$idpr' ");

        if ($query1 && $query2) {
            header('location:view.php?idp=' . $idp);
        } else {
            echo '
        <script> alert("Gagal"); 
        window.location.href="view.php?idp='.$idp.'"
        </script>
        ';
        }
    }


    // $query1 = mysqli_query($c, "update masuk set qty='$qty' where idmasuk='$idm' ");

    // if ($query) {
    //     header('location:pelanggan.php');
    // } else {
    //     echo ' ///KODINGAN GAGALLLL!!
    //     <script> alert("Gagal"); 
    //     window.location.href="pelanggan.php"
    //     </script>
    //     ';
    // }
}



?>