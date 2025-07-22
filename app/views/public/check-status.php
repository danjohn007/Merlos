<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">
                    <i class="fas fa-search me-2"></i>
                    Consultar Estado de Solicitud
                </h4>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">
                    Ingrese su número de folio y correo electrónico para consultar 
                    el estado actual de su solicitud de servicio.
                </p>
                
                <form action="/check-status" method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                    
                    <div class="mb-3">
                        <label for="folio" class="form-label">Número de Folio *</label>
                        <input type="text" class="form-control" id="folio" name="folio" required 
                               placeholder="Ej: SR202411001" style="text-transform: uppercase;">
                        <div class="invalid-feedback">
                            Por favor ingrese el número de folio.
                        </div>
                        <small class="form-text text-muted">
                            El folio fue proporcionado cuando envió su solicitud.
                        </small>
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="form-label">Correo Electrónico *</label>
                        <input type="email" class="form-control" id="email" name="email" required 
                               placeholder="correo@ejemplo.com">
                        <div class="invalid-feedback">
                            Por favor ingrese un correo electrónico válido.
                        </div>
                        <small class="form-text text-muted">
                            Use el mismo correo que proporcionó en su solicitud.
                        </small>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-info btn-lg">
                            <i class="fas fa-search me-2"></i>
                            Consultar Estado
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Help Section -->
        <div class="card mt-4 border-warning">
            <div class="card-body">
                <h5 class="card-title text-warning">
                    <i class="fas fa-question-circle me-2"></i>
                    ¿Necesita Ayuda?
                </h5>
                <div class="mb-3">
                    <strong>¿No encuentra su folio?</strong>
                    <p class="mb-2 text-muted">
                        El número de folio se genera automáticamente cuando envía su solicitud. 
                        Revise su correo electrónico o el mensaje de confirmación.
                    </p>
                </div>
                
                <div class="mb-3">
                    <strong>¿Problemas para acceder?</strong>
                    <p class="mb-2 text-muted">
                        Asegúrese de usar exactamente el mismo correo electrónico que utilizó 
                        al enviar la solicitud.
                    </p>
                </div>
                
                <div class="text-center">
                    <a href="/service-request" class="btn btn-outline-success me-2">
                        <i class="fas fa-plus me-1"></i>
                        Nueva Solicitud
                    </a>
                    <a href="mailto:info@landscapemanager.com" class="btn btn-outline-warning">
                        <i class="fas fa-envelope me-1"></i>
                        Contactar Soporte
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Convert folio to uppercase as user types
    const folioInput = document.getElementById('folio');
    folioInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
});
</script>