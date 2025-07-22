<?php
/**
 * Routes configuration
 */

// Public routes
$router->add('/', 'HomeController', 'index', 'GET');
$router->add('/service-request', 'ServiceRequestController', 'create', 'GET');
$router->add('/service-request', 'ServiceRequestController', 'store', 'POST');
$router->add('/check-status', 'ServiceRequestController', 'checkStatus', 'GET');
$router->add('/check-status', 'ServiceRequestController', 'status', 'POST');

// Authentication routes
$router->add('/login', 'AuthController', 'login', 'GET');
$router->add('/login', 'AuthController', 'authenticate', 'POST');
$router->add('/logout', 'AuthController', 'logout', 'GET');
$router->add('/register', 'AuthController', 'register', 'GET');
$router->add('/register', 'AuthController', 'store', 'POST');

// Admin routes
$router->add('/admin', 'AdminController', 'dashboard', 'GET');
$router->add('/admin/requests', 'AdminController', 'requests', 'GET');
$router->add('/admin/requests/{id}', 'AdminController', 'viewRequest', 'GET');
$router->add('/admin/requests/{id}/assign', 'AdminController', 'assignRequest', 'POST');
$router->add('/admin/requests/{id}/status', 'AdminController', 'updateStatus', 'POST');
$router->add('/admin/projects', 'AdminController', 'projects', 'GET');
$router->add('/admin/projects/create', 'AdminController', 'createProject', 'GET');
$router->add('/admin/projects/create', 'AdminController', 'storeProject', 'POST');
$router->add('/admin/projects/{id}', 'AdminController', 'viewProject', 'GET');
$router->add('/admin/users', 'AdminController', 'users', 'GET');
$router->add('/admin/reports', 'AdminController', 'reports', 'GET');

// Supervisor routes
$router->add('/supervisor', 'SupervisorController', 'dashboard', 'GET');
$router->add('/supervisor/requests', 'SupervisorController', 'requests', 'GET');
$router->add('/supervisor/projects', 'SupervisorController', 'projects', 'GET');
$router->add('/supervisor/team', 'SupervisorController', 'team', 'GET');

// Technician routes
$router->add('/technician', 'TechnicianController', 'dashboard', 'GET');
$router->add('/technician/tasks', 'TechnicianController', 'tasks', 'GET');
$router->add('/technician/tasks/{id}', 'TechnicianController', 'viewTask', 'GET');
$router->add('/technician/tasks/{id}/update', 'TechnicianController', 'updateTask', 'POST');

// Client routes
$router->add('/client', 'ClientController', 'dashboard', 'GET');
$router->add('/client/requests', 'ClientController', 'requests', 'GET');
$router->add('/client/projects', 'ClientController', 'projects', 'GET');
$router->add('/client/new-request', 'ClientController', 'newRequest', 'GET');
$router->add('/client/new-request', 'ClientController', 'storeRequest', 'POST');

// API routes
$router->add('/api/upload', 'ApiController', 'upload', 'POST');
$router->add('/api/notifications', 'ApiController', 'notifications', 'GET');

// Error routes
$router->add('/unauthorized', 'ErrorController', 'unauthorized', 'GET');