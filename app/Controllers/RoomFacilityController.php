<?php

class RoomFacilityController extends Controller {

    public function index() {
        $data = [
            'title'          => 'Fasilitas Kamar',
            'breadcrumbs'    => [
                ['label' => 'Home',            'url' => BASEURL],
                ['label' => 'Fasilitas Kamar', 'url' => '']
            ],
            'room_facilities' => $this->model('RoomFacility')->getAllRoomFacilities(),
            'rooms'           => $this->model('Room')->getAllRooms(),
            'facilities'      => $this->model('Facility')->getAllFacilities()
        ];

        $this->view('room_facilities/index', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $result = $this->model('RoomFacility')->addRoomFacility($_POST);
            header('Location: ' . BASEURL . '/roomfacility');
            exit;
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model('RoomFacility')->updateRoomFacility($_POST);
            header('Location: ' . BASEURL . '/roomfacility');
            exit;
        }
    }

    public function delete($id) {
        $this->model('RoomFacility')->deleteRoomFacility($id);
        header('Location: ' . BASEURL . '/roomfacility');
        exit;
    }

    public function getubah() {
        echo json_encode($this->model('RoomFacility')->getRoomFacilityById($_POST['id']));
    }
}
