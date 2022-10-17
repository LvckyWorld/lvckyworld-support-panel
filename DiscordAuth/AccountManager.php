<?php

namespace DiscordAuth\Authentication;

require_once 'DiscordAuth.php';

class AccountManager
{

    public function __construct(private mixed $discordUser = null)
    {
        $this->discordUser = $this::getUser();
    }

    function getUser(): mixed
    {
        if (session("access_token")) {
            // Logged in
            $apiURLBase = "https://discord.com/api/users/@me";
            return apiRequest($apiURLBase);
        } else {
            return false;
        }
    }

    function isOnLvckyWorldServer(): bool
    {
        if (session("access_token")) {
            // Logged in
            $apiURLBase = "https://discord.com/api/users/@me/guilds";
            $response = apiRequest($apiURLBase);

            foreach ($response as $response) {
                if ($response->id == '751432986729250866') {
                    return true;
                }
            }
        }
        return false;
    }

    function getGuilds()
    {
        if (session("access_token")) {
            // Logged in
            $apiURLBase = "https://discord.com/api/users/@me/guilds";
            return apiRequest($apiURLBase);
        } else {
            return false;
        }
    }

    function authenticate(): void
    {
        // if user is logged in
        if (session('access_token')) {
            $apiURLBase = "https://discord.com/api/users/@me";
            $user = apiRequest($apiURLBase);
            if (empty($user->id)) {
                session_destroy();
                header("Refresh:0");
            }
        } else {
            ?>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="#">Ticket-System</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="https://lvckyworld.net">Home</a>
                        </li>
                        <button onclick="window.location.href = '/?action=login'" type="button" class="btn btn-outline-success my-2 my-sm-0"">
                        Einloggen
                        </button>

                        <!---
                        <button type="button" class="btn btn-outline-success my-2 my-sm-0" data-bs-toggle="modal"
                                data-bs-target="#createTicketModal">
                            Ticket erstellen
                        </button>
                        --->
                    </ul>
                </div>
            </nav>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

            <?php
            exit;
        }
    }

    function getID(): string
    {
        return $this->discordUser->id;
    }

    function getUsername(): string
    {
        return $this->discordUser->username;
    }

    function getAvatarURL(): string
    {
        $userId = $this->discordUser->id;
        $avatar = $this->discordUser->avatar;
        if (str_starts_with($avatar, 'a_')) {
            $userAvatar = "https://cdn.discordapp.com/avatars/" . $userId . "/" . $avatar . ".gif?size=512";
        } else {
            $userAvatar = "https://cdn.discordapp.com/avatars/" . $userId . "/" . $avatar . ".png?size=512";
        }
        return $userAvatar;
    }
}