<?php
    $username = $_SESSION['username'];
    $password = $_POST['password'];
    $retype = $_POST['retype'];
    
    if ($password == $retype) {
        echo "SAMA";
    } else {
        echo "BEda";
    }
?>