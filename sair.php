<?php
session_start();
ob_start();
unset($_SESSION['email'], $_SESSION['senha']);
$_SESSION['msg'] = "<div class='alert alert-danger text-center alert-dismissible fade show' style='width: 200px;' role='alert'>
       Deslogado com sucesso.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
header("Location: index.php");



?>