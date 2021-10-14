<?php
include 'php/dbh.php';
if (isset($_GET['id'])) {
    $group_id = $_GET['id'];
}

$query = $conn->prepare("SELECT * FROM `group` WHERE group_id=:id");
$query->execute(array(
    ":id" => $group_id
));
$result = $query->fetch();

?>
<div class="header1">
    <div class="container">
        <?= $result['groupname'] ?>
        <br><br>
        <div>
            <ul class="nav nav-pills m-0" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active text-white" id="pills-uitgaven-tab" data-toggle="pill" href="#pills-uitgaven"
                       role="tab"
                       aria-controls="pills-uitgaven" aria-expanded="true">Uitgaven</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" id="pills-balans-tab" data-toggle="pill" href="#pills-balans" role="tab"
                       aria-controls="pills-balans" aria-expanded="true">Balans</a>
                </li>
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link text-white" id="pills-verkennen-tab" data-toggle="pill" href="#pills-verkennen" role="tab"-->
<!--                       aria-controls="pills-verkennen" aria-expanded="true">Verkennen</a>-->
<!--                </li>-->
                <li class="nav-item">
                    <a class="nav-link text-white" id="pills-extra-tab" data-toggle="pill" href="#pills-extra" role="tab"
                       aria-controls="pills-extra" aria-expanded="true">
                        <i class="fa fa-circle fs-8" aria-hidden="true"></i>
                        <i class="fa fa-circle fs-8" aria-hidden="true"></i>
                        <i class="fa fa-circle fs-8" aria-hidden="true"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="container p-t-10">
    <div class="bd-example bd-example-tabs">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-uitgaven" role="tabpanel"
                 aria-labelledby="pills-uitgaven-tab">
                <?php include 'tab_expense.inc.php'; ?>
            </div>
            <div class="tab-pane fade" id="pills-balans" role="tabpanel" aria-labelledby="pills-balans-tab">
                <?php include 'tab_balance.inc.php'; ?>
            </div>
<!--            <div class="tab-pane fade" id="pills-verkennen" role="tabpanel" aria-labelledby="pills-verkennen-tab">-->
<!--                --><?php //include 'tab_explore.inc.php'; ?>
<!--            </div>-->
            <div class="tab-pane fade" id="pills-extra" role="tabpanel" aria-labelledby="pills-extra-tab">
                <?php include 'tab_extra.inc.php'; ?>
            </div>
        </div>
    </div>
</div>