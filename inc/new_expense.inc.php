<?php
include "php/dbh.php";
if (isset($_GET['id'])) {
    $group_id = $_GET['id'];
}
?>
<div class="header">
    <div class="container">
        Nieuwe uitgaven aanmaken
    </div>
</div>
<div class="container p-t-40">
    <form action="php/new_expense.php" method="post">

        <h2>Uitgaven</h2>
        <br>

        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="text-red">';
            echo $_SESSION['error'];
            echo '</div>';

            $_SESSION['error'] = NULL;
        }
        ?>
        <div class="row">

            <div class="col-2">
                <label>Betaald door:</label>
                <select name="user_id" class="validate-input m-t-10 inputfield1" data-validate="Vul een naam in" required>
                    <?php
                    $query = $conn->prepare("
                    SELECT U.name, U.user_id, U.surname
                    FROM user_group AS UG
                    INNER JOIN `user` AS U
                    ON UG.user_id = U.user_id
                    WHERE UG.group_id=:id
                    ORDER BY U.name");
                    $query->execute(array(
                        ":id" => $group_id
                    ));
                    ?>
                    <option value="<?= $_SESSION['user_id'] ?>"><?= $_SESSION['name'] ?> <?= $_SESSION['surname'] ?></option>
                    <?php
                    foreach ($query as $result) {

                        if ($result['user_id'] !== $_SESSION['user_id']) {
                            ?>
                            <option value="<?= $result['user_id'] ?>"><?= $result['name'] ?> <?= $result['surname'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="col-2">
                <label>Bedrag in &euro;</label>
                <div class="m-t-10" data-validate="Vul een bedrag in">
                    <input class="inputfield p-l-5" onchange="devideamount()" id="amount" min="0.00" step="0.01"  type="number" name="amount" required>
                </div>
            </div>

            <div class="col-2">
                <label>Datum</label>
                <div class="validate-input m-t-10" data-validate="Vul een datum in">
                    <input class="tail-datetime-field inputfield p-l-5" type="date" name="date" required>
                </div>
            </div>


        </div>
        <br>
        <label>Beschrijving</label>
        <div class="validate-input m-t-10" data-validate="Vul een beschrijving in">
                <textarea class="inputfield p-l-5" name="description" required
                          style="margin: 8px 0px 10px; width: 540px; height: 118px;"></textarea>
        </div>
        <input type="hidden" value="<?= $group_id ?>" name="group_id">


        Deelnemers

        <?php
        $query1 = $conn->prepare("
                    SELECT U.email, U.name, U.surname, UG.user_group_id, 
                    (SELECT groupname FROM `group` WHERE group_id=:group_id) AS groupname
                    FROM user AS U
                    INNER JOIN user_group AS UG
                    ON U.user_id = UG.user_id
                    WHERE group_id=:group_id");
        $query1->execute(array(
            ":group_id" => $group_id
        ));

        foreach ($query1 as $result1) {
            ?>
            <div class="expense_box m-b-5 col-4">
                <div class="devider">
                    <p><?= $result1['name'] ?> <?= $result1['surname'] ?></p>
                    <div class="buttons">
                        <button type="button" class="btn_expense m-l-3 m-b-3" onclick="min(this)">-</button>
                        <input type="number" class="counter text-center" value="0" min="0" step="0.01" disabled>
                        <button  type="button" class="btn_expense1 m-b-3" onclick="plus(this)">+</button>
                    </div>
                    <input class="inputfield output" type="number" name="debts[<?= $result1['user_group_id'] ?>]" readonly="readonly">
                </div>
            </div>
            <?php
        }
        ?>
        <button class="buttonGroup m-t-20" type="submit" name="submit">Uitgaven toevoegen</button>
    </form>
</div>

