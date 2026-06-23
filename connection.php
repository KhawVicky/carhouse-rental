<?php
function pdo_connect_mysql()
{
    try{
    return new PDO('mysql:host=localhost; dbname=renthub','root','');
    }

catch (PDOExeption $exception)
{
    exit ('could not connect to database');
}
}
?>
