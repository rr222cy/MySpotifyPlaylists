<?php

namespace view;

class MixtapeView {
    private $userModel;
    private $mixtapeRepository;
    private $messages;

    public function __construct()
    {
        $this->userModel = new \model\UserModel();
        $this->mixtapeRepository = new \model\MixtapeRepository();
        $this->messages = new \view\MessageView();
    }

    public function mixtapeChosen() {
        if (isset($_GET["mixtapeID"]))
        {
            return $_GET["mixtapeID"];
        }
        else
        {
            return NULL;
        }
    }

    public function mixtapeRemoveChosen() {
        if (isset($_GET["remove"]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function mixtapeRemoved() {
        return "<div class='container'>
                <h1>Mixtape removed</h1>
                <p>The mixtape was successfully removed!</p>
                <p>Use the main menu to see your other mixtapes, or why not create a new one?</p>
                </div>";
    }

    public function showPage($mixtape, $mixtapeRows) {

            if($mixtape != NULL)
            {
                $content = "<div class='container'>";
                $content .= "<h1>Mixtape: " . $mixtape->getName() . "</h1>"  . $this->messages->load() . "
            <p>" . $mixtape->getCreationDate() . "</p><p></p>
            <img src='src/gfx/playlistImages/" . $mixtape->getPicture() . "' width='250' />
            <h3>Songs</h3>";

                foreach ($mixtapeRows->toArray() as $mixtapeRow) {
                    $string = file_get_contents("http://ws.spotify.com/lookup/1/.json?uri=" . $mixtapeRow->getSong());
                    $res = json_decode($string, true);
                    $trackArtists = $res["track"]["artists"];

                    $content .= "<div class='row'><div class='col-md-12'>";
                    foreach ($trackArtists as $trackArtist) {
                        $content .= "<strong>" . $trackArtist["name"] . ", </strong>";
                    }

                    $content .= " - " .  $res["track"]["name"] . "</div></div><p>&nbsp;</p>";
                };

                $content .= "<h3>Handle mixtape</h3>
                                <a href='?action=mixtape&remove=true&mixtapeID=" . $mixtape->getMixtapeID() . "'>Remove mixtape</a></div>";
                return $content;
            }
            else
            {
                return "<div class='container'>
                <h1>Not found</h1>
                <p>No mixtape with that ID was found</p>
                </div>";
            }

    }
}