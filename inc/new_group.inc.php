<div class="header">
    <div class="container">
        Nieuwe groep aanmaken
    </div>
</div>
<div class="container p-t-40">
    <div class="col-4">
        <form action="php/new_group.php" method="post">

            <h2>Groepsnaam</h2>
            <br>

            <?php
            if (isset($_SESSION['error'])){
                echo '<div class="text-red">';
                echo $_SESSION['error'];
                echo '</div>';

                $_SESSION['error'] = NULL;
            }
            ?>

            <label>Groepsnaam</label>
            <div class="validate-input m-t-10">
                <input class="inputfield" type="text" required name="groupname">
            </div>

            <button class="buttonGroup m-t-20" type="submit" name="submit">
                Opslaan
            </button>

        </form>
    </div>
</div>
