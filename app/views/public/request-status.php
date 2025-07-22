<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">
                    <i class="fas fa-clipboard-check me-2"></i>
                    Estado de Solicitud - <?php echo htmlspecialchars($request['folio']); ?>
                </h4>
            </div>
            <div class="card-body">
                <!-- Status Alert -->
                <div class="alert alert-info mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle fa-2x me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">Estado Actual</h5>
                            <span class="badge status-badge status-<?php echo $request['status']; ?> fs-6">
                                <?php echo htmlspecialchars($statusName); ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Request Details -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="text-success border-bottom pb-2 mb-3">
                            <i class="fas fa-user me-2"></i>
                            Información del Cliente
                        </h5>
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Nombre:</td>
                                <td><?php echo htmlspecialchars($request['client_name']); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email:</td>
                                <td><?php echo htmlspecialchars($request['client_email']); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Teléfono:</td>
                                <td><?php echo htmlspecialchars($request['client_phone']); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Dirección:</td>
                                <td><?php echo htmlspecialchars($request['service_address']); ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h5 class="text-success border-bottom pb-2 mb-3">
                            <i class="fas fa-tools me-2"></i>
                            Detalles del Servicio
                        </h5>
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Tipo de Servicio:</td>
                                <td><?php echo htmlspecialchars($request['service_type']); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Fecha Preferida:</td>
                                <td>
                                    <?php if ($request['preferred_date']): ?>
                                        <?php echo date('d/m/Y', strtotime($request['preferred_date'])); ?>
                                    <?php else: ?>
                                        <span class="text-muted">No especificada</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Fecha de Solicitud:</td>
                                <td><?php echo date('d/m/Y H:i', strtotime($request['created_at'])); ?></td>
                            </tr>
                            <?php if (!empty($request['assigned_name'])): ?>
                            <tr>
                                <td class="fw-bold">Asignado a:</td>
                                <td><?php echo htmlspecialchars($request['assigned_name']); ?></td>
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
                
                <!-- Description -->
                <div class="mb-4">
                    <h5 class="text-success border-bottom pb-2 mb-3">
                        <i class="fas fa-file-alt me-2"></i>
                        Descripción del Trabajo
                    </h5>
                    <div class="bg-light p-3 rounded">
                        <?php echo nl2br(htmlspecialchars($request['description'])); ?>
                    </div>
                </div>
                
                <!-- Attachments -->
                <?php if (!empty($attachments)): ?>
                <div class="mb-4">
                    <h5 class="text-success border-bottom pb-2 mb-3">
                        <i class="fas fa-paperclip me-2"></i>
                        Archivos Adjuntos
                    </h5>
                    <div class="row">
                        <?php foreach ($attachments as $attachment): ?>
                            <div class="col-md-6 mb-2">
                                <div class="card border-0 bg-light">
                                    <div class="card-body py-2">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file me-2 text-muted"></i>
                                            <div>
                                                <div class="fw-bold"><?php echo htmlspecialchars($attachment['original_name']); ?></div>
                                                <small class="text-muted">
                                                    <?php echo number_format($attachment['file_size'] / 1024, 1); ?> KB
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Internal Notes (if any) -->
                <?php if (!empty($request['internal_notes'])): ?>
                <div class="mb-4">
                    <h5 class="text-success border-bottom pb-2 mb-3">
                        <i class="fas fa-sticky-note me-2"></i>
                        Comentarios del Equipo
                    </h5>
                    <div class="alert alert-secondary">
                        <?php echo nl2br(htmlspecialchars($request['internal_notes'])); ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Status Timeline -->
                <div class="mb-4">
                    <h5 class="text-success border-bottom pb-2 mb-3">
                        <i class="fas fa-timeline me-2"></i>
                        Progreso de la Solicitud
                    </h5>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <h6 class="mb-1">Solicitud Recibida</h6>
                                <small class="text-muted">
                                    <?php echo date('d/m/Y H:i', strtotime($request['created_at'])); ?>
                                </small>
                                <p class="mb-0 mt-1">Su solicitud ha sido registrada con el folio <?php echo $request['folio']; ?></p>
                            </div>
                        </div>
                        
                        <?php if ($request['status'] !== STATUS_NEW): ?>
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <h6 class="mb-1">En Revisión</h6>
                                <small class="text-muted">
                                    <?php echo date('d/m/Y H:i', strtotime($request['updated_at'])); ?>
                                </small>
                                <p class="mb-0 mt-1">Su solicitud está siendo evaluada por nuestro equipo</p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (in_array($request['status'], [STATUS_APPROVED, STATUS_IN_PROGRESS, STATUS_COMPLETED])): ?>
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <h6 class="mb-1">Solicitud Aprobada</h6>
                                <small class="text-muted">
                                    <?php echo date('d/m/Y H:i', strtotime($request['updated_at'])); ?>
                                </small>
                                <p class="mb-0 mt-1">Su solicitud ha sido aprobada y será programada</p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($request['status'] === STATUS_REJECTED): ?>
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <h6 class="mb-1 text-danger">Solicitud Rechazada</h6>
                                <small class="text-muted">
                                    <?php echo date('d/m/Y H:i', strtotime($request['updated_at'])); ?>
                                </small>
                                <p class="mb-0 mt-1">Lamentamos informar que su solicitud no pudo ser aprobada</p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="text-center">
                    <a href="/check-status" class="btn btn-outline-info me-2">
                        <i class="fas fa-arrow-left me-1"></i>
                        Consultar Otra Solicitud
                    </a>
                    <a href="/service-request" class="btn btn-outline-success">
                        <i class="fas fa-plus me-1"></i>
                        Nueva Solicitud
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>