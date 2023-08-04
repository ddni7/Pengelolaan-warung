<?php

require 'function.php';

if(isset($_SESSION['login'])){
    //yaudahh
}else{
    //belum login
    header('location:login.php');
}

?>