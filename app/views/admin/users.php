<?php
$title = "Gestion des Utilisateurs | Admin";
require_once(__DIR__ . '/../partials/header.php');
require_once(__DIR__ . '/../partials/sidebar.php');
?>

<?php if (isset($_SESSION['errors'])): ?>
    <script>
        showErrorAlert(<?= json_encode($_SESSION['errors']) ?>);
    </script>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <script>
        showSuccessAlert(<?= json_encode($_SESSION['success']) ?>);
    </script>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<div class="flex-1 p-8 mt-16">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">User Management</h2>
            <input type="text"
                placeholder="Search by name or email..."
                class="px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-violet-500">
            <button class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">
                + New User
            </button> 
        </div>

       

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full object-cover"
                                        src="<?= $user['profile_pic'] ?? 'https://randomuser.me/api/portraits/lego/1.jpg' ?>"
                                        alt="User photo">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($user['name']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= htmlspecialchars($user['email']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d M Y', strtotime($user['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center gap-3">

                                <button class="p-1.5 rounded-lg hover:bg-violet-50 edit-user-btn"
                                        onclick="showUpdateUserModal(
                                            <?= $user['id'] ?>, 
                                            '<?= htmlspecialchars($user['name']) ?>', 
                                            '<?= htmlspecialchars($user['email']) ?>', 
                                            '<?= htmlspecialchars($user['profile_pic'] ?? '') ?>'
                                        )">
                                    <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>

                                <form method="POST" 
                                      action="/admin/users/delete" 
                                      class="inline mb-0"
                                      onsubmit="return confirm('Are you sure you want to delete this user? All associated accounts will also be deleted.');">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="p-1.5 rounded-lg hover:bg-red-50">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>

                                <a href="/admin/accounts/create?user_id=<?= $user['id'] ?>"
                                    class="p-1.5 rounded-lg hover:bg-green-50 flex items-center gap-1">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <span class="text-green-600">Add Account</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal pour créer un nouvel utilisateur -->
<div id="createUserModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Create New User</h3>
                <button onclick="closeCreateUserModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="createUserForm" method="POST" action="/admin/users/create" class="space-y-4">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text"
                           name="name" 
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
                           placeholder="John Doe">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email"
                           name="email" 
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
                           placeholder="john@example.com">
                </div>

                <!-- Profile Picture URL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Profile Picture URL</label>
                    <input type="url"
                           name="profile_pic"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
                           placeholder="https://example.com/photo.jpg">
                </div>

                <!-- Info Message -->
                <div class="text-sm text-gray-500 italic">
                    A secure password will be automatically generated and displayed after user creation.
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-3">
                    <button type="button"
                            onclick="closeCreateUserModal()"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-violet-600 text-white rounded-md hover:bg-violet-700">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal pour modifier un utilisateur -->
<div id="updateUserModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Update User</h3>
                <button onclick="closeUpdateUserModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="updateUserForm" method="POST" action="/admin/users/update" class="space-y-4">
                <input type="hidden" name="user_id" id="updateUserId">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" 
                           id="updateName"
                           name="name" 
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" 
                           id="updateEmail"
                           name="email" 
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Profile Picture URL</label>
                    <input type="url" 
                           id="updateProfilePic"
                           name="profile_pic"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500">
                </div>

                <div class="mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="generateNewPassword"
                               name="generate_new_password"
                               class="h-4 w-4 text-violet-600 focus:ring-violet-500 border-gray-300 rounded">
                        <label for="generateNewPassword" class="ml-2 block text-sm text-gray-700">
                            Generate new password
                        </label>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">
                        If checked, a new password will be generated and displayed after update
                    </p>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button"
                            onclick="closeUpdateUserModal()"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-violet-600 text-white rounded-md hover:bg-violet-700">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showUpdateUserModal(userId, name, email, profilePic) {
        document.getElementById('updateUserId').value = userId;
        document.getElementById('updateName').value = name;
        document.getElementById('updateEmail').value = email;
        document.getElementById('updateProfilePic').value = profilePic || '';
        document.getElementById('generateNewPassword').checked = false;
        document.getElementById('updateUserModal').classList.remove('hidden');
    }

    function closeUpdateUserModal() {
        document.getElementById('updateUserModal').classList.add('hidden');
    }

    function showCreateUserModal() {
        document.getElementById('createUserModal').classList.remove('hidden');
    }

    function closeCreateUserModal() {
        document.getElementById('createUserModal').classList.add('hidden');
    }

    // Fermer les modales en cliquant en dehors
    window.onclick = function(event) {
        const updateModal = document.getElementById('updateUserModal');
        const createModal = document.getElementById('createUserModal');
        if (event.target == updateModal) {
            closeUpdateUserModal();
        }
        if (event.target == createModal) {
            closeCreateUserModal();
        }
    }

    // Bouton pour ouvrir le modal de création
    document.querySelector('button.bg-violet-600').onclick = showCreateUserModal;
</script>

<?php require_once(__DIR__ . '/../partials/footer.php'); ?>