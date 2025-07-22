<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' . APP_NAME : APP_NAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/public/css/style.css" rel="stylesheet">
    
    <?php if (isset($additionalCSS)): ?>
        <?php foreach ($additionalCSS as $css): ?>
            <link href="<?php echo $css; ?>" rel="stylesheet">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-leaf me-2"></i>
                <?php echo APP_NAME; ?>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/service-request">Solicitar Servicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/check-status">Consultar Estado</a>
                        </li>
                    <?php else: ?>
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
                        }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $dashboardUrl; ?>">Dashboard</a>
                        </li>
                        
                        <?php if ($userRole == ROLE_ADMIN): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    Administración
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/admin/requests">Solicitudes</a></li>
                                    <li><a class="dropdown-item" href="/admin/projects">Proyectos</a></li>
                                    <li><a class="dropdown-item" href="/admin/users">Usuarios</a></li>
                                    <li><a class="dropdown-item" href="/admin/reports">Reportes</a></li>
                                </ul>
                            </li>
                        <?php elseif ($userRole == ROLE_SUPERVISOR): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/supervisor/requests">Solicitudes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/supervisor/projects">Proyectos</a>
                            </li>
                        <?php elseif ($userRole == ROLE_TECHNICIAN): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/technician/tasks">Mis Tareas</a>
                            </li>
                        <?php elseif ($userRole == ROLE_CLIENT): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/client/requests">Mis Solicitudes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/client/projects">Mis Proyectos</a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/register">Registrarse</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>
                                <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/profile">Mi Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/logout">Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['flash_type'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_SESSION['flash_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php 
                unset($_SESSION['flash_message']);
                unset($_SESSION['flash_type']);
                ?>
            <?php endif; ?>
            
            <?php echo $content ?? ''; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase"><?php echo APP_NAME; ?></h5>
                    <p>
                        Sistema integral para la gestión de proyectos de jardinería y paisajismo.
                        Centralizamos solicitudes, proyectos y seguimiento en una sola plataforma.
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Enlaces</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="/service-request" class="text-decoration-none">Solicitar Servicio</a></li>
                        <li><a href="/check-status" class="text-decoration-none">Consultar Estado</a></li>
                        <li><a href="/login" class="text-decoration-none">Iniciar Sesión</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Contacto</h5>
                    <ul class="list-unstyled mb-0">
                        <li><i class="fas fa-envelope me-2"></i> info@landscapemanager.com</li>
                        <li><i class="fas fa-phone me-2"></i> (555) 123-4567</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i> Ciudad, País</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center p-3 bg-success text-white">
            © 2024 <?php echo APP_NAME; ?>. Todos los derechos reservados.
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom JS -->
    <script src="/public/js/app.js"></script>
    
    <?php if (isset($additionalJS)): ?>
        <?php foreach ($additionalJS as $js): ?>
            <script src="<?php echo $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>