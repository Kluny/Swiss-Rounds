<?php

namespace SwissRounds\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{
    public function initialize() {
        $this->loadComponent('Flash');
        $this->set('cakeDescription', "Polo For The People");
    }


}
