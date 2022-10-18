<?php
use DiscordAuth\Authentication\AccountManager;

include_once 'DiscordAuth/AccountManager.php';



class LvckyWorldUser
{

    public function __construct(private mixed $discordUser = null)
    {
        $this->discordUser = (new AccountManager())->getUser();
    }

    public function isLvckyWorldTeamMember(): bool
    {
        $isTeamMember = false;
        $lvckyWorldTeam = json_decode(file_get_contents("https://api.lvckyworld.net:61619/lvckyworldTeam"));
        foreach ($lvckyWorldTeam->teamMembers as $team) {
            if ($team->clientid == (new AccountManager())->getID()) {
                $isTeamMember = true;
            }
        }
        return $isTeamMember;
    }
}