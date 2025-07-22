<?php
/**
 * User Model
 */
class User extends Model {
    protected $table = 'users';
    
    public function create($data) {
        // Hash password before storing
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        return parent::create($data);
    }
    
    public function update($id, $data) {
        // Hash password if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        
        return parent::update($id, $data);
    }
    
    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? AND is_active = 1";
        return $this->db->fetch($sql, [$email]);
    }
    
    public function authenticate($email, $password) {
        $user = $this->findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    public function findByRole($role) {
        return $this->findAll(['role' => $role, 'is_active' => 1]);
    }
    
    public function getTechnicians() {
        return $this->findByRole(ROLE_TECHNICIAN);
    }
    
    public function getSupervisors() {
        return $this->findByRole(ROLE_SUPERVISOR);
    }
    
    public function getClients() {
        return $this->findByRole(ROLE_CLIENT);
    }
    
    public function getRoleName($role) {
        $roles = [
            ROLE_ADMIN => 'Administrador',
            ROLE_SUPERVISOR => 'Supervisor de Proyectos',
            ROLE_TECHNICIAN => 'Jardinero / Técnico',
            ROLE_CLIENT => 'Cliente'
        ];
        
        return $roles[$role] ?? 'Desconocido';
    }
    
    public function getStats() {
        if (defined('DEMO_MODE') && DEMO_MODE) {
            return [
                'total' => 15,
                'admins' => 1,
                'supervisors' => 3,
                'technicians' => 5,
                'clients' => 6,
                'active' => 14
            ];
        }
        
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN role = ? THEN 1 ELSE 0 END) as admins,
                    SUM(CASE WHEN role = ? THEN 1 ELSE 0 END) as supervisors,
                    SUM(CASE WHEN role = ? THEN 1 ELSE 0 END) as technicians,
                    SUM(CASE WHEN role = ? THEN 1 ELSE 0 END) as clients,
                    SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active
                FROM {$this->table}";
        
        return $this->db->fetch($sql, [ROLE_ADMIN, ROLE_SUPERVISOR, ROLE_TECHNICIAN, ROLE_CLIENT]);
    }
}