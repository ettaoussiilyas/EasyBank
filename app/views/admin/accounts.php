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


<div class="flex-1 p-8 mt-16">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Customer Account Management</h2>
            <div class="flex gap-4">
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center gap-3">

                                <button onclick="showUpdateForm(
                                    <?= $account['id'] ?>, 
                                    '<?= htmlspecialchars($account['account_type']) ?>', 
                                    '<?= $account['status'] ?>'
                                )" class="p-1.5 rounded-lg hover:bg-violet-50">
                                    <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>

                                <form method="POST"
                                      action="/admin/accounts/delete"
                                      class="inline mb-0"
                                      onsubmit="return confirm('Are you sure you want to delete this account?');">
                                    <input type="hidden" name="account_id" value="<?= $account['id']; ?>">
                                    <button type="submit" class="p-1.5 rounded-lg hover:bg-red-50">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
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


                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Account Type</label>
                    <select name="account_type" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="courant">Courant</option>
                        <option value="epargne">Épargne</option>
                    </select>
                </div>


                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select name="status" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="flex justify-end gap-4">
                    <button type="button" 
                            onclick="closeUpdateModal()"
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






<script>
    function showUpdateForm(id, accountType, status) {
        const modal = document.getElementById('updateModal');
        const form = document.getElementById('updateForm');

        document.getElementById('accountId').value = id;
        form.account_type.value = accountType;
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center gap-3">
                                <!-- Edit Icon -->
                                <button onclick="showUpdateForm(${account.id}, '${account.account_type}', '${account.status}')" 
                                    class="p-1.5 rounded-lg hover:bg-violet-50">
                                    <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>

                                <!-- Delete Icon -->
                                <form method="POST" action="/admin/accounts/delete" class="inline mb-0">
                                    <input type="hidden" name="account_id" value="${account.id}">
                                    <button type="submit" class="p-1.5 rounded-lg hover:bg-red-50">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    `) : '<tr><td colspan="7">No accounts found</td></tr>';
                });
        }

        searchInput.addEventListener('input', filterAccounts);
        statusFilter.addEventListener('change', filterAccounts);
        balanceFilter.addEventListener('change', filterAccounts);
    });
</script>