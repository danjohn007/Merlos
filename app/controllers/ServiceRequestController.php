<?php
/**
 * Service Request Controller
 */
class ServiceRequestController extends Controller {
    
    public function create() {
        $serviceRequestModel = $this->model('ServiceRequest');
        
        $data = [
            'title' => 'Solicitar Servicio',
            'serviceTypes' => $serviceRequestModel->getServiceTypes(),
            'csrf_token' => $this->generateCSRF()
        ];
        
        ob_start();
        $this->view('public/service-request', $data);
        $content = ob_get_clean();
        
        $this->view('layouts/main', [
            'title' => $data['title'],
            'content' => $content
        ]);
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/service-request');
        }
        
        $csrf_token = $_POST['csrf_token'] ?? '';
        
        // Validate CSRF token
        if (!$this->validateCSRF($csrf_token)) {
            $_SESSION['flash_message'] = 'Token de seguridad inválido';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/service-request');
        }
        
        // Get form data
        $data = [
            'client_name' => $_POST['client_name'] ?? '',
            'client_email' => $_POST['client_email'] ?? '',
            'client_phone' => $_POST['client_phone'] ?? '',
            'service_address' => $_POST['service_address'] ?? '',
            'service_type' => $_POST['service_type'] ?? '',
            'description' => $_POST['description'] ?? '',
            'preferred_date' => $_POST['preferred_date'] ?? null
        ];
        
        // Validate required fields
        $required = ['client_name', 'client_email', 'client_phone', 'service_address', 'service_type', 'description'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $_SESSION['flash_message'] = 'Todos los campos obligatorios deben completarse';
                $_SESSION['flash_type'] = 'danger';
                $this->redirect('/service-request');
            }
        }
        
        // Validate email format
        if (!filter_var($data['client_email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_message'] = 'Formato de email inválido';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/service-request');
        }
        
        // Format date
        if (!empty($data['preferred_date'])) {
            $data['preferred_date'] = date('Y-m-d', strtotime($data['preferred_date']));
        } else {
            $data['preferred_date'] = null;
        }
        
        // Create service request
        $serviceRequestModel = $this->model('ServiceRequest');
        $requestId = $serviceRequestModel->create($data);
        
        if ($requestId) {
            // Handle file uploads
            if (isset($_FILES['attachments']) && !empty($_FILES['attachments']['name'][0])) {
                $this->handleFileUploads($requestId, $_FILES['attachments']);
            }
            
            // Get the created request to show folio
            $request = $serviceRequestModel->find($requestId);
            
            $_SESSION['flash_message'] = "Solicitud creada exitosamente. Su número de folio es: {$request['folio']}";
            $_SESSION['flash_type'] = 'success';
            
            // Send notification email (implement later)
            // $this->sendNotificationEmail($request);
            
            $this->redirect('/check-status');
        } else {
            $_SESSION['flash_message'] = 'Error al crear la solicitud';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/service-request');
        }
    }
    
    public function checkStatus() {
        $data = [
            'title' => 'Consultar Estado de Solicitud',
            'csrf_token' => $this->generateCSRF()
        ];
        
        ob_start();
        $this->view('public/check-status', $data);
        $content = ob_get_clean();
        
        $this->view('layouts/main', [
            'title' => $data['title'],
            'content' => $content
        ]);
    }
    
    public function status() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/check-status');
        }
        
        $folio = $_POST['folio'] ?? '';
        $email = $_POST['email'] ?? '';
        $csrf_token = $_POST['csrf_token'] ?? '';
        
        // Validate CSRF token
        if (!$this->validateCSRF($csrf_token)) {
            $_SESSION['flash_message'] = 'Token de seguridad inválido';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/check-status');
        }
        
        if (empty($folio) || empty($email)) {
            $_SESSION['flash_message'] = 'Folio y email son requeridos';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/check-status');
        }
        
        $serviceRequestModel = $this->model('ServiceRequest');
        $request = $serviceRequestModel->findByFolio($folio);
        
        if (!$request) {
            $_SESSION['flash_message'] = 'Folio no encontrado';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/check-status');
        }
        
        if (strtolower($request['client_email']) !== strtolower($email)) {
            $_SESSION['flash_message'] = 'El email no coincide con el folio';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/check-status');
        }
        
        // Show request status
        $data = [
            'title' => 'Estado de Solicitud - ' . $request['folio'],
            'request' => $request,
            'statusName' => $serviceRequestModel->getStatusName($request['status']),
            'attachments' => $serviceRequestModel->getAttachments($request['id'])
        ];
        
        ob_start();
        $this->view('public/request-status', $data);
        $content = ob_get_clean();
        
        $this->view('layouts/main', [
            'title' => $data['title'],
            'content' => $content
        ]);
    }
    
    private function handleFileUploads($requestId, $files) {
        $uploadPath = UPLOAD_PATH . 'requests/';
        
        // Create directory if it doesn't exist
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        $fileCount = count($files['name']);
        
        for ($i = 0; $i < $fileCount; $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $originalName = $files['name'][$i];
                $tempName = $files['tmp_name'][$i];
                $fileSize = $files['size'][$i];
                $mimeType = $files['type'][$i];
                
                // Validate file
                if ($fileSize > MAX_FILE_SIZE) {
                    continue; // Skip large files
                }
                
                $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                if (!in_array($extension, ALLOWED_EXTENSIONS)) {
                    continue; // Skip invalid extensions
                }
                
                // Generate unique filename
                $filename = uniqid() . '_' . time() . '.' . $extension;
                $filePath = $uploadPath . $filename;
                
                if (move_uploaded_file($tempName, $filePath)) {
                    // Save to database
                    $serviceRequestModel = $this->model('ServiceRequest');
                    $serviceRequestModel->addAttachment($requestId, [
                        'filename' => $filename,
                        'original_name' => $originalName,
                        'file_path' => $filePath,
                        'file_size' => $fileSize,
                        'mime_type' => $mimeType
                    ]);
                }
            }
        }
    }
}