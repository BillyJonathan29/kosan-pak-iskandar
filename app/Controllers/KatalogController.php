<?php

class KatalogController extends Controller {

    // ─── Guard: Hanya user yang login yang boleh akses ────────────────────────
    private function requireLogin() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
    }

    // ─── 1. Halaman Katalog Kamar ─────────────────────────────────────────────
    public function index() {
        $this->requireLogin();

        $data = [
            'title'       => 'Katalog Kamar',
            'breadcrumbs' => [
                ['label' => 'Home',    'url' => BASEURL],
                ['label' => 'Katalog', 'url' => '']
            ],
            // Hanya kamar berstatus 'available'
            'rooms' => $this->model('Katalog')->getAvailableRooms(),
        ];

        $this->view('katalog/index', $data);
    }

    // ─── 2. Halaman Detail Kamar ──────────────────────────────────────────────
    public function detail($id) {
        $this->requireLogin();

        $room = $this->model('Katalog')->getRoomDetail($id);

        // Kamar tidak ditemukan atau sudah tidak tersedia
        if (!$room) {
            header('Location: ' . BASEURL . '/katalog');
            exit;
        }

        $data = [
            'title'       => 'Detail Kamar ' . $room['room_number'],
            'breadcrumbs' => [
                ['label' => 'Home',    'url' => BASEURL],
                ['label' => 'Katalog', 'url' => BASEURL . '/katalog'],
                ['label' => 'Detail',  'url' => '']
            ],
            'room'       => $room,
            'facilities' => $this->model('Katalog')->getRoomFacilities($id),
        ];

        $this->view('katalog/detail', $data);
    }

    // ─── 3. Proses Booking ────────────────────────────────────────────────────
    public function booking() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/katalog');
            exit;
        }

        $room_id  = (int) ($_POST['room_id']  ?? 0);
        $duration = (int) ($_POST['duration'] ?? 1);

        // Ambil data kamar untuk hitung total harga
        $room = $this->model('Katalog')->getRoomDetail($room_id);

        if (!$room || $room['status'] !== 'available') {
            // Kamar tidak tersedia lagi
            header('Location: ' . BASEURL . '/katalog');
            exit;
        }

        // Hitung total harga
        $total_price = $room['price'] * $duration;

        $bookingData = [
            'user_id'      => $_SESSION['user']['id'],
            'room_id'      => $room_id,
            'booking_date' => date('Y-m-d'),
            'duration'     => $duration,
            'total_price'  => $total_price,
        ];

        $katalogModel = $this->model('Katalog');

        // INSERT ke tabel bookings
        if ($katalogModel->createBooking($bookingData)) {
            // UPDATE status kamar menjadi 'booked'
            $katalogModel->updateRoomStatusBooked($room_id);

            // Redirect ke riwayat pesanan
            header('Location: ' . BASEURL . '/katalog/riwayat');
            exit;
        }

        // Jika gagal, kembali ke detail
        header('Location: ' . BASEURL . '/katalog/detail/' . $room_id);
        exit;
    }

    // ─── 4. Riwayat Pesanan User ──────────────────────────────────────────────
    public function riwayat() {
        $this->requireLogin();

        $user_id = $_SESSION['user']['id'];

        $data = [
            'title'       => 'Riwayat Pesanan',
            'breadcrumbs' => [
                ['label' => 'Home',     'url' => BASEURL],
                ['label' => 'Pesanan',  'url' => '']
            ],
            'bookings' => $this->model('Katalog')->getUserBookings($user_id),
        ];

        $this->view('katalog/riwayat', $data);
    }
}
