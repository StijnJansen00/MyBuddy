<table class="table m-t-20" id="grouptable">
    <tr>
        <th>Wie</th>
        <th>Saldo</th>
        <th>Uitgaven</th>
    </tr>
    <?php
    $query = $conn->prepare("SELECT * FROM user_group WHERE group_id=:group_id");
    $query->execute(array(
        ":group_id" => $group_id
    ));

    foreach ($query as $result) {
        $query1 = $conn->prepare("
        SELECT U.name,
        (SELECT SUM(amount) FROM payment WHERE user_group_id=UG.user_group_id) AS expense,
        (SELECT SUM(amount) FROM dept WHERE user_group_id=UG.user_group_id) AS topay
        FROM payment AS P
        RIGHT JOIN user_group AS UG
        ON P.user_group_id = UG.user_group_id
        RIGHT JOIN `user` AS U
        ON UG.user_id = U.user_id
        RIGHT JOIN `group` AS G
        ON UG.group_id = G.group_id
        WHERE G.group_id = :group_id
        AND UG.user_group_id = :user_group_id
        GROUP BY UG.user_group_id
        ");
        $query1->execute(array(
            ":group_id" => $group_id,
            ":user_group_id" => $result['user_group_id']
        ));

        foreach ($query1 as $result1) {

            $saldo = $result1['expense'] - $result1['topay'];

            if ($saldo < 0) {
                ?>
                <tr>
                    <td>
                        <?= $result1['name'] ?>
                    </td>
                    <td class="text-danger">
                        <?php
                        if(empty($saldo)){
                            echo'&euro; 0,00';
                        }
                        else{
                            echo '&euro; '.$saldo ;
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if(empty($result1['expense'])){
                            echo'&euro; 0,00';
                        }
                        else{
                            echo '&euro; '.$result1['expense'] ;
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
            else {
                ?>
                <tr>
                    <td>
                        <?= $result1['name'] ?>
                    </td>
                    <td class="text-success">
                        <?php
                        if(empty($saldo)){
                            echo'&euro; 0,00';
                        }
                        else{
                            echo '&euro; '.$saldo ;
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if(empty($result1['expense'])){
                            echo'&euro; 0,00';
                        }
                        else{
                            echo '&euro; '.$result1['expense'] ;
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }

        }
    }
    ?>
    <tr>
        <td><h4>Totale uitgaven:</h4></td>
        <td></td>
        <td>
            <?php
            $query2 = $conn->prepare("
                SELECT SUM(P.amount) AS total
                FROM payment AS P
                INNER JOIN user_group AS UG
                ON P.user_group_id = UG.user_group_id
                WHERE UG.group_id = :group_id");
            $query2->execute(array(
                ":group_id" => $group_id
            ));
            $result2 = $query2->fetch();

            if (empty($result2['total'])) {
                ?>
                &euro; 0,00
                <?php
            } else {
                ?>
                &euro; <?= $result2['total'] ?>
                <?php
            }
            ?>
        </td>
    </tr>
</table>