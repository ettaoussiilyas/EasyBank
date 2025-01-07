<?php

class BaseController
{


    public function render($view, $data = [])
    {

        extract($data);
        include_once __DIR__ . '/../app/views/' . $view . '.php';
    }

    public function renderAdmin($view, $data = [])
    {

        extract($data);
        include_once __DIR__ . '/../app/views/admin/' . $view . '.php';
    }

    public function renderClient($view, $data = [])
    {

        extract($data);
        include_once __DIR__ . '/../app/views/client/' . $view . '.php';
    }
}
