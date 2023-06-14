<?php

namespace application\controllers;

use application\core\Controller;

class MainController extends Controller
{
    public function indexAction() {

        $vars = [
            'name' => 'mvc-php-framework'
        ];
        $this->view->render('main', $vars);
    }
}