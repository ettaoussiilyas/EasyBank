function showErrorAlert(errors) {
    const alertDiv = document.createElement('div');
    alertDiv.id = 'errorAlert';
    alertDiv.className = 'fixed top-20 left-1/2 transform -translate-x-1/2 z-50 w-96 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg transition-opacity duration-500';
    
    const message = typeof errors === 'string' ? errors : errors.join('<br>');
    
    alertDiv.innerHTML = `
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm leading-5 font-medium">${message}</p>
            </div>
        </div>
    `;

    document.body.appendChild(alertDiv);
    setTimeout(() => {
        alertDiv.classList.add('opacity-0');
        setTimeout(() => alertDiv.remove(), 500);
    }, 3000);
} 

function showSuccessAlert(message) {
    const alertDiv = document.createElement('div');
    alertDiv.id = 'successAlert';
    alertDiv.className = 'fixed top-20 left-1/2 transform -translate-x-1/2 z-50 w-96 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg transition-opacity duration-500';
    
    alertDiv.innerHTML = `
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm leading-5 font-medium">${message}</p>
            </div>
        </div>
    `;

    document.body.appendChild(alertDiv);
    setTimeout(() => {
        alertDiv.classList.add('opacity-0');
        setTimeout(() => alertDiv.remove(), 500);
    }, 3000);
} 