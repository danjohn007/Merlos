// Application JavaScript for Landscape Project Manager

document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // File upload handling
    initializeFileUpload();
    
    // Form validation
    initializeFormValidation();
    
    // AJAX forms
    initializeAjaxForms();
    
    // Auto-hide alerts
    autoHideAlerts();
});

// File upload functionality
function initializeFileUpload() {
    const uploadAreas = document.querySelectorAll('.file-upload-area');
    
    uploadAreas.forEach(area => {
        const input = area.querySelector('input[type="file"]');
        const label = area.querySelector('.upload-label');
        const preview = area.querySelector('.file-preview');
        
        // Drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            area.addEventListener(eventName, preventDefaults, false);
        });
        
        ['dragenter', 'dragover'].forEach(eventName => {
            area.addEventListener(eventName, () => area.classList.add('dragover'), false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            area.addEventListener(eventName, () => area.classList.remove('dragover'), false);
        });
        
        area.addEventListener('drop', handleDrop, false);
        
        // File input change
        if (input) {
            input.addEventListener('change', function() {
                handleFiles(this.files, area);
            });
        }
        
        // Click to select
        area.addEventListener('click', function() {
            if (input) input.click();
        });
    });
}

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

function handleDrop(e) {
    const files = e.dataTransfer.files;
    const area = e.target.closest('.file-upload-area');
    handleFiles(files, area);
}

function handleFiles(files, area) {
    const preview = area.querySelector('.file-preview');
    const input = area.querySelector('input[type="file"]');
    
    // Update input files
    if (input) {
        input.files = files;
    }
    
    // Show preview
    if (preview) {
        preview.innerHTML = '';
        Array.from(files).forEach(file => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item d-flex align-items-center justify-content-between p-2 bg-light rounded mb-2';
            
            const fileInfo = document.createElement('div');
            fileInfo.innerHTML = `
                <i class="fas fa-file me-2"></i>
                <span>${file.name}</span>
                <small class="text-muted ms-2">(${formatFileSize(file.size)})</small>
            `;
            
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-sm btn-outline-danger';
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.onclick = () => fileItem.remove();
            
            fileItem.appendChild(fileInfo);
            fileItem.appendChild(removeBtn);
            preview.appendChild(fileItem);
        });
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Form validation
function initializeFormValidation() {
    const forms = document.querySelectorAll('.needs-validation');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
}

// AJAX forms
function initializeAjaxForms() {
    const ajaxForms = document.querySelectorAll('[data-ajax="true"]');
    
    ajaxForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const url = form.action || window.location.href;
            const method = form.method || 'POST';
            
            // Show loading
            showLoading();
            
            fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                
                if (data.success) {
                    if (data.message) {
                        showAlert('success', data.message);
                    }
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                } else {
                    showAlert('error', data.message || 'Ocurrió un error');
                }
            })
            .catch(error => {
                hideLoading();
                showAlert('error', 'Error de conexión');
                console.error('Error:', error);
            });
        });
    });
}

// Alert functions
function showAlert(type, message) {
    const alertTypes = {
        'success': 'success',
        'error': 'danger',
        'warning': 'warning',
        'info': 'info'
    };
    
    const alertClass = alertTypes[type] || 'info';
    
    Swal.fire({
        icon: type === 'error' ? 'error' : type,
        title: type === 'error' ? 'Error' : 'Éxito',
        text: message,
        timer: 3000,
        showConfirmButton: false
    });
}

function autoHideAlerts() {
    const alerts = document.querySelectorAll('.alert[data-auto-hide]');
    alerts.forEach(alert => {
        const delay = parseInt(alert.dataset.autoHide) || 5000;
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, delay);
    });
}

// Loading functions
function showLoading() {
    const loadingHtml = `
        <div class="spinner-overlay" id="loadingSpinner">
            <div class="spinner-border spinner-border-lg text-success" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', loadingHtml);
}

function hideLoading() {
    const spinner = document.getElementById('loadingSpinner');
    if (spinner) {
        spinner.remove();
    }
}

// Utility functions
function confirmAction(message, callback) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed && callback) {
            callback();
        }
    });
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

function formatDateTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// DataTable initialization (if DataTables is loaded)
function initializeDataTable(selector, options = {}) {
    if (typeof DataTable !== 'undefined') {
        const defaultOptions = {
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            responsive: true,
            pageLength: 25,
            order: [[0, 'desc']]
        };
        
        const finalOptions = Object.assign(defaultOptions, options);
        return new DataTable(selector, finalOptions);
    }
}

// Export functions
window.LandscapeManager = {
    showAlert,
    confirmAction,
    showLoading,
    hideLoading,
    formatDate,
    formatDateTime,
    initializeDataTable
};