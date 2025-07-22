<?php
/**
 * Admin Controller
 */
class AdminController extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->requireRole(ROLE_ADMIN);
    }
    
    public function dashboard() {
        $userModel = $this->model('User');
        $serviceRequestModel = $this->model('ServiceRequest');
        
        // Get statistics
        $userStats = $userModel->getStats();
        $requestStats = $serviceRequestModel->getStats();
        
        // Get recent requests
        $recentRequests = $serviceRequestModel->findAllWithAssignee([], 'sr.id DESC', 5);
        
        $data = [
            'title' => 'Panel de Administración',
            'userStats' => $userStats,
            'requestStats' => $requestStats,
            'recentRequests' => $recentRequests,
            'serviceRequestModel' => $serviceRequestModel
        ];
        
        ob_start();
        $this->view('admin/dashboard', $data);
        $content = ob_get_clean();
        
        $this->view('layouts/main', [
            'title' => $data['title'],
            'content' => $content
        ]);
    }
    
    public function requests() {
        $serviceRequestModel = $this->model('ServiceRequest');
        $userModel = $this->model('User');
        
        // Get filters
        $status = $_GET['status'] ?? '';
        $assignedTo = $_GET['assigned_to'] ?? '';
        
        // Build conditions
        $conditions = [];
        if (!empty($status)) {
            $conditions['status'] = $status;
        }
        if (!empty($assignedTo)) {
            $conditions['assigned_to'] = $assignedTo;
        }
        
        // Get requests
        $requests = $serviceRequestModel->findAllWithAssignee($conditions);
        
        // Get users for assignment dropdown
        $supervisors = $userModel->getSupervisors();
        $technicians = $userModel->getTechnicians();
        
        $data = [
            'title' => 'Gestión de Solicitudes',
            'requests' => $requests,
            'supervisors' => $supervisors,
            'technicians' => $technicians,
            'serviceRequestModel' => $serviceRequestModel,
            'currentStatus' => $status,
            'currentAssignedTo' => $assignedTo
        ];
        
        ob_start();
        $this->view('admin/requests', $data);
        $content = ob_get_clean();
        
        $this->view('layouts/main', [
            'title' => $data['title'],
            'content' => $content
        ]);
    }
    
    public function viewRequest($id) {
        $serviceRequestModel = $this->model('ServiceRequest');
        $userModel = $this->model('User');
        
        $request = $serviceRequestModel->findWithAssignee($id);
        if (!$request) {
            $_SESSION['flash_message'] = 'Solicitud no encontrada';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/admin/requests');
        }
        
        $attachments = $serviceRequestModel->getAttachments($id);
        $supervisors = $userModel->getSupervisors();
        $technicians = $userModel->getTechnicians();
        
        $data = [
            'title' => 'Solicitud ' . $request['folio'],
            'request' => $request,
            'attachments' => $attachments,
            'supervisors' => $supervisors,
            'technicians' => $technicians,
            'serviceRequestModel' => $serviceRequestModel,
            'csrf_token' => $this->generateCSRF()
        ];
        
        ob_start();
        $this->view('admin/view-request', $data);
        $content = ob_get_clean();
        
        $this->view('layouts/main', [
            'title' => $data['title'],
            'content' => $content
        ]);
    }
    
    public function assignRequest($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/requests/' . $id);
        }
        
        $csrf_token = $_POST['csrf_token'] ?? '';
        if (!$this->validateCSRF($csrf_token)) {
            $_SESSION['flash_message'] = 'Token de seguridad inválido';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/admin/requests/' . $id);
        }
        
        $assignedTo = $_POST['assigned_to'] ?? '';
        $internalNotes = $_POST['internal_notes'] ?? '';
        
        if (empty($assignedTo)) {
            $_SESSION['flash_message'] = 'Debe seleccionar un usuario para asignar';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/admin/requests/' . $id);
        }
        
        $serviceRequestModel = $this->model('ServiceRequest');
        $updateData = [
            'assigned_to' => $assignedTo,
            'status' => STATUS_REVIEWING
        ];
        
        if (!empty($internalNotes)) {
            $updateData['internal_notes'] = $internalNotes;
        }
        
        if ($serviceRequestModel->update($id, $updateData)) {
            $_SESSION['flash_message'] = 'Solicitud asignada correctamente';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Error al asignar la solicitud';
            $_SESSION['flash_type'] = 'danger';
        }
        
        $this->redirect('/admin/requests/' . $id);
    }
    
    public function updateStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/requests/' . $id);
        }
        
        $csrf_token = $_POST['csrf_token'] ?? '';
        if (!$this->validateCSRF($csrf_token)) {
            $_SESSION['flash_message'] = 'Token de seguridad inválido';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/admin/requests/' . $id);
        }
        
        $status = $_POST['status'] ?? '';
        $internalNotes = $_POST['internal_notes'] ?? '';
        
        if (empty($status)) {
            $_SESSION['flash_message'] = 'Debe seleccionar un estado';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/admin/requests/' . $id);
        }
        
        $serviceRequestModel = $this->model('ServiceRequest');
        $updateData = ['status' => $status];
        
        if (!empty($internalNotes)) {
            $updateData['internal_notes'] = $internalNotes;
        }
        
        if ($serviceRequestModel->update($id, $updateData)) {
            $_SESSION['flash_message'] = 'Estado actualizado correctamente';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Error al actualizar el estado';
            $_SESSION['flash_type'] = 'danger';
        }
        
        $this->redirect('/admin/requests/' . $id);
    }
    
    public function users() {
        $userModel = $this->model('User');
        $users = $userModel->findAll();
        
        $data = [
            'title' => 'Gestión de Usuarios',
            'users' => $users,
            'userModel' => $userModel
        ];
        
        ob_start();
        $this->view('admin/users', $data);
        $content = ob_get_clean();
        
        $this->view('layouts/main', [
            'title' => $data['title'],
            'content' => $content
        ]);
    }
    
    public function projects() {
        // TODO: Implement projects management
        $data = [
            'title' => 'Gestión de Proyectos'
        ];
        
        ob_start();
        echo '<div class="alert alert-info">Módulo de Proyectos en desarrollo...</div>';
        $content = ob_get_clean();
        
        $this->view('layouts/main', [
            'title' => $data['title'],
            'content' => $content
        ]);
    }
    
    public function reports() {
        // TODO: Implement reports
        $data = [
            'title' => 'Reportes'
        ];
        
        ob_start();
        echo '<div class="alert alert-info">Módulo de Reportes en desarrollo...</div>';
        $content = ob_get_clean();
        
        $this->view('layouts/main', [
            'title' => $data['title'],
            'content' => $content
        ]);
    }
}