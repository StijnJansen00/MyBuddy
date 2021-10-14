<?php
include "dbh.php";
session_start();

$email = htmlspecialchars($_POST['email']);
$name = htmlspecialchars($_POST['name']);
$surname = htmlspecialchars($_POST['surname']);
$user_id = $_POST['user_id'];

$query = $conn->prepare("UPDATE `user` SET email=:email, name=:name, surname=:surname WHERE user_id=:id");
$query->execute(array(
    ":email" => $email,
    ":name" => $name,
    ":surname" => $surname,
    ":id" => $user_id
));

$_SESSION['succes'] = 'Profiel succesvol gewijzigd';
header("Location: ../?page=profile");