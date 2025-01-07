<?php 
$title = "Gestion des Comptes Clients | Admin";
require_once(__DIR__ . '/../partials/header.php'); 
require_once(__DIR__ . '/../partials/sidebar.php'); 
?>

<!-- Content -->
<div class="flex-1 p-8 mt-16">
    <div class="max-w-7xl mx-auto">
        <!-- Header avec recherche -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Customer Account Management</h2>
            <div class="flex gap-4">
                <!-- Barre de recherche -->
                <form method="GET" action="/admin/accounts" class="flex gap-2">
                    <input type="text" 
                           name="search" 
                           placeholder="Search customer..." 
                           class="px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-violet-500">
                    <button type="submit" 
                            class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">
                        Search
                    </button>
                </form>
                <!-- Bouton Nouveau Compte -->
                <button class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">
                    + New Account
                </button>
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
                    <?php foreach($accounts as $account) : ?>
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
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                        </td>
                        <td class="px-6 py-4">
                            <button type="button" onclick="showUpdateForm(
                                <?= $account['id'] ?>, 
                                '<?= htmlspecialchars($account['name']) ?>', 
                                '<?= htmlspecialchars($account['email']) ?>', 
                                '<?= $account['account_type'] ?>', 
                                '<?= $account['balance'] ?>',
                                '<?= $account['profile_pic'] ?? 'https://randomuser.me/api/portraits/lego/1.jpg' ?>'
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





<?php require_once(__DIR__ . '/../partials/footer.php'); ?> 