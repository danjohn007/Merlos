<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="fas fa-tachometer-alt me-2 text-success"></i>
            Panel de Administración
        </h1>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card success position-relative">
            <div class="stat-number"><?php echo $requestStats['total']; ?></div>
            <div class="stat-label">Total Solicitudes</div>
            <i class="fas fa-clipboard-list stat-icon"></i>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card info position-relative">
            <div class="stat-number"><?php echo $requestStats['nuevos']; ?></div>
            <div class="stat-label">Solicitudes Nuevas</div>
            <i class="fas fa-star stat-icon"></i>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card warning position-relative">
            <div class="stat-number"><?php echo $requestStats['en_revision']; ?></div>
            <div class="stat-label">En Revisión</div>
            <i class="fas fa-eye stat-icon"></i>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card position-relative" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
            <div class="stat-number"><?php echo $requestStats['completados']; ?></div>
            <div class="stat-label">Completados</div>
            <i class="fas fa-check-circle stat-icon"></i>
        </div>
    </div>
</div>

<!-- User Statistics -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                <h4 class="mb-1"><?php echo $userStats['total']; ?></h4>
                <small class="text-muted">Total Usuarios</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-user-shield fa-2x text-success mb-2"></i>
                <h4 class="mb-1"><?php echo $userStats['supervisors']; ?></h4>
                <small class="text-muted">Supervisores</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-tools fa-2x text-info mb-2"></i>
                <h4 class="mb-1"><?php echo $userStats['technicians']; ?></h4>
                <small class="text-muted">Técnicos</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <i class="fas fa-user-friends fa-2x text-warning mb-2"></i>
                <h4 class="mb-1"><?php echo $userStats['clients']; ?></h4>
                <small class="text-muted">Clientes</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Requests -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Solicitudes Recientes
                </h5>
            </div>
            <div class="card-body">
                <?php if (empty($recentRequests)): ?>
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p class="mb-0">No hay solicitudes recientes</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Cliente</th>
                                    <th>Servicio</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentRequests as $request): ?>
                                    <tr>
                                        <td>
                                            <span class="fw-bold"><?php echo htmlspecialchars($request['folio']); ?></span>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-bold"><?php echo htmlspecialchars($request['client_name']); ?></div>
                                                <small class="text-muted"><?php echo htmlspecialchars($request['client_email']); ?></small>
                                            </div>
                                        </td>
                                        <td><?php echo htmlspecialchars($request['service_type']); ?></td>
                                        <td>
                                            <span class="badge status-badge status-<?php echo $request['status']; ?>">
                                                <?php echo $serviceRequestModel->getStatusName($request['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <small><?php echo date('d/m/Y H:i', strtotime($request['created_at'])); ?></small>
                                        </td>
                                        <td>
                                            <a href="/admin/requests/<?php echo $request['id']; ?>" 
                                               class="btn btn-sm btn-outline-success" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="/admin/requests" class="btn btn-outline-success">
                            <i class="fas fa-list me-2"></i>
                            Ver Todas las Solicitudes
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="/admin/requests" class="btn btn-outline-success">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Gestionar Solicitudes
                    </a>
                    
                    <a href="/admin/projects" class="btn btn-outline-info">
                        <i class="fas fa-project-diagram me-2"></i>
                        Gestionar Proyectos
                    </a>
                    
                    <a href="/admin/users" class="btn btn-outline-warning">
                        <i class="fas fa-users me-2"></i>
                        Gestionar Usuarios
                    </a>
                    
                    <a href="/admin/reports" class="btn btn-outline-secondary">
                        <i class="fas fa-chart-bar me-2"></i>
                        Ver Reportes
                    </a>
                </div>
            </div>
        </div>
        
        <!-- System Status -->
        <div class="card mt-4">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Estado del Sistema
                </h6>
            </div>
            <div class="card-body">
                <div class="small">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Versión:</span>
                        <span class="fw-bold"><?php echo APP_VERSION; ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Usuarios Activos:</span>
                        <span class="fw-bold text-success"><?php echo $userStats['active']; ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Última Actualización:</span>
                        <span class="fw-bold"><?php echo date('d/m/Y'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>