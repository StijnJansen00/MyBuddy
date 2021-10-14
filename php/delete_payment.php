<?php
include 'dbh.php';
session_start();

$payment_id = $_POST['payment_id'];
$group_id = $_POST['group_id'];

$query = $conn->prepare("DELETE FROM payment WHERE payment_id = :id");
$query->execute(array(
    ":id" => $payment_id
));

$_SESSION['succes'] = 'Uitgaven is succesvol verwijderd';
header("Location: ../?page=group_info&id=$group_id");