<div class="row">
    <!-- Hero Section -->
    <div class="col-12 mb-5">
        <div class="jumbotron bg-success text-white p-5 rounded">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-leaf me-3"></i>
                        Landscape Project Manager
                    </h1>
                    <p class="lead mb-4">
                        Sistema integral para la gestión de proyectos de jardinería y paisajismo. 
                        Solicita servicios, consulta el estado de tus proyectos y accede a tu panel personalizado.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="/service-request" class="btn btn-light btn-lg">
                            <i class="fas fa-plus me-2"></i>
                            Solicitar Servicio
                        </a>
                        <a href="/check-status" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-search me-2"></i>
                            Consultar Estado
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fas fa-seedling" style="font-size: 8rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-5">
    <!-- Services Section -->
    <div class="col-12">
        <h2 class="text-center mb-4">
            <i class="fas fa-tools me-2 text-success"></i>
            Nuestros Servicios
        </h2>
        <div class="row">
            <?php if (!empty($serviceTypes)): ?>
                <?php foreach ($serviceTypes as $service): ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <?php
                                    $icons = [
                                        'Poda' => 'fas fa-cut',
                                        'Diseño de Jardín' => 'fas fa-drafting-compass',
                                        'Instalación de Riego' => 'fas fa-tint',
                                        'Mantenimiento' => 'fas fa-wrench',
                                        'Jardinería Decorativa' => 'fas fa-palette',
                                        'Fumigación' => 'fas fa-spray-can',
                                        'Limpieza de Terrenos' => 'fas fa-broom'
                                    ];
                                    $icon = $icons[$service['name']] ?? 'fas fa-leaf';
                                    ?>
                                    <i class="<?php echo $icon; ?> fa-3x text-success"></i>
                                </div>
                                <h5 class="card-title"><?php echo htmlspecialchars($service['name']); ?></h5>
                                <p class="card-text text-muted">
                                    <?php echo htmlspecialchars($service['description']); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No hay servicios disponibles en este momento.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row mb-5">
    <!-- Features Section -->
    <div class="col-12">
        <h2 class="text-center mb-4">
            <i class="fas fa-star me-2 text-success"></i>
            ¿Por qué elegirnos?
        </h2>
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-clock fa-3x text-success"></i>
                    </div>
                    <h5>Seguimiento en Tiempo Real</h5>
                    <p class="text-muted">
                        Consulta el estado de tu solicitud y proyecto en cualquier momento 
                        con nuestro sistema de seguimiento en línea.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-users fa-3x text-success"></i>
                    </div>
                    <h5>Equipo Profesional</h5>
                    <p class="text-muted">
                        Contamos con jardineros y técnicos especializados en diferentes 
                        áreas del paisajismo y mantenimiento de jardines.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-shield-alt fa-3x text-success"></i>
                    </div>
                    <h5>Calidad Garantizada</h5>
                    <p class="text-muted">
                        Todos nuestros proyectos incluyen garantía y seguimiento 
                        post-servicio para asegurar tu satisfacción.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- CTA Section -->
    <div class="col-12">
        <div class="card bg-light border-0">
            <div class="card-body text-center py-5">
                <h3 class="mb-3">¿Listo para transformar tu espacio verde?</h3>
                <p class="lead text-muted mb-4">
                    Inicia tu proyecto de jardinería hoy mismo. Es fácil, rápido y completamente gratuito.
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="/service-request" class="btn btn-success btn-lg">
                        <i class="fas fa-paper-plane me-2"></i>
                        Solicitar Servicio Ahora
                    </a>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="/register" class="btn btn-outline-success btn-lg">
                            <i class="fas fa-user-plus me-2"></i>
                            Crear Cuenta
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>