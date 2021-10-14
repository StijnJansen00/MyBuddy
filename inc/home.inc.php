<?php
include 'php/dbh.php';

if (isset($_SESSION['login'])) {
    ?>
    <div class="header">
        <div class="container">
            Mijn groepen
        </div>
    </div>
    <div class="container p-t-40">
        <a href="index.php?page=new_group" class="buttonGroup">Nieuwe groep</a>
        <br><br>
        <table class="table" id="grouptable">
            <tr>
                <th>Groepnaam</th>
            </tr>
            <?php
            $query1 = $conn->prepare("
                    SELECT G.groupname AS name, G.group_id AS id
                    FROM user_group AS UG
                    INNER JOIN `group` AS G
                    ON UG.group_id = G.group_id
                    WHERE user_id=:user_id");
            $query1->execute(array(
                ":user_id" => $_SESSION['user_id']
            ));

            foreach ($query1 as $result1) {
                ?>
                <tr>
                    <td>
                        <a href="index.php?page=group_info&id=<?= $result1['id']; ?>">
                            <?= $result1['name'] ?>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
    <?php
}
else {
    echo '<img class="home_image" src="img/background_home.png" alt="image">';
}

