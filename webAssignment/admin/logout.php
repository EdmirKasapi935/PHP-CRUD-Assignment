<?php

session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['tokenval']==$_SESSION['token'])
{
    session_destroy();
    header("LOCATION: index.php");
}


?>