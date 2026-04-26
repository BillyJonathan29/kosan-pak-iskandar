<?php

class Controller
{

    public function view($view, $data = [])
    {
        if (!empty($data)) {
            extract($data);
        }

        // Langsung panggil view targetnya saja
        if (file_exists('../views/' . $view . '.php')) {
            require_once '../views/' . $view . '.php';
        } else {
            die("View <b>{$view}</b> tidak ditemukan!");
        }
    }

    public function model($model)
    {
        if (file_exists('../app/Models/' . $model . '.php')) {
            require_once '../app/Models/' . $model . '.php';
            return new $model;
        } else {
            die("Model <b>{$model}</b> tidak ditemukan!");
        }
    }
}
