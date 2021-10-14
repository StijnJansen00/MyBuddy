<?php
$user_id = $_SESSION['user_id'];
?>
<div class="container p-t-10">
    <ul class="nav nav-pills m-0" id="pills-tab" role="tablist">
        <li class="nav-item pill-1">
            <a class="nav-link active text-black" id="pills-deelnemers-tab" data-toggle="pill" href="#pills-deelnemers"
               role="tab"
               aria-controls="pills-deelnemers" aria-expanded="true">Deelnemers</a>
        </li>
        <li class="nav-item pill-1">
            <a class="nav-link text-black" id="pills-groep-tab" data-toggle="pill" href="#pills-groep" role="tab"
               aria-controls="pills-groep" aria-expanded="true">Groep</a>
        </li>
    </ul>

    <div class="bd-example bd-example-tabs">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-deelnemers" role="tabpanel"
                 aria-labelledby="pills-deelnemers-tab">
                <?php
                $query = $conn->prepare("
                    SELECT U.email, U.name, U.surname,
                    (SELECT groupname FROM `group` WHERE group_id=:group_id) AS groupname
                    FROM user AS U
                    INNER JOIN user_group AS UG
                    ON U.user_id = UG.user_id
                    WHERE group_id=:group_id");
                $query->execute(array(
                    ":group_id" => $group_id
                ));
                ?>
                <div class="container p-t-15">
                    <h2>Deelnemers</h2>
                    <br>
                    <?php

                    if (isset($_SESSION['mailsend'])) {
                        echo '<div class="text-green">';
                        echo $_SESSION['mailsend'];
                        echo '</div><br>';

                        unset($_SESSION['mailsend']);
                    }
                    if (isset($_SESSION['notsend'])) {
                        echo '<div class="text-red">';
                        echo $_SESSION['notsend'];
                        echo '</div><br>';

                        unset($_SESSION['notsend']);
                    }
                    if (isset($_SESSION['error'])) {
                        echo '<div class="text-red">';
                        echo $_SESSION['error'];
                        echo '</div><br>';

                        unset($_SESSION['error']);
                    }
                    if (isset($_SESSION['succes'])) {
                        echo '<div class="text-green">';
                        echo $_SESSION['succes'];
                        echo '</div><br>';

                        unset($_SESSION['succes']);
                    }

                    ?>
                    <div class="row">
                        <div class="col-4">
                            <?php
                            foreach ($query as $result) {
                                ?>
                                <div class="info_box m-b-5">
                                    <?= $result['name'][0] ?>. <?= $result['surname'] ?>
                                    <br>
                                    <?= $result['email'] ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col-4">
                            <form action="php/edit_particapants.php" method="post">

                                <label>Deelnemer toevoegen/uitnodigen</label>
                                <div class="validate-input m-t-10" data-validate="Vul een email in">
                                    <input class="inputfield p-l-5" type="email" name="email" placeholder="E-mail"
                                           required>
                                </div>

                                <input type="hidden" name="group_id" value="<?= $group_id ?>">

                                <button class="buttonGroup m-t-20" type="submit" name="submit">
                                    Opslaan
                                </button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-groep" role="tabpanel" aria-labelledby="pills-groep-tab">
                <div class="col-4">
                    <form action="php/edit_group.php" method="post">
                        <br>
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo '<div class="text-red">';
                            echo $_SESSION['error'];
                            echo '</div>';

                            $_SESSION['error'] = NULL;
                        }

                        $query1 = $conn->prepare("SELECT * FROM `group` WHERE group_id=:group_id");
                        $query1->execute(array(
                                ":group_id" => $group_id
                        ));
                        $result1 = $query1->fetch();
                        ?>

                        <label>Groepsnaam</label>
                        <div class="validate-input m-t-10">
                            <input class="inputfield p-l-5" type="text" name="groupname" value="<?=$result1['groupname']?>">
                        </div>

                        <input type="hidden" name="group_id" value="<?=$result1['group_id']?>">

                        <button class="buttonGroup m-t-20" type="submit" name="submit">
                            Opslaan
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>