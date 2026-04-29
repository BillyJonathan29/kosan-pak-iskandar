<?php

class HomeController extends Controller {

    public function index() {
        $roomModel     = $this->model('Room');
        $kosModel      = $this->model('Kos');
        $facilityModel = $this->model('Facility');
        $bookingModel  = $this->model('Booking');

        $data = [
            'title'       => 'Dashboard Kosan',
            'breadcrumbs' => [
                ['label' => 'Home',      'url' => BASEURL],
                ['label' => 'Dashboard', 'url' => '']
            ],

            // Stat cards
            'total_kos'        => $kosModel->countKos(),
            'total_kamar'      => $roomModel->countRooms(),
            'kamar_terisi'     => $roomModel->countByStatus('terisi'),
            'kamar_kosong'     => $roomModel->countByStatus('kosong'),
            'total_fasilitas'  => $facilityModel->countFacilities(),

            // Booking stats
            'total_booking'    => $bookingModel->countBookings(),
            'booking_pending'  => $bookingModel->countByStatus('pending'),
            'booking_confirmed'=> $bookingModel->countByStatus('confirmed'),

            // Tabel kamar terbaru
            'recent_rooms'     => $roomModel->getRecentRooms(5),
        ];

        $this->view('dashboard/dashboard', $data);
    }
}