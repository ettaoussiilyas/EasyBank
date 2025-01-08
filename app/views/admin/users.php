<?php
$title = "Gestion des Utilisateurs | Admin";
require_once(__DIR__ . '/../partials/header.php');
require_once(__DIR__ . '/../partials/sidebar.php');
?>

<div class="flex-1 p-8 mt-16">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">User Management</h2>
            <button class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">
                + New User
            </button>
        </div>

        <div class="mb-6 flex flex-wrap gap-4">
            <input type="text"
                   placeholder="Search by name or email..."
                   class="px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-violet-500">

            <select class="px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-violet-500">
                <option value="">All Roles</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>

            <select class="px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-violet-500">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img class="h-10 w-10 rounded-full object-cover"
                                     src="https://randomuser.me/api/portraits/men/1.jpg"
                                     alt="User photo">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">John Doe</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">john@example.com</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-violet-100 text-violet-800">
                                Admin
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-violet-600 hover:text-violet-900 mr-3">Edit</button>
                            <button class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once(__DIR__ . '/../partials/footer.php'); ?> 