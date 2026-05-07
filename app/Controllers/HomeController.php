<?php

class HomeController extends Controller
{
    public function __construct()
    {
        $this->requireRole('admin');
    }

    public function index()
    {
        $roomModel     = $this->model('Room');
        $kosModel      = $this->model('Kos');
        $facilityModel = $this->model('Facility');
        $bookingModel  = $this->model('Booking');
        $paymentModel  = $this->model('Payment');

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
            'booking_confirmed' => $bookingModel->countByStatus('confirmed'),

            // Tabel kamar terbaru
            'recent_rooms'     => $roomModel->getRecentRooms(5),
            // Finance
            'revenue_this_month' => $paymentModel->getMonthlyRevenue(date('Y'), date('n')),
            'pending_bills_total' => $paymentModel->getPendingTotal(),
        ];

        $this->view('dashboard/dashboard', $data);
    }
}
