<?php

class Controller
{
    private $model = null;

    public function __construct()
    {

    }
    public function loadModel($model_name)
    {
        $this->model = $model_name;
        require './application/models/' . $model_name . '.php';
        return new $this->model();
    }
}
?>