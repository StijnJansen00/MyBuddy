<?php
$naam = '';

$menuItems = [
    "user" => [
        array('home', 'Mijn Groepen', 'L'),
        array($naam, array(
            array('logout', 'Logout'),
            array('profile', 'Mijn account'),
        ),'R'),
    ],
    "guest" => [
        array('home', 'Home', 'L'),
        array('login', 'Login', 'R')
    ]
];
