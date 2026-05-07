<?php

class ReviewController extends Controller
{
    public function index()
    {
        // Hanya admin yang bisa akses
        $this->requireRole('admin');

        $data = [
            'title' => 'Daftar Ulasan',
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => BASEURL],
                ['label' => 'Ulasan', 'url' => '']
            ],
            'reviews' => $this->model('Review')->getAllReviews()
        ];

        $this->view('reviews/index', $data);
    }

    public function my()
    {
        // Untuk user melihat ulasan mereka sendiri
        $this->requireLogin();

        $data = [
            'title' => 'Ulasan Saya',
            'reviews' => $this->model('Review')->getReviewsByUserId($_SESSION['user']['id'])
        ];

        $this->view('reviews/my', $data);
    }

    public function delete($id)
    {
        // Hanya admin yang bisa akses
        $this->requireRole('admin');

        if ($this->model('Review')->deleteReview($id)) {
            // Flash message can be added here if implemented
            header('Location: ' . BASEURL . '/review');
            exit;
        }
    }

    public function store()
    {
        // Digunakan oleh user untuk mengirim ulasan
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => $_SESSION['user']['id'],
                'room_id' => $_POST['room_id'],
                'rating' => $_POST['rating'],
                'comment' => $_POST['comment']
            ];

            if ($this->model('Review')->addReview($data)) {
                $_SESSION['flash'] = [
                    'pesan' => 'Terima kasih! Ulasan Anda telah berhasil dikirim.',
                    'tipe' => 'success'
                ];
                header('Location: ' . BASEURL . '/booking');
                exit;
            }
        }
    }
}
