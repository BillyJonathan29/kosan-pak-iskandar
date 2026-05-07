<?php

class KosController extends Controller {
    
    public function __construct()
    {
        $this->requireRole('admin');
    }

    public function index() {
        $data = [
            'title' => 'Manajemen Kos',
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => BASEURL],
                ['label' => 'Kos', 'url' => '']
            ],
            'kos' => $this->model('Kos')->getAllKos()
        ];

        $this->view('kos/index', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('Kos')->addKos($_POST)) {
                header('Location: ' . BASEURL . '/kos');
                exit;
            } else {
                header('Location: ' . BASEURL . '/kos');
                exit;
            }
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('Kos')->updateKos($_POST)) {
                header('Location: ' . BASEURL . '/kos');
                exit;
            } else {
                header('Location: ' . BASEURL . '/kos');
                exit;
            }
        }
    }

    public function delete($id) {
        if ($this->model('Kos')->deleteKos($id)) {
            header('Location: ' . BASEURL . '/kos');
            exit;
        } else {
            header('Location: ' . BASEURL . '/kos');
            exit;
        }
    }

    public function getubah() {
        echo json_encode($this->model('Kos')->getKosById($_POST['id']));
    }
}
