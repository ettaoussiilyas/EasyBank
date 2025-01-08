<?php
$title = "Gestion des Comptes Clients | Admin";
require_once(__DIR__ . '/../partials/header.php');
require_once(__DIR__ . '/../partials/sidebar.php');
?>


<?php if (isset($_SESSION['errors'])): ?>
    <script>
        showErrorAlert(<?= json_encode($_SESSION['errors']) ?>);
    </script>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<!-- Content -->
<div class="flex-1 p-8 mt-16">
    <div class="max-w-7xl mx-auto">
        <!-- Header avec recherche -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Customer Account Management</h2>
            <div class="flex gap-4">
                <!-- Zone de recherche et filtres -->
                <div class="flex items-center gap-4">
                    <input type="text"
                        id="searchInput"
                        placeholder="Search customer..."
                        class="px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-violet-500">

                    <select id="statusFilter" class="px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-violet-500">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>

                    <select id="balanceFilter" class="px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-violet-500">
                        <option value="">All Balances</option>
                        <option value="0-1000">0 - 1000 €</option>
                        <option value="1000-5000">1000 - 5000 €</option>
                        <option value="5000+">5000+ €</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Clients Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Account Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Balance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($accounts as $account) : ?>
                        <tr id="row-<?= $account['id'] ?>">
                            <td class="px-6 py-4">
                                <img src="<?= $account['profile_pic'] ?? 'https://randomuser.me/api/portraits/lego/1.jpg' ?>"
                                    alt="Photo of <?= $account['name'] ?>"
                                    class="w-10 h-10 rounded-full object-cover">
                            </td>
                            <td class="px-6 py-4"> <?= $account['name'] ?> </td>
                            <td class="px-6 py-4"> <?= $account['email'] ?> </td>
                            <td class="px-6 py-4 account-type"> <?= $account['account_type'] ?> </td>
                            <td class="px-6 py-4">
                                <span class="balance-amount"><?= $account['balance'] ?></span> €
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" action="/admin/accounts/toggle-status" class="inline">
                                    <input type="hidden" name="account_id" value="<?= $account['id'] ?>">
                                    <button type="submit"
                                        class="px-2 py-1 text-xs rounded-full cursor-pointer
                       <?= $account['status'] === 'active'
                            ? 'bg-green-100 text-green-800 hover:bg-red-100 hover:text-red-800'
                            : 'bg-red-100 text-red-800 hover:bg-green-100 hover:text-green-800' ?>">
                                        <?= $account['status'] ?>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <button type="button" onclick="showUpdateForm(
    <?= $account['id'] ?>, 
    '<?= htmlspecialchars($account['account_type']) ?>', 
    '<?= $account['balance'] ?>',
    '<?= $account['status'] ?>'
)" class="text-violet-600 hover:text-violet-800 mr-2">
                                    Edit
                                </button>
                                <form method="POST"
                                    action="/admin/accounts/delete"
                                    class="inline mb-0"
                                    onsubmit="return confirm('Are you sure you want to delete this account?');">
                                    <input type="hidden" name="account_id" value="<?= $account['id']; ?>">
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Update -->
<div id="updateModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Account</h3>
            <form id="updateForm" method="POST" action="/admin/accounts/update">
                <input type="hidden" id="accountId" name="account_id">

                <!-- Account Type -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Account Type</label>
                    <select name="account_type" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="courant">Courant</option>
                        <option value="epargne">Épargne</option>
                    </select>
                </div>

                <!-- Balance -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Balance</label>
                    <input type="number"
                        name="balance"
                        step="0.01"
                        class="shadow border rounded w-full py-2 px-3 text-gray-700">
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select name="status" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="active">active</option>
                        <option value="inactive">inactive</option>
                    </select>
                </div>

                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeUpdateModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-violet-600 text-white rounded hover:bg-violet-700">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Ajouter le modal de création -->
<div id="createModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Create New Account</h3>
            <form id="createForm" method="POST" action="/admin/accounts/create">
                <!-- Customer Information -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Customer Name</label>
                    <input type="text"
                        name="name"
                        required
                        class="shadow border rounded w-full py-2 px-3 text-gray-700">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email"
                        name="email"
                        required
                        class="shadow border rounded w-full py-2 px-3 text-gray-700">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password"
                        name="password"
                        required
                        class="shadow border rounded w-full py-2 px-3 text-gray-700">
                </div>

                <!-- Account Information -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Account Type</label>
                    <select name="account_type" required class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="courant">Courant</option>
                        <option value="epargne">Épargne</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Initial Balance</label>
                    <input type="number"
                        name="balance"
                        step="0.01"
                        required
                        class="shadow border rounded w-full py-2 px-3 text-gray-700">
                </div>

                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeCreateModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-violet-600 text-white rounded hover:bg-violet-700">
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    function showUpdateForm(id, accountType, balance, status) {
        const modal = document.getElementById('updateModal');
        const form = document.getElementById('updateForm');

        document.getElementById('accountId').value = id;
        form.account_type.value = accountType;
        form.balance.value = balance;
        form.status.value = status;

        modal.classList.remove('hidden');
    }

    function closeUpdateModal() {
        document.getElementById('updateModal').classList.add('hidden');
    }

    function showCreateForm() {
        document.getElementById('createModal').classList.remove('hidden');
    }

    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
    }

    // Mettre à jour le gestionnaire de clic existant
    window.onclick = function(event) {
        const updateModal = document.getElementById('updateModal');
        const createModal = document.getElementById('createModal');
        if (event.target == updateModal) {
            closeUpdateModal();
        }
        if (event.target == createModal) {
            closeCreateModal();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const balanceFilter = document.getElementById('balanceFilter');
        const tbody = document.querySelector('tbody');

        function filterAccounts() {
            const searchTerm = searchInput.value;
            const status = statusFilter.value;
            const balance = balanceFilter.value;

            fetch(`/admin/accounts/search?term=${encodeURIComponent(searchTerm)}&status=${status}`)
                .then(response => response.json())
                .then(accounts => {
                    // Filtrer par balance si nécessaire
                    if (balance) {
                        const bal = parseFloat(balance);
                        accounts = accounts.filter(account => {
                            const accountBalance = parseFloat(account.balance);
                            if (balance === '0-1000') return accountBalance <= 1000;
                            if (balance === '1000-5000') return accountBalance > 1000 && accountBalance <= 5000;
                            if (balance === '5000+') return accountBalance > 5000;
                            return true;
                        });
                    }

                    // Afficher les résultats
                    tbody.innerHTML = accounts.length ? accounts.map(account => `
                        <tr id="row-${account.id}">
                            <td class="px-6 py-4">
                                <img src="${account.profile_pic || 'https://randomuser.me/api/portraits/lego/1.jpg'}"
                                     alt="Photo" class="w-10 h-10 rounded-full object-cover">
                            </td>
                            <td class="px-6 py-4">${account.name}</td>
                            <td class="px-6 py-4">${account.email}</td>
                            <td class="px-6 py-4">${account.account_type}</td>
                            <td class="px-6 py-4">${account.balance} €</td>
                            <td class="px-6 py-4">
                                <form method="POST" action="/admin/accounts/toggle-status" class="inline">
                                    <input type="hidden" name="account_id" value="${account.id}">
                                    <button type="submit" 
                                        class="px-2 py-1 text-xs rounded-full cursor-pointer ${
                                            account.status === 'active' 
                                                ? 'bg-green-100 text-green-800' 
                                                : 'bg-red-100 text-red-800'
                                        }">
                                        ${account.status}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="showUpdateForm(${account.id}, '${account.account_type}', '${account.balance}', '${account.status}')" 
                                    class="text-violet-600 hover:text-violet-800 mr-2">
                                    Edit
                                </button>
                                <form method="POST" action="/admin/accounts/delete" class="inline mb-0">
                                    <input type="hidden" name="account_id" value="${account.id}">
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    `).join('') : '<tr><td colspan="7" class="text-center py-4">No results found</td></tr>';
                });
        }

        // Écouter les changements
        searchInput.addEventListener('input', filterAccounts);
        statusFilter.addEventListener('change', filterAccounts);
        balanceFilter.addEventListener('change', filterAccounts);
    });
</script>

<?php require_once(__DIR__ . '/../partials/footer.php'); ?>