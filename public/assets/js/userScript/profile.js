// Get all the elements we need
const updateBtn = document.getElementById('updateBtn');
const updateForm = document.getElementById('updateForm');
const cancelBtn = document.getElementById('cancelBtn');
const userForm = document.getElementById('userForm');

// Show form when update button is clicked
updateBtn.addEventListener('click', () => {
    updateForm.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
});

// Hide form when cancel button is clicked
cancelBtn.addEventListener('click', () => {
    updateForm.classList.add('hidden');
    userForm.reset();
    document.body.style.overflow = 'auto';
});

// Close modal when clicking outside
updateForm.addEventListener('click', (e) => {
    if (e.target === updateForm) {
        updateForm.classList.add('hidden');
        userForm.reset();
        document.body.style.overflow = 'auto';
    }
});

// Form submission
userForm.addEventListener('submit', (e) => {
    // Remove the preventDefault() - let the form submit normally
    // Just ensure the name attributes are set
    document.getElementById('name').setAttribute('name', 'name');
    document.getElementById('cdn').setAttribute('name', 'cdn');
    document.getElementById('email').setAttribute('name', 'email');
    document.getElementById('password').setAttribute('name', 'password');
});