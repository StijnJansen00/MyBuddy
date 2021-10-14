<?php
include 'dbh.php';
session_start();//needed for the making of session error messages

//instead of autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//instead of autoloader
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';


if (isset($_POST['submit'])) {//this is to check if someone pressed the button from which the mail send request was send

    $group_id = $_POST['group_id'];

    $query = $conn->prepare("SELECT groupname FROM `group` WHERE group_id=:group_id");
    $query->execute(array(
        ":group_id" => $group_id
    ));
    $res = $query->fetch();

    $groupname = $res['groupname'];
    $email = htmlspecialchars($_POST['email']);
    $name = $_SESSION['name'];
    $surname = $_SESSION['surname'];

    $query0 = $conn->prepare("SELECT * FROM `user` WHERE email=:email");
    $query0->execute(array(
        ":email" => $email
    ));

    if ($query0->rowCount() > 0) {
        $result = $query0->fetch();
        $user_id = $result['user_id'];

        $query1 = $conn->prepare("SELECT * FROM user_group WHERE user_id=:user_id AND group_id=:group_id");
        $query1->execute(array(
            ":user_id" => $user_id,
            ":group_id" => $group_id
        ));

        if ($query1->rowCount() == 0) {

            $query2 = $conn->prepare("INSERT INTO user_group SET user_id=:user_id, group_id=:group_id");
            $query2->execute(array(
                ":group_id" => $group_id,
                ":user_id" => $user_id
            ));

            try { //is needed for the $mail->send() function
                ini_set("SMTP", "ssl://smtp.gmail.com");//setsSMTP
                ini_set("smtp_port", "465");//sets port
                $mail = new PHPMailer();//makes $mail the phpmailer function
                $mail->SMTPAuth = true;
                $mail->Host = "smtp.gmail.com";//SMTP host, Gmail in my case
                $mail->SMTPSecure = "ssl";//type of security
                $mail->Username = "admtakeitserious@gmail.com";//sender
                $mail->Password = "KH1200284867";//password sender
                $mail->Port = "465";//port
                $mail->isSMTP();
                $rec1 = $email;//receiver
                $mail->AddAddress($rec1);//dont touch this!!
                $mail->Subject = "Uitnodiging MyBuddy 2.0";
                $mail->Body = "Dag meneer/mevrouw, \n\n U bent door $name[0]. $surname toegevoegd aan $groupname. \n\n U kunt inloggen via de volgende link: \n http://localhost/MyBuddy/index.php?page=home";
                $mail->WordWrap = 200;//length of one line

                if ($mail->Send()) {//message if its send, not needed but usefull
                    $_SESSION['mailsend'] = 'Gebruiker is toegevoegd aan de groep.';
                    header("Location: ../?page=group_info&id=$group_id");
                }
                else {//message if it didn't send
                    $_SESSION['notsend'] = 'Er is een fout opgetreden bij het toevoegen van deze gebruiker, probeer het opnieuw';
                    header("Location: ../?page=group_info&id=$group_id");
                }
            }
            catch (Exception $e) {//send an exception if something in the phpmailer code throws an error
                $_SESSION['error'] = 'Er is een fout opgetreden, ' && $mail->ErrorInfo;
                header("Location: ../?page=group_info&id=$group_id");
            }
        }
        else {
            $_SESSION['error'] = "Dit email adres is al toegevoegd";
            header("Location: ../?page=group_info&id=$group_id");
        }
    }
    else {

        try { //is needed for the $mail->send() function
            ini_set("SMTP", "ssl://smtp.gmail.com");//setsSMTP
            ini_set("smtp_port", "465");//sets port
            $mail = new PHPMailer();//makes $mail the phpmailer function
            $mail->SMTPAuth = true;
            $mail->Host = "smtp.gmail.com";//SMTP host, Gmail in my case
            $mail->SMTPSecure = "ssl";//type of security
            $mail->Username = "admtakeitserious@gmail.com";//sender
            $mail->Password = "KH1200284867";//password sender
            $mail->Port = "465";//port
            $mail->isSMTP();
            $rec1 = $email;//receiver
            $mail->AddAddress($rec1);//dont touch this!!
            $mail->Subject = "Uitnodiging MyBuddy 2.0";
            $mail->Body = "Dag meneer/mevrouw, \n\n U bent door $name[0]. $surname uitgenodigd om deel te nemen aan $groupname. \n\n U zult een account moeten registreren om deel te kunnen nemen. \n Dit kan via de volgende link: \n http://localhost/MyBuddy/index.php?page=home";
            $mail->WordWrap = 200;//length of one line

            if ($mail->Send()) {//message if its send, not needed but usefull
                $_SESSION['mailsend'] = "Er is een uitnodiging verzonden aan $email";

                $query3 = $conn->prepare("INSERT INTO register SET email=:email, group_id=:group_id");
                $query3->execute(array(
                    ":email" => $email,
                    ":group_id" => $group_id
                ));

                header("Location: ../?page=group_info&id=$group_id");
            }
            else {//message if it didn't send
                $_SESSION['notsend'] = 'Er is een fout opgetreden bij het toevoegen van deze gebruiker, probeer het opnieuw';
                header("Location: ../?page=group_info&id=$group_id");
            }
        }
        catch (Exception $e) {//send an exception if something in the phpmailer code throws an error
            $_SESSION['error'] = 'Er is een fout opgetreden, ' && $mail->ErrorInfo;
            header("Location: ../?page=group_info&id=$group_id");
        }
    }
}
else {
//displays this if button was not pressed or if something went wrong during the last page/current loading of the use/require stuff
    $_SESSION['notsend'] = 'Er is een fout opgetreden bij het toevoegen, probeer het opnieuw';
    header("Location: ../?page=group_info&id=$group_id");
}









