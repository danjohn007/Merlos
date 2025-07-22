<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="text-center">
            <div class="mb-4">
                <i class="fas fa-ban fa-6x text-danger"></i>
            </div>
            <h1 class="display-4 text-danger mb-3">403</h1>
            <h2 class="mb-4">Acceso No Autorizado</h2>
            <p class="lead text-muted mb-4">
                Lo sentimos, no tiene permisos para acceder a esta página. 
                Su rol de usuario actual no permite el acceso a este recurso.
            </p>
            
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="/" class="btn btn-success">
                    <i class="fas fa-home me-2"></i>
                    Ir al Inicio
                </a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php 
                    $userRole = $_SESSION['user_role'];
                    $dashboardUrl = '';
                    switch($userRole) {
                        case ROLE_ADMIN:
                            $dashboardUrl = '/admin';
                            break;
                        case ROLE_SUPERVISOR:
                            $dashboardUrl = '/supervisor';
                            break;
                        case ROLE_TECHNICIAN:
                            $dashboardUrl = '/technician';
                            break;
                        case ROLE_CLIENT:
                            $dashboardUrl = '/client';
                            break;
                        default:
                            $dashboardUrl = '/';
                    }
                    ?>
                    <a href="<?php echo $dashboardUrl; ?>" class="btn btn-outline-success">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Mi Dashboard
                    </a>
                <?php else: ?>
                    <a href="/login" class="btn btn-outline-success">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Iniciar Sesión
                    </a>
                <?php endif; ?>
            </div>
            
            <div class="mt-5">
                <small class="text-muted">
                    Si cree que esto es un error, contacte al administrador del sistema.
                </small>
            </div>
        </div>
    </div>
</div>