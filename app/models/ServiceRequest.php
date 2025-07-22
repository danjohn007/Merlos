<?php
/**
 * Service Request Model
 */
class ServiceRequest extends Model {
    protected $table = 'service_requests';
    
    public function create($data) {
        // Generate unique folio
        $data['folio'] = $this->generateFolio();
        
        return parent::create($data);
    }
    
    private function generateFolio() {
        $prefix = 'SR';
        $year = date('Y');
        $month = date('m');
        
        // Get last number for this month
        $sql = "SELECT folio FROM {$this->table} WHERE folio LIKE ? ORDER BY id DESC LIMIT 1";
        $pattern = $prefix . $year . $month . '%';
        $lastRecord = $this->db->fetch($sql, [$pattern]);
        
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord['folio'], -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
    
    public function findByFolio($folio) {
        $sql = "SELECT sr.*, u.name as assigned_name 
                FROM {$this->table} sr
                LEFT JOIN users u ON sr.assigned_to = u.id
                WHERE sr.folio = ?";
        return $this->db->fetch($sql, [$folio]);
    }
    
    public function findWithAssignee($id) {
        $sql = "SELECT sr.*, u.name as assigned_name, u.email as assigned_email
                FROM {$this->table} sr
                LEFT JOIN users u ON sr.assigned_to = u.id
                WHERE sr.id = ?";
        return $this->db->fetch($sql, [$id]);
    }
    
    public function findAllWithAssignee($conditions = [], $orderBy = 'sr.id DESC', $limit = null) {
        $sql = "SELECT sr.*, u.name as assigned_name
                FROM {$this->table} sr
                LEFT JOIN users u ON sr.assigned_to = u.id";
        
        $params = [];
        
        if (!empty($conditions)) {
            $whereClause = [];
            foreach ($conditions as $field => $value) {
                $whereClause[] = "sr.{$field} = ?";
                $params[] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $whereClause);
        }
        
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->fetchAll($sql, $params);
    }
    
    public function getStats() {
        if (defined('DEMO_MODE') && DEMO_MODE) {
            return [
                'total' => 5,
                'nuevos' => 2,
                'en_revision' => 1,
                'aprobados' => 1,
                'rechazados' => 0,
                'en_proceso' => 1,
                'completados' => 0
            ];
        }
        
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as nuevos,
                    SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as en_revision,
                    SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as aprobados,
                    SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as rechazados,
                    SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as en_proceso,
                    SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as completados
                FROM {$this->table}";
        
        return $this->db->fetch($sql, [
            STATUS_NEW, STATUS_REVIEWING, STATUS_APPROVED, 
            STATUS_REJECTED, STATUS_IN_PROGRESS, STATUS_COMPLETED
        ]);
    }
    
    public function getStatusName($status) {
        $statuses = [
            STATUS_NEW => 'Nuevo',
            STATUS_REVIEWING => 'En Revisión',
            STATUS_APPROVED => 'Aprobado',
            STATUS_REJECTED => 'Rechazado',
            STATUS_IN_PROGRESS => 'En Proceso',
            STATUS_COMPLETED => 'Completado',
            STATUS_CANCELLED => 'Cancelado'
        ];
        
        return $statuses[$status] ?? 'Desconocido';
    }
    
    public function getServiceTypes() {
        $sql = "SELECT * FROM service_types WHERE is_active = 1 ORDER BY name";
        return $this->db->fetchAll($sql);
    }
    
    public function addAttachment($requestId, $fileData) {
        $sql = "INSERT INTO request_attachments (request_id, filename, original_name, file_path, file_size, mime_type) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        return $this->db->query($sql, [
            $requestId,
            $fileData['filename'],
            $fileData['original_name'],
            $fileData['file_path'],
            $fileData['file_size'],
            $fileData['mime_type']
        ]);
    }
    
    public function getAttachments($requestId) {
        $sql = "SELECT * FROM request_attachments WHERE request_id = ? ORDER BY created_at DESC";
        return $this->db->fetchAll($sql, [$requestId]);
    }
}