<?php
include 'dbh.php';
session_start();

if (isset($_POST['submit'])) {
    $groupname = htmlspecialchars($_POST['groupname']);


    $query1 = $conn->prepare("INSERT INTO `group` SET groupname=:groupname");
    $query1->execute(array(
        ":groupname" => $groupname
    ));

    $query2 = $conn->prepare("SELECT group_id FROM `group` WHERE groupname=:groupname");
    $query2->execute(array(
        ":groupname" => $groupname
    ));
    $result = $query2->fetch();
    $_SESSION['group_id'] = $result['group_id'];

    $query3 = $conn->prepare("INSERT INTO user_group SET user_id=:user_id, group_id=:group_id");
    $query3->execute(array(
        ":group_id" => $result['group_id'],
        ":user_id" => $_SESSION['user_id']
    ));

    header("Location: ../?page=select_particapants");

}