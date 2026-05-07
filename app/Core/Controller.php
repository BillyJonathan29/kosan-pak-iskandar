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

    public function requireLogin()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    public function requireRole($role)
    {
        $this->requireLogin();

        if ($_SESSION['user']['role'] !== $role) {
            // Jika user mencoba akses admin, lempar ke katalog
            if ($role === 'admin') {
                header('Location: ' . BASEURL . '/katalog');
            } else {
                // Jika admin mencoba akses fitur khusus user (opsional), lempar ke dashboard admin
                header('Location: ' . BASEURL . '/home');
            }
            exit;
        }
    }
}
