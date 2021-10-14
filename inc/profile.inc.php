<?php
include 'php/dbh.php';
?>
<div class="header">
    <div class="container">
        Mijn account
    </div>
</div>
<div class="container p-t-40">
    <div class="col-4">
        <h2>
            Profiel
        </h2>
        <hr>
        <form action="php/edit_user.php" method="post">
            <br>
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="text-red">';
                echo $_SESSION['error'];
                echo '</div>';

                $_SESSION['error'] = NULL;
            }
            if (isset($_SESSION['succes'])) {
                echo '<div class="text-green">';
                echo $_SESSION['succes'];
                echo '</div>';

                $_SESSION['succes'] = NULL;
            }

            $query1 = $conn->prepare("SELECT * FROM `user` WHERE user_id=:user_id");
            $query1->execute(array(
                ":user_id" => $_SESSION['user_id']
            ));
            $result1 = $query1->fetch();
            ?>

            <label>Email</label>
            <div class="validate-input m-t-5">
                <input class="inputfield p-l-5 m-b-8" type="email" name="email" value="<?=$result1['email']?>">
            </div>

            <label>Naam</label>
            <div class="validate-input m-t-5">
                <input class="inputfield p-l-5 m-b-8" type="text" name="name" value="<?=$result1['name']?>">
            </div>

            <label>Achternaam</label>
            <div class="validate-input m-t-5">
                <input class="inputfield p-l-5 m-b-8" type="text" name="surname" value="<?=$result1['surname']?>">
            </div>

            <input type="hidden" name="user_id" value="<?=$result1['user_id']?>">

            <button class="buttonGroup m-t-20" type="submit" name="submit">
                Opslaan
            </button>

        </form>
    </div>
</div>

