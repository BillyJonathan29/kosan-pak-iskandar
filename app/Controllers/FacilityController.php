<?php

class FacilityController extends Controller {

    public function index() {
        $data = [
            'title'       => 'Manajemen Fasilitas',
            'breadcrumbs' => [
                ['label' => 'Home',      'url' => BASEURL],
                ['label' => 'Fasilitas', 'url' => '']
            ],
            'facilities' => $this->model('Facility')->getAllFacilities()
        ];

        $this->view('facilities/index', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('Facility')->addFacility($_POST)) {
                header('Location: ' . BASEURL . '/facility');
                exit;
            } else {
                header('Location: ' . BASEURL . '/facility');
                exit;
            }
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('Facility')->updateFacility($_POST)) {
                header('Location: ' . BASEURL . '/facility');
                exit;
            } else {
                header('Location: ' . BASEURL . '/facility');
                exit;
            }
        }
    }

    public function delete($id) {
        if ($this->model('Facility')->deleteFacility($id)) {
            header('Location: ' . BASEURL . '/facility');
            exit;
        } else {
            header('Location: ' . BASEURL . '/facility');
            exit;
        }
    }

    public function getubah() {
        echo json_encode($this->model('Facility')->getFacilityById($_POST['id']));
    }
}
