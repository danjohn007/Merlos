<?php
/**
 * Database connection class
 */
class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            $this->connection = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            // In demo mode, create a mock connection
            $this->connection = null;
            define('DEMO_MODE', true);
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        if (defined('DEMO_MODE') && DEMO_MODE) {
            // Return mock statement for demo mode
            return new MockStatement();
        }
        
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Query failed: " . $e->getMessage());
        }
    }
    
    public function fetch($sql, $params = []) {
        if (defined('DEMO_MODE') && DEMO_MODE) {
            return $this->getMockData($sql);
        }
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }
    
    public function fetchAll($sql, $params = []) {
        if (defined('DEMO_MODE') && DEMO_MODE) {
            return $this->getMockDataArray($sql);
        }
        
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    public function insert($table, $data) {
        if (defined('DEMO_MODE') && DEMO_MODE) {
            return rand(1, 1000); // Mock ID
        }
        
        $fields = array_keys($data);
        $values = array_values($data);
        $placeholders = str_repeat('?,', count($fields) - 1) . '?';
        
        $sql = "INSERT INTO {$table} (" . implode(',', $fields) . ") VALUES ({$placeholders})";
        $this->query($sql, $values);
        
        return $this->connection->lastInsertId();
    }
    
    public function update($table, $data, $where, $whereParams = []) {
        if (defined('DEMO_MODE') && DEMO_MODE) {
            return true; // Mock success
        }
        
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            $fields[] = "{$key} = ?";
            $values[] = $value;
        }
        
        $sql = "UPDATE {$table} SET " . implode(',', $fields) . " WHERE {$where}";
        $this->query($sql, array_merge($values, $whereParams));
        
        return true;
    }
    
    public function delete($table, $where, $whereParams = []) {
        if (defined('DEMO_MODE') && DEMO_MODE) {
            return true; // Mock success
        }
        
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $this->query($sql, $whereParams);
        
        return true;
    }
    
    private function getMockData($sql) {
        // Return mock data based on SQL query patterns
        if (strpos($sql, 'service_types') !== false) {
            return [
                'id' => 1,
                'name' => 'Poda',
                'description' => 'Servicio de poda de árboles y arbustos',
                'is_active' => 1
            ];
        }
        
        if (strpos($sql, 'users') !== false && strpos($sql, 'email') !== false) {
            return [
                'id' => 1,
                'name' => 'Administrador Demo',
                'email' => 'admin@landscapemanager.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role' => ROLE_ADMIN,
                'is_active' => 1
            ];
        }
        
        return [];
    }
    
    private function getMockDataArray($sql) {
        // Return mock data arrays based on SQL query patterns
        if (strpos($sql, 'service_types') !== false) {
            return [
                ['id' => 1, 'name' => 'Poda', 'description' => 'Servicio de poda de árboles y arbustos'],
                ['id' => 2, 'name' => 'Diseño de Jardín', 'description' => 'Diseño y planificación de espacios verdes'],
                ['id' => 3, 'name' => 'Instalación de Riego', 'description' => 'Instalación de sistemas de riego automático'],
                ['id' => 4, 'name' => 'Mantenimiento', 'description' => 'Mantenimiento general de jardines']
            ];
        }
        
        if (strpos($sql, 'service_requests') !== false) {
            return [
                [
                    'id' => 1,
                    'folio' => 'SR202411001',
                    'client_name' => 'Juan Pérez',
                    'client_email' => 'juan@ejemplo.com',
                    'client_phone' => '555-1234',
                    'service_type' => 'Poda',
                    'status' => 'nuevo',
                    'created_at' => date('Y-m-d H:i:s'),
                    'assigned_name' => null
                ]
            ];
        }
        
        return [];
    }
}

class MockStatement {
    public function fetch() {
        return false;
    }
    
    public function fetchAll() {
        return [];
    }
}