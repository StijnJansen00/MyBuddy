<?php require 'permissions/roles.php';

if (isset($_SESSION['login'])) {
    $userArray = $menuItems['user'];
}
else {
    $userArray = $menuItems['guest'];
}

echo '<nav class="navbar navbar-expand-md navbar-blue bg-blue sticky-top">';
echo '<div class="container">';
echo '<a class="navbar-brand" href="index.php?page=home">MyBuddy 2.0</a>';
echo '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04 aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">"';
echo '<span class="navbar-toggler-icon"></span>';
echo '</button>';
echo '<div class="collapse navbar-collapse" id="navbarsExample04">';


// Linker navbar
echo '<ul class="navbar-nav mr-auto">';
foreach ($userArray as $menuItem) {
    if ($menuItem[2] == 'L') {
        if (gettype($menuItem[1]) !== 'string'){
            echo '<div class="dropdown">';
            echo '<button class="dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            echo $_SESSION['name'][0], $_SESSION['surname'][0];
            echo '</button>';
            echo '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
            foreach ($menuItem[1] as $DropItem){
                echo '<a class="dropdown-item" href="index.php?page=' . $DropItem[0] . '">' . $DropItem[1] . '</a>';
            }
            echo '</div>';
            echo '</div>';
        }
        else{
            echo '<li class="nav-item"><a class="nav-link" href="index.php?page=' . $menuItem[0] . '">' . $menuItem[1] . '</a></li>';
        }
    }
}
echo '</ul>';


// Rechter navbar
echo '<ul class="navbar-nav form-inline my-2 my-md-0">';
foreach ($userArray as $menuItem) {
    if ($menuItem[2] == 'R') {
        if (gettype($menuItem[1]) !== 'string'){
            echo '<div class="dropdown">';
            echo '<button class="dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            echo '<div class="circle_navbar">'.$_SESSION['name'][0], $_SESSION['surname'][0].'</div>';
            echo '</button>';
            echo '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
            foreach ($menuItem[1] as $DropItem){
                echo '<a class="dropdown-item" href="index.php?page=' . $DropItem[0] . '">' . $DropItem[1] . '</a>';
            }
            echo '</div>';
            echo '</div>';
        }
        else{
            echo '<li class="nav-item"><a class="nav-link" href="index.php?page=' . $menuItem[0] . '">' . $menuItem[1] . '</a></li>';
        }
    }
}

echo '</ul>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</nav>';
