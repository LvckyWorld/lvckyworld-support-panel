<?php

use DiscordAuth\Authentication\AccountManager;

$notification = null;
$_SESSION["notification"] = null;
if (isset($_POST["create_ticket"])) {

    if (isset($_POST["title"]) || isset($_POST["description"])) {
        $title = $_POST["title"];
        $description = $_POST["description"];

        include_once 'util/database.php';

        getConnection()->query("INSERT INTO `tickets` (`title`, `discordid`, `description`, `active`) VALUES ('$title', '" . (new AccountManager())->getID() . "', '$description', false);");

        $notificationMessage = "Ticket erstellt. Bitte checke deine Discord Nachrichten";
        header("Location: /?notification=" . $notificationMessage);
    }
    return;
}

if (isset($_REQUEST['notification'])) {
    // Send Notification
    $notification = $_REQUEST['notification'];
    $_SESSION["notification"] = $notification;

}

function load()
{
    ?>
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

                <button type="button" class="btn btn-outline-success my-2 my-sm-0 m-4" data-bs-toggle="modal"
                        data-bs-target="#createTicketModal">
                    Ticket erstellen
                </button>

                <button onclick="window.location.href = '/?action=logout'" type="button" class="btn btn-outline-danger my-2 my-sm-0"">
                    Ausloggen
                </button>

            </ul>
        </div>
    </nav>

    <!-- Modals -->
    <div class="modal fade" id="createTicketModal" tabindex="-1" aria-labelledby="createTicketModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTicketModalLabel">Ticket erstellen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="form-floating mb-3">
                        <input type="number" name="discordID" class="form-control" id="floatingInput"
                               placeholder="447285957004099584" disabled value="<?php echo (new AccountManager())->getID(); ?>">
                        <label for="floatingInput">Discord-ID</label>
                    </div>
                    <div class="form-floating mb-2">
                        <input type="text" name="title" class="form-control" id="floatingPassword"
                               placeholder="Anfrage Discord-Bot">
                        <label for="floatingPassword">Titel</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" name="description" class="form-control" id="floatingPassword"
                               placeholder="Kurze Beschreibung">
                        <label for="floatingPassword">Kurze Beschreibung</label>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="create_ticket">Erstellen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}

?>


