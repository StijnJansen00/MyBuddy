<?php
echo "<pre>", print_r($_POST), "</pre>";
include "dbh.php";
session_start();

$user_id = $_POST['user_id'];
$amount = htmlspecialchars($_POST['amount']);
$date = htmlspecialchars($_POST['date']);
$description = htmlspecialchars($_POST['description']);
$group_id = $_POST['group_id'];


$query = $conn->prepare("
    SELECT user_group_id AS ugi
    FROM user_group
    WHERE user_id=:user_id
    AND group_id=:group_id");
$query->execute(array(
    ":user_id" => $user_id,
    ":group_id" => $group_id
));
$res = $query->fetch();

$query1 = $conn->prepare("
    INSERT INTO payment
    SET user_group_id=:id,
    amount=:amount,
    description=:description,
    date=:date");
$query1->execute(array(
    ":id" => $res['ugi'],
    ":amount" => $amount,
    ":description" => $description,
    ":date" => $date
));

$payment_id = $conn->lastInsertId();

foreach ($_POST['debts'] as $key => $value) {

    if ($value > 0) {

        $query2 = $conn->prepare("INSERT INTO dept SET payment_id=:payment_id, user_group_id=:user_group_id, amount=:amount");
        $query2->execute(array(
            ":payment_id" => $payment_id,
            ":user_group_id" => $key,
            ":amount" => $value
        ));

    }

}

header("Location: ../?page=group_info&id=$group_id");