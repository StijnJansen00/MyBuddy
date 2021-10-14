<?php
include 'php/dbh.php';

$query = $conn->prepare("
    SELECT U.email, U.name, U.surname,
    (SELECT groupname FROM `group` WHERE group_id=:group_id) AS groupname
    FROM user AS U
    INNER JOIN user_group AS UG
    ON U.user_id = UG.user_id
    WHERE group_id=:group_id");
$query->execute(array(
    ":group_id" => $_SESSION['group_id']
));

?>
<div class="header">
    <div class="container">
        Deelnemers toevoegen
    </div>
</div>
<div class="container p-t-40">

    <h2>Deelnemers</h2>
    <br>
    <?php

    if (isset($_SESSION['mailsend'])) {
        echo '<div class="text-green">';
        echo $_SESSION['mailsend'];
        echo '</div>';

        unset($_SESSION['mailsend']);
    }
    if (isset($_SESSION['notsend'])) {
        echo '<div class="text-red">';
        echo $_SESSION['notsend'];
        echo '</div>';

        unset($_SESSION['notsend']);
    }
    if (isset($_SESSION['error'])) {
        echo '<div class="text-red">';
        echo $_SESSION['error'];
        echo '</div>';

        unset($_SESSION['error']);
    }
    if (isset($_SESSION['accept'])) {
        echo '<div class="text-green">';
        echo $_SESSION['accept'];
        echo '</div>';

        unset($_SESSION['accept']);
    }

    ?>
    <div class="row">
        <div class="col-4">
            <?php
            foreach ($query as $result) {
                ?>
                <div class="info_box m-b-5">
                    <?=$result['name'][0]?>. <?=$result['surname']?>
                    <br>
                    <?=$result['email']?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="col-4">
            <form action="php/select_particapants.php" method="post">

                <label>Deelnemer toevoegen/uitnodigen</label>
                <div class="validate-input m-t-10" data-validate="Vul een email in">
                    <input class="inputfield p-l-5" type="email" name="email" placeholder="E-mail">
                </div>

                <button class="buttonGroup m-t-20" type="submit" name="submit">
                    Opslaan
                </button>
                <br>
                <div class="m-t-10">
                    <a href="index.php?page=group_info&id=<?=$_SESSION['group_id']?>">
                        Klaar voor nu?
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
