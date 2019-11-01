<?php
    session_start();
    if(isset($_SESSION['nombre'])|| !empty($_SESSION['nombre'])){
        header("Location: profile");
    }else{
        session_destroy();
        header('Location: ../index?message=El+link+ya+no+esta disponible,+el+tiempo+de+validacion+expiro.+Porfavor+vuelve+a+registrarte.');
    }
?>