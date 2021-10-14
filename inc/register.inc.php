<div class="login limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <form class="login100-form validate-form" action="php/register.php" method="POST">

                <span class="login100-form-title p-b-34 p-t-27">
						Registreren
					</span>

                <?php
                if (isset($_SESSION['error'])){
                    echo '<div class="text-white">';
                    echo $_SESSION['error'];
                    echo '</div>';

                    $_SESSION['error'] = NULL;
                }
                ?>

                <div class="wrap-input100 validate-input" data-validate = "Vul e-mail in">
                    <input class="input100" type="text" required name="email" placeholder="E-mail">
                    <span class="focus-input100" data-placeholder="&#xf207;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Vul een wachtwoord in">
                    <input class="input100" type="password" required name="password" placeholder="Wachtwoord">
                    <span class="focus-input100" data-placeholder="&#xf191;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Herhaal wachtwoord">
                    <input class="input100" type="password" required name="repeat_password" placeholder="Herhaal wachtwoord">
                    <span class="focus-input100" data-placeholder="&#xf191;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Vul voorname in">
                    <input class="input100" type="text" required name="name" placeholder="Voornaam">
                    <span class="focus-input100" data-placeholder="&#xf207;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Vul achternaam in">
                    <input class="input100" type="text" required name="surname" placeholder="Achternaam">
                    <span class="focus-input100" data-placeholder="&#xf207;"></span>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" type="submit" name="submit">
                        Registreren
                    </button>
                </div>

                <div class="text-center p-t-20">
                    <a class="txt1" href="index.php?page=login">
                        Login
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
<img class="home_image" src="img/background_home.png" alt="image">