<?php

class RoomFacilityController extends Controller
{
    public function __construct()
    {
        $this->requireRole('admin');
    }

    public function index()
    {
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

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $rfModel = $this->model('RoomFacility');
            // support multiple facility_ids (facility_id[])
            if (isset($_POST['facility_id']) && is_array($_POST['facility_id'])) {
                $room_id = $_POST['room_id'];
                $facility_ids = array_map('intval', $_POST['facility_id']);
                $inserted = $rfModel->addMultipleRoomFacilities($room_id, $facility_ids);
            } else {
                $result = $rfModel->addRoomFacility(['room_id' => $_POST['room_id'], 'facility_id' => $_POST['facility_id']]);
            }
            header('Location: ' . BASEURL . '/roomfacility');
            exit;
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model('RoomFacility')->updateRoomFacility($_POST);
            header('Location: ' . BASEURL . '/roomfacility');
            exit;
        }
    }

    public function delete($id)
    {
        $this->model('RoomFacility')->deleteRoomFacility($id);
        header('Location: ' . BASEURL . '/roomfacility');
        exit;
    }

    public function getubah()
    {
        echo json_encode($this->model('RoomFacility')->getRoomFacilityById($_POST['id']));
    }
}
