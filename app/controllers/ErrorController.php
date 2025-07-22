<?php
/**
 * Error Controller
 */
class ErrorController extends Controller {
    
    public function unauthorized() {
        http_response_code(403);
        
        $data = [
            'title' => 'Acceso No Autorizado'
        ];
        
        ob_start();
        $this->view('errors/unauthorized', $data);
        $content = ob_get_clean();
        
        $this->view('layouts/main', [
            'title' => $data['title'],
            'content' => $content
        ]);
    }
    
    public function notFound() {
        http_response_code(404);
        
        $data = [
            'title' => 'Página No Encontrada'
        ];
        
        ob_start();
        $this->view('errors/404', $data);
        $content = ob_get_clean();
        
        $this->view('layouts/main', [
            'title' => $data['title'],
            'content' => $content
        ]);
    }
}