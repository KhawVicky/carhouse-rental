<?php
    session_start();

    session_destroy();//delete the session

    //redirect to index.html
    header('Location:home.php');
?>