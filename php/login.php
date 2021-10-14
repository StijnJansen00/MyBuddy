<?php
require "dbh.php";
session_start();

if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
}

$query = $conn->prepare('SELECT * FROM `user` WHERE email=:email');
$query->execute(array(
    ':email' => $email
));
$result = $query->fetch(PDO::FETCH_ASSOC);

if ($query->rowCount() > 0 && password_verify($password, $result['password'])) {

    $_SESSION['login'] = true;
    $_SESSION['user_id'] = $result['user_id'];
    $_SESSION['name'] = $result['name'];
    $_SESSION['surname'] = $result['surname'];

    header("Location: ../?page=home");
}
else {
    $_SESSION['error'] = "Username and/or password incorrect";
    header("Location: ../?page=login");
}

