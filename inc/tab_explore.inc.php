<table class="table m-t-20" id="grouptable">
    <h2 class="m-t-5">Verkennen</h2>
    <?php
    $query = $conn->prepare("
        SELECT U.name, U.surname, P.description, P.amount, P.date
        FROM payment AS P
        INNER JOIN user_group AS UG
        ON P.user_group_id = UG.user_group_id
        INNER JOIN user AS U
        ON UG.user_id = U.user_id
        WHERE UG.group_id=:group_id");
    $query->execute(array(
        ":group_id" => $group_id
    ));

    foreach ($query as $result) {
        ?>
        <tr>
            <td>
                <div class="circle">
                    <?= $result['name'][0] ?><?= $result['surname'][0] ?>
                </div>
                <div class="m-l-60 m-t-10">
                    <?= $result['name'] ?> <?= $result['surname'] ?>
                </div>
            </td>
            <td>
                ...
            </td>
        </tr>
        <?php
    }
    ?>
</table>
