<?php

namespace Cineflix\App\Controller;

use Cineflix\Core\AbstractController;

class Profil extends AbstractController
{

    public function show()
    {
        $profil = [];
        return $this->render('profil.show',compact('profil'));
    }

}
