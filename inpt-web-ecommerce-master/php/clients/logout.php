<?php
session_start();
session_unset();
session_destroy();

if (isset($_GET["page"])) {
    header("location: ../../" . $_GET["page"]);
} else {
    if (file_exists("../index.php"))
        header("location:  ../../index.php");
}
