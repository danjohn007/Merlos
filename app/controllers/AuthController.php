<?php
/**
 * Authentication Controller
 */
class AuthController extends Controller {
    
    public function login() {
        // If already logged in, redirect to appropriate dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirectToDashboard($_SESSION['user_role']);
        }
        
        $data = [
            'title' => 'Iniciar Sesión',
            'csrf_token' => $this->generateCSRF()
        ];
        
        ob_start();
        $this->view('auth/login', $data);
        $content = ob_get_clean();
        
        $this->view('layouts/main', [
            'title' => $data['title'],
            'content' => $content
        ]);
    }
    
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
        }
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $csrf_token = $_POST['csrf_token'] ?? '';
        
        // Validate CSRF token
        if (!$this->validateCSRF($csrf_token)) {
            $_SESSION['flash_message'] = 'Token de seguridad inválido';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/login');
        }
        
        // Validate input
        if (empty($email) || empty($password)) {
            $_SESSION['flash_message'] = 'Email y contraseña son requeridos';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/login');
        }
        
        // Authenticate user
        $userModel = $this->model('User');
        $user = $userModel->authenticate($email, $password);
        
        if ($user) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            
            // Log activity
            $this->logActivity('login', 'user', $user['id'], 'Usuario inició sesión');
            
            $_SESSION['flash_message'] = 'Bienvenido, ' . $user['name'];
            $_SESSION['flash_type'] = 'success';
            
            $this->redirectToDashboard($user['role']);
        } else {
            $_SESSION['flash_message'] = 'Credenciales inválidas';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/login');
        }
    }
    
    public function register() {
        $data = [
            'title' => 'Registrarse',
            'csrf_token' => $this->generateCSRF()
        ];
        
        ob_start();
        $this->view('auth/register', $data);
        $content = ob_get_clean();
        
        $this->view('layouts/main', [
            'title' => $data['title'],
            'content' => $content
        ]);
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/register');
        }
        
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $csrf_token = $_POST['csrf_token'] ?? '';
        
        // Validate CSRF token
        if (!$this->validateCSRF($csrf_token)) {
            $_SESSION['flash_message'] = 'Token de seguridad inválido';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/register');
        }
        
        // Validate input
        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['flash_message'] = 'Todos los campos son requeridos';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/register');
        }
        
        if ($password !== $confirm_password) {
            $_SESSION['flash_message'] = 'Las contraseñas no coinciden';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/register');
        }
        
        if (strlen($password) < 6) {
            $_SESSION['flash_message'] = 'La contraseña debe tener al menos 6 caracteres';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/register');
        }
        
        // Check if email already exists
        $userModel = $this->model('User');
        if ($userModel->findByEmail($email)) {
            $_SESSION['flash_message'] = 'El email ya está registrado';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/register');
        }
        
        // Create user
        $userData = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
            'role' => ROLE_CLIENT // New users are clients by default
        ];
        
        $userId = $userModel->create($userData);
        
        if ($userId) {
            // Log activity
            $this->logActivity('register', 'user', $userId, 'Usuario se registró');
            
            $_SESSION['flash_message'] = 'Registro exitoso. Ahora puedes iniciar sesión.';
            $_SESSION['flash_type'] = 'success';
            $this->redirect('/login');
        } else {
            $_SESSION['flash_message'] = 'Error al crear la cuenta';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/register');
        }
    }
    
    public function logout() {
        // Log activity before destroying session
        if (isset($_SESSION['user_id'])) {
            $this->logActivity('logout', 'user', $_SESSION['user_id'], 'Usuario cerró sesión');
        }
        
        // Destroy session
        session_destroy();
        
        $_SESSION = [];
        session_start();
        
        $_SESSION['flash_message'] = 'Sesión cerrada correctamente';
        $_SESSION['flash_type'] = 'success';
        
        $this->redirect('/');
    }
    
    private function redirectToDashboard($role) {
        switch ($role) {
            case ROLE_ADMIN:
                $this->redirect('/admin');
                break;
            case ROLE_SUPERVISOR:
                $this->redirect('/supervisor');
                break;
            case ROLE_TECHNICIAN:
                $this->redirect('/technician');
                break;
            case ROLE_CLIENT:
                $this->redirect('/client');
                break;
            default:
                $this->redirect('/');
        }
    }
    
    private function logActivity($action, $entityType, $entityId, $description) {
        $sql = "INSERT INTO activity_log (user_id, action, entity_type, entity_id, description, ip_address, user_agent) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $_SESSION['user_id'] ?? null,
            $action,
            $entityType,
            $entityId,
            $description,
            $_SERVER['REMOTE_ADDR'] ?? '',
            $_SERVER['HTTP_USER_AGENT'] ?? ''
        ];
        
        $this->db->query($sql, $params);
    }
}