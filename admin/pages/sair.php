<?php
    if (!isset($page)) exit;

    unset($_SESSION["usuario"]);
    session_destroy();

    echo "<script>location.href='index.php';</script>";
    exit;
?>