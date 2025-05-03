// public/js/importUsers.js

document.addEventListener('DOMContentLoaded', function() {
    const importButton = document.getElementById('importButton');
    const fileInput = document.getElementById('fileInput');
    const importForm = document.getElementById('importForm');
    const importSpinner = document.getElementById('importSpinner');
    const importText = document.getElementById('importText');

    if (importButton && fileInput && importForm) {
        // Manejar clic en el botón de importar
        importButton.addEventListener('click', function() {
            fileInput.click();
        });

        // Manejar cambio en el input de archivo
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                handleFileImport();
            }
        });
    }

    function handleFileImport() {
        // Mostrar feedback visual
        importSpinner.classList.remove('d-none');
        importText.textContent = 'Procesando...';

        // Crear FormData y enviar via AJAX
        const formData = new FormData(importForm);
        
        fetch(importForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                setTimeout(() => location.reload(), 1000);
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            showAlert('error', 'Error en la importación: ' + error.message);
        })
        .finally(() => {
            importSpinner.classList.add('d-none');
            importText.textContent = 'Importar Usuarios';
        });
    }

    function showAlert(type, message) {
        // Crear elemento de alerta
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} fixed-top mx-auto mt-3`;
        alertDiv.style.maxWidth = '500px';
        alertDiv.style.zIndex = '1100';
        alertDiv.textContent = message;
        
        // Agregar al cuerpo del documento
        document.body.appendChild(alertDiv);
        
        // Remover después de 5 segundos
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
});