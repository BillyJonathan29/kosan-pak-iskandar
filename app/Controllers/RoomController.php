<?php

class RoomController extends Controller {
    
    public function __construct()
    {
        $this->requireRole('admin');
    }

    public function index() {
        $data = [
            'title' => 'Manajemen Kamar',
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => BASEURL],
                ['label' => 'Kamar', 'url' => '']
            ],
            'rooms' => $this->model('Room')->getAllRooms(),
            'kos' => $this->model('Kos')->getAllKos()
        ];

        $this->view('room/index', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;
            $data['image'] = $this->uploadImage();

            if ($this->model('Room')->addRoom($data)) {
                header('Location: ' . BASEURL . '/room');
                exit;
            } else {
                header('Location: ' . BASEURL . '/room');
                exit;
            }
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;
            $newImage = $this->uploadImage();

            if ($newImage) {
                // Jika ada gambar baru, hapus gambar lama
                if (!empty($data['old_image'])) {
                    $oldImagePath = '../public/assets/img/rooms/' . $data['old_image'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $data['image'] = $newImage;
            } else {
                $data['image'] = $data['old_image'];
            }

            if ($this->model('Room')->updateRoom($data)) {
                header('Location: ' . BASEURL . '/room');
                exit;
            } else {
                header('Location: ' . BASEURL . '/room');
                exit;
            }
        }
    }

    public function delete($id) {
        $room = $this->model('Room')->deleteRoom($id);
        if ($room) {
            // Hapus gambar jika ada
            if (!empty($room['image'])) {
                $imagePath = '../public/assets/img/rooms/' . $room['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            header('Location: ' . BASEURL . '/room');
            exit;
        } else {
            header('Location: ' . BASEURL . '/room');
            exit;
        }
    }

    public function getubah() {
        echo json_encode($this->model('Room')->getRoomById($_POST['id']));
    }

    private function uploadImage() {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $namaFile = $_FILES['image']['name'];
            $ukuranFile = $_FILES['image']['size'];
            $tmpName = $_FILES['image']['tmp_name'];

            // Cek ekstensi
            $ekstensiValid = ['jpg', 'jpeg', 'png'];
            $ekstensiFile = explode('.', $namaFile);
            $ekstensiFile = strtolower(end($ekstensiFile));

            if (!in_array($ekstensiFile, $ekstensiValid)) {
                return false;
            }

            // Cek ukuran (maks 2MB)
            if ($ukuranFile > 2000000) {
                return false;
            }

            // Generate nama baru
            $namaFileBaru = uniqid() . '.' . $ekstensiFile;

            // Upload
            move_uploaded_file($tmpName, '../public/assets/img/rooms/' . $namaFileBaru);

            return $namaFileBaru;
        }
        return false;
    }
}
