<?php
/**
 * Configuration file for Landscape Project Manager
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'landscape_manager');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Application configuration
define('APP_NAME', 'Landscape Project Manager');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost');

// Email configuration
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', '');
define('MAIL_PASSWORD', '');
define('MAIL_FROM', 'noreply@landscapemanager.com');
define('MAIL_FROM_NAME', 'Landscape Project Manager');

// File upload configuration
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads/');
define('MAX_FILE_SIZE', 5242880); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx']);

// Security configuration
define('JWT_SECRET', 'your-secret-key-here');
define('PASSWORD_SALT', 'landscape-salt-2024');

// User roles
define('ROLE_ADMIN', 1);
define('ROLE_SUPERVISOR', 2);
define('ROLE_TECHNICIAN', 3);
define('ROLE_CLIENT', 4);

// Request status
define('STATUS_NEW', 'nuevo');
define('STATUS_REVIEWING', 'en_revision');
define('STATUS_APPROVED', 'aprobado');
define('STATUS_REJECTED', 'rechazado');
define('STATUS_IN_PROGRESS', 'en_proceso');
define('STATUS_COMPLETED', 'completado');
define('STATUS_CANCELLED', 'cancelado');

// Project status
define('PROJECT_PLANNED', 'planeado');
define('PROJECT_IN_EXECUTION', 'en_ejecucion');
define('PROJECT_COMPLETED', 'terminado');
define('PROJECT_CANCELLED', 'cancelado');