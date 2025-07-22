<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">
                    <i class="fas fa-plus-circle me-2"></i>
                    Solicitar Servicio de Jardinería
                </h4>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    Complete el siguiente formulario para solicitar nuestros servicios. 
                    Nos pondremos en contacto con usted a la brevedad.
                </p>
                
                <form action="/service-request" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                    
                    <!-- Client Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-success border-bottom pb-2 mb-3">
                                <i class="fas fa-user me-2"></i>
                                Información del Cliente
                            </h5>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="client_name" class="form-label">Nombre Completo *</label>
                            <input type="text" class="form-control" id="client_name" name="client_name" required>
                            <div class="invalid-feedback">
                                Por favor ingrese su nombre completo.
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="client_email" class="form-label">Correo Electrónico *</label>
                            <input type="email" class="form-control" id="client_email" name="client_email" required>
                            <div class="invalid-feedback">
                                Por favor ingrese un correo electrónico válido.
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="client_phone" class="form-label">Teléfono *</label>
                            <input type="tel" class="form-control" id="client_phone" name="client_phone" required>
                            <div class="invalid-feedback">
                                Por favor ingrese su número de teléfono.
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="service_address" class="form-label">Dirección del Servicio *</label>
                            <textarea class="form-control" id="service_address" name="service_address" rows="2" required placeholder="Dirección completa donde se realizará el servicio"></textarea>
                            <div class="invalid-feedback">
                                Por favor ingrese la dirección del servicio.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Service Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-success border-bottom pb-2 mb-3">
                                <i class="fas fa-tools me-2"></i>
                                Información del Servicio
                            </h5>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="service_type" class="form-label">Tipo de Servicio *</label>
                            <select class="form-select" id="service_type" name="service_type" required>
                                <option value="">Seleccione un servicio</option>
                                <?php foreach ($serviceTypes as $service): ?>
                                    <option value="<?php echo htmlspecialchars($service['name']); ?>">
                                        <?php echo htmlspecialchars($service['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Por favor seleccione el tipo de servicio.
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="preferred_date" class="form-label">Fecha Preferida</label>
                            <input type="date" class="form-control" id="preferred_date" name="preferred_date" min="<?php echo date('Y-m-d'); ?>">
                            <small class="form-text text-muted">Fecha tentativa, sujeta a disponibilidad</small>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">Descripción del Trabajo *</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required placeholder="Describa detalladamente el trabajo que necesita realizar..."></textarea>
                            <div class="invalid-feedback">
                                Por favor describa el trabajo que necesita.
                            </div>
                        </div>
                    </div>
                    
                    <!-- File Upload -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-success border-bottom pb-2 mb-3">
                                <i class="fas fa-paperclip me-2"></i>
                                Imágenes de Referencia (Opcional)
                            </h5>
                        </div>
                        
                        <div class="col-12">
                            <div class="file-upload-area">
                                <input type="file" name="attachments[]" multiple accept="image/*,.pdf" class="d-none" id="attachments">
                                <div class="upload-label">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <p class="mb-2">Arrastra archivos aquí o <strong>haz clic para seleccionar</strong></p>
                                    <small class="text-muted">
                                        Formatos permitidos: JPG, PNG, PDF. Máximo 5MB por archivo.
                                    </small>
                                </div>
                                <div class="file-preview mt-3"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="fas fa-paper-plane me-2"></i>
                                Enviar Solicitud
                            </button>
                            <div class="mt-3">
                                <small class="text-muted">
                                    Al enviar esta solicitud, acepta nuestros términos y condiciones de servicio.
                                </small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Information Card -->
        <div class="card mt-4 border-info">
            <div class="card-body">
                <h5 class="card-title text-info">
                    <i class="fas fa-info-circle me-2"></i>
                    ¿Qué sucede después?
                </h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <span class="badge bg-info rounded-circle" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">1</span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Recibimos tu solicitud</h6>
                                <small class="text-muted">Te asignaremos un número de folio único</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <span class="badge bg-info rounded-circle" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">2</span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Revisión y contacto</h6>
                                <small class="text-muted">Te contactaremos en 24-48 horas</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <span class="badge bg-info rounded-circle" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">3</span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Cotización y servicio</h6>
                                <small class="text-muted">Recibirás cotización y programación</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>