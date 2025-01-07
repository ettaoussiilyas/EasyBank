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
            <h2 class="text-2xl font-bold text-gray-800">Gestion des Comptes Clients</h2>
            <div class="flex gap-4">
                <!-- Barre de recherche -->
                <form method="GET" action="/admin/accounts" class="flex gap-2">
                    <input type="text" 
                           name="search" 
                           placeholder="Rechercher un client..." 
                           class="px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-violet-500">
                    <button type="submit" 
                            class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">
                        Rechercher
                    </button>
                </form>
                <!-- Bouton Nouveau Compte -->
                <button class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">
                    + Nouveau Compte
                </button>
            </div>
        </div>

        <!-- Clients Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type de Compte</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Solde</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach($accounts as $account) : ?>
                    <tr id="row-<?= $account['id'] ?>">
                        <td class="px-6 py-4"> <?= $account['client_name']  ?> </td>
                        <td class="px-6 py-4"> <?= $account['client_email']  ?> </td>
                        <td class="px-6 py-4 account-type"> <?= $account['account_type'] ;  ?> </td>
                        <td class="px-6 py-4"> 
                            <span class="balance-amount"><?= $account['balance'] ; ?></span> €
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Actif</span>
                        </td>
                        <td class="px-6 py-4">
                            <button onclick="showUpdateForm(<?= $account['id'] ?>)" 
                                    class="text-violet-600 hover:text-violet-800 mr-2">
                                Modifier
                            </button>
                            <form method="POST" 
                                  action="/admin/accounts/delete" 
                                  class="inline mb-0" 
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce compte ?');">
                                <input type="hidden" name="account_id" value="<?= $account['id']; ?>">
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-800">
                                    Supprimer
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
            <h3 class="text-lg font-medium text-gray-900 mb-4">Modifier le compte</h3>
            <form id="updateForm" method="POST">
                <input type="hidden" id="accountId" name="id">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Type de compte</label>
                    <select name="account_type" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="courant">Courant</option>
                        <option value="epargne">Épargne</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Solde</label>
                    <input type="number" name="balance" step="0.01" 
                           class="shadow border rounded w-full py-2 px-3 text-gray-700">
                </div>
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeUpdateModal()" 
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-violet-600 text-white rounded hover:bg-violet-700">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showUpdateForm(id) {
    const modal = document.getElementById('updateModal');
    const form = document.getElementById('updateForm');
    const row = document.getElementById(`row-${id}`);
    
    // Récupérer les valeurs actuelles avec les classes
    const accountType = row.querySelector('.account-type').textContent.trim();
    const balance = row.querySelector('.balance-amount').textContent.trim();
    
    // Remplir le formulaire
    document.getElementById('accountId').value = id;
    form.account_type.value = accountType;
    form.balance.value = balance;
    
    // Afficher le modal
    modal.classList.remove('hidden');
    
    // Mettre à jour l'action du formulaire
    form.action = `/admin/accounts/update/${id}`;
}

function closeUpdateModal() {
    document.getElementById('updateModal').classList.add('hidden');
}

function confirmDelete(id) {
    if(confirm('Êtes-vous sûr de vouloir supprimer ce compte ?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/accounts/delete/${id}`;
        document.body.appendChild(form);
        form.submit();
    }
}

// Fermer le modal si on clique en dehors
window.onclick = function(event) {
    const modal = document.getElementById('updateModal');
    if (event.target == modal) {
        closeUpdateModal();
    }
}
</script>

<?php require_once(__DIR__ . '/../partials/footer.php'); ?> 