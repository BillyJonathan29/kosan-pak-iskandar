<?php

class HomeController extends Controller {
    
    public function index() {
        // 1. Siapkan data yang mau dikirim ke View (dan diteruskan ke Template)
        $data = [
            'title' => 'Dashboard Kosan',
            
            // Format breadcrumbs baru menyesuaikan template.php
            'breadcrumbs' => [
                [
                    'label' => 'Home', 
                    'url' => BASEURL
                ],
                [
                    'label' => 'Dashboard', 
                    'url' => '' // Kosongkan URL untuk halaman yang sedang aktif
                ]
            ],
            
            // (Opsional) Jika nanti di dashboard butuh script JS khusus atau modal
            // 'scripts' => '<script src="..."></script>',
            // 'modal' => '<div>...</div>'
        ];

        // 2. Panggil file view-nya secara langsung!
        // Ini akan memanggil file: views/dashboard/dashboard.php
        $this->view('dashboard/dashboard', $data);
    }
}