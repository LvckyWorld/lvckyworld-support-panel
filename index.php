<?php


session_name("ticket_support");
session_start();

use DiscordAuth\Authentication\AccountManager;

// include_once './util/autoImport.php';
include_once './modules/header.php';
include_once 'DiscordAuth/DiscordAuth.php';
include_once 'DiscordAuth/AccountManager.php';

include_once './util/checkUser.php';

// TODO Fix loading Time 16s
echo (new LvckyWorldUser())->isLvckyWorldTeamMember();

(new AccountManager())->authenticate();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticket System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">


</head>
<body style="background-color: #505050">
<div id="main-content">
    <?php
    load();
    ?>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>