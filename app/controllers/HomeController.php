<?php
/**
 * Home Controller
 */
class HomeController extends Controller {
    
    public function index() {
        $data = [
            'title' => 'Inicio',
            'serviceRequestModel' => $this->model('ServiceRequest')
        ];
        
        // Get service types for the home page
        $serviceRequestModel = $data['serviceRequestModel'];
        $data['serviceTypes'] = $serviceRequestModel->getServiceTypes();
        
        ob_start();
        $this->view('public/home', $data);
        $content = ob_get_clean();
        
        $this->view('layouts/main', [
            'title' => $data['title'],
            'content' => $content
        ]);
    }
}