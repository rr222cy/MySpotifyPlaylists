<?php
namespace view;

class MixtapesView {
    private $userModel;
    private $messages;

    public function __construct()
    {
        $this->userModel = new \model\UserModel();
        $this->messages = new \view\MessageView();
    }

    public function showPage(\model\MixtapeList $mixtapes) {

            $content = "
                <div class='jumbotron'>
                  <div class='container'>
                    <img src='src/gfx/Logo.png' width='500' height='200' alt='Mixtapeify' />
                  </div>
                </div>
                <div class='container'>
                            <h1>Browsing all mixtapes</h1>
                            <p>&nbsp;</p>

                            ";
            $i = 0;
            // Loops out all of the mixtapes from the database.
            foreach ($mixtapes->toArray() as $mixtape) {
                $i += 1;
                if($i % 4 == 0)
                {
                    $content .= "<div class='row'>";
                }
                $content .= "<div class='col-md-3'><img class='img' src='src/gfx/playlistImages/" . $mixtape->getPicture() . "' />";
                $content .= "<h4 class='noSpacing'>". $mixtape->getName() .  "</h4>";
                $content .= "<p>". $mixtape->getCreationDate() . "</p>";
                $content .= "<p><a class='btn btn-default' href='?action=mixtape&mixtapeID=". $mixtape->getMixtapeID() . "'>View mixtape</a></p></div>";
                if($i % 4 == 0)
                {
                    $content .= "</div>";
                }
            };

            $content .= "</div><p>&nbsp;</p>";

            return $content;

    }
}