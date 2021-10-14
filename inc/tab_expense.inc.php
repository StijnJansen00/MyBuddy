<form action="index.php?page=new_expense&id=<?= $group_id ?>" method="post">
    <button class="buttonGroup m-t-15" type="submit" name="submit">
        Nieuwe uitgaven
    </button>
</form>
<?php
if (isset($_SESSION['succes'])){
    echo '<br><div class="text-green">';
    echo $_SESSION['succes'];
    echo '</div>';

    $_SESSION['succes'] = NULL;
}
?>
<table class="table m-t-20" id="grouptable">
    <tr>
        <th>Aangemaakt door</th>
        <th>Omschrijving</th>
        <th>Bedrag</th>
        <th>Datum</th>
    </tr>
    <?php
    $query = $conn->prepare("
        SELECT U.name, P.description, P.amount, P.date, P.payment_id
        FROM payment AS P
        INNER JOIN user_group AS UG
        ON P.user_group_id = UG.user_group_id
        INNER JOIN `user` AS U
        ON UG.user_id = U.user_id
        WHERE UG.group_id=:group_id");
    $query->execute(array(
        ":group_id" => $group_id
    ));

    foreach ($query as $result) {

        ?>
        <tr data-toggle="modal" data-target="#myModal<?= $result['payment_id'] ?>">
            <td>
                <?= $result['name'] ?>
            </td>
            <td>
                <?= $result['description'] ?>
            </td>
            <td>
                &euro;<?= $result['amount'] ?>
            </td>
            <td>
                <?= $result['date'] ?>
            </td>
        </tr>
        <div class="modal" id="myModal<?= $result['payment_id'] ?>">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title description"><?= $result['description'] ?></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <?php
                        $query1 = $conn->prepare("
                            SELECT D.amount, U.name, U.surname
                            FROM dept AS D
                            INNER JOIN user_group AS UG
                            ON D.user_group_id = UG.user_group_id
                            INNER JOIN `user` AS U
                            ON UG.user_id = U.user_id
                            WHERE payment_id = :payment_id");
                        $query1->execute(array(
                            ":payment_id" => $result['payment_id']
                        ));
                        foreach ($query1 as $result1) {

                            echo $result1['name'] . '&nbsp;' . $result1['surname'] . '&nbsp;' . '&euro; ' . $result1['amount'] . '<br>';

                        }
                        ?>
                    </div>

                    <div class="modal-footer">
                        <?php
                        $query2 = $conn->prepare("
                            SELECT U.user_id 
                            FROM payment AS P 
                            INNER JOIN user_group AS UG 
                            ON P.user_group_id = UG.user_group_id
                            INNER JOIN `user` AS U
                            ON UG.user_id = U.user_id
                            WHERE P.payment_id = :id");
                        $query2->execute(array(
                            ":id" => $result['payment_id']
                        ));
                        $result2 = $query2->fetch();

                        if ($result2['user_id'] == $_SESSION['user_id']) {
                            ?>
                            <form action="php/delete_payment.php" method="post">
                                <input type="hidden" name="payment_id" value="<?= $result['payment_id'] ?>">
                                <input type="hidden" name="group_id" value="<?= $group_id?>">
                                <button type="submit" class="btn btn-danger">Verwijder deze uitgaven</button>
                            </form>
                            <?php
                        } else {
                            ?>
                            <button type="button" class="btn btn-danger" disabled>Verwijder deze uitgaven</button>
                            <?php
                        }
                        ?>

                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
        <?php
    }
    ?>
</table>
