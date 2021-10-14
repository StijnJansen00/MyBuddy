<?php
include 'dbh.php';
session_start();

if (isset($_POST['submit'])) {

    if ($_POST['password'] == $_POST['repeat_password']) {

        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $name = htmlspecialchars($_POST['name']);
        $surname = htmlspecialchars($_POST['surname']);

        $query = $conn->prepare('SELECT * FROM `user` WHERE email=:email');
        $query->execute(array(
            ':email' => $email
        ));

        if ($query->rowCount() == 0) {
            $query1 = $conn->prepare("INSERT INTO `user` SET email=:email, password=:password, name=:name, surname=:surname");
            $query1->execute(array(
                ':email' => $email,
                ':name' => $name,
                ':surname' => $surname,
                ':password' => password_hash($password, PASSWORD_DEFAULT)
            ));

            $query2 = $conn->prepare('SELECT * FROM `register` WHERE email=:email');
            $query2->execute(array(
                ':email' => $email
            ));

            if ($query2->rowCount() > 0){
                $query3 = $conn->prepare('SELECT user_id FROM `user` WHERE email=:email');
                $query3->execute(array(
                    ':email' => $email
                ));

                $res = $query2->fetch();
                $result = $query3->fetch();

                $query4 = $conn->prepare("INSERT INTO user_group SET user_id=:user_id, group_id=:group_id");
                $query4->execute(array(
                    ":user_id" => $result['user_id'],
                    ":group_id" => $res['group_id']
                ));

                $query5 = $conn->prepare("DELETE FROM register WHERE email=:email AND group_id=:group_id");
                $query5->execute(array(
                    ":email" => $email,
                    ":group_id" => $res['group_id']
                ));
            }

            $_SESSION['error'] = "Registratie voltooid";
            header('Location: ../index.php?page=login');
        }
        else {
            $_SESSION['error'] = "E-mail is al in gebruik";
            header('Location: ../index.php?page=register');
        }
    }
    else {
        $_SESSION['error'] = "Wachtwoorden zijn niet gelijk";
        header('Location: ../index.php?page=register');
    }
}
