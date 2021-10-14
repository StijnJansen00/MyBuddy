<?php
include 'dbh.php';
session_start();

$id = htmlspecialchars($_POST['group_id']);

$query = $conn->prepare("UPDATE `group` SET groupname=:name WHERE group_id=:id");
$query->execute(array(
    ":id" => $id,
    ":name" => $_POST['groupname']
));

$_SESSION['succes'] = 'Groepnaam succesvol aangepast';
header("Location: ../?page=group_info&id=$id");