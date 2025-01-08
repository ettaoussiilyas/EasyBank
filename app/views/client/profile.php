<?php

require_once __DIR__.'/../partials/headerUser.php';
require_once __DIR__.'/../partials/sidebarUser.php';


?>



<div class="flex-1 p-8 mt-14">
    <div>
        <?php if (isset($successProfileUpdate)): ?>
            <div class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 w-96 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg" role="alert">
                <div class="flex">
                    <div class="ml-3">
                        <p class="text-sm leading-5 font-medium">
                            <?php echo $successProfileUpdate?>
                        </p>
                    </div>
                    <!-- Close button -->
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button onclick="this.closest('[role=\'alert\']').remove()" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-200 focus:outline-none">
                                <span class="sr-only">Dismiss</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center space-x-6">
            <div class="w-24 h-24 rounded-full overflow-hidden">
                <img src="<?php echo isset($data['profile_pic']) ? $data['profile_pic'] : 'assets/images/default-profile.png'; ?>" 
                     alt="Profile Picture"
                     class="w-full h-full object-cover">
            </div>
            <div>
                <h1 class="text-2xl font-bold"><?php echo isset($data['name']) ? htmlspecialchars($data['name']) : ''; ?></h1>
                <p class="text-gray-600"><?php echo isset($data['email']) ? htmlspecialchars($data['email']) : ''; ?></p>
            </div>
        </div>
        
        <div class="mt-6 border-t pt-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-500">Member since:</p>
                    <p><?php echo isset($data['created_at']) ? date('F j, Y', strtotime($data['created_at'])) : 'N/A'; ?></p>
                </div>
                <div>
                    <p class="text-gray-500">Last updated:</p>
                    <p><?php echo isset($data['updated_at']) ? date('F j, Y', strtotime($data['updated_at'])) : 'N/A'; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full flex justify-center mt-6">
        <button id="updateBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
          Update Information
        </button>
    </div>

    <!-- form of update infos -->

    <div class="p-4">
        <div id="updateForm" class="<?php echo (isset($errorEmptyFields) || isset($errorNameLength) || 
                                     isset($errorPassLength) || isset($errorEmailExists) || 
                                     isset($failedProfileUpdate)) ? '' : 'hidden'; ?> fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <form id="userForm" class="space-y-4" method="POST" action="/user/profile">
                    <div id="formMessages" class="space-y-4">
                        <?php if(isset($errorEmptyFields)): ?>
                            <p class="text-red-500"><?php echo $errorEmptyFields ?></p>
                        <?php endif; ?>
                        
                        <?php if(isset($errorNameLength)): ?>
                            <p class="text-red-500"><?php echo $errorNameLength ?></p>
                        <?php endif; ?>
                        
                        <?php if(isset($errorPassLength)): ?>
                            <p class="text-red-500"><?php echo $errorPassLength ?></p>
                        <?php endif; ?>
                        
                        <?php if(isset($errorEmailExists)): ?>
                            <p class="text-red-500"><?php echo $errorEmailExists ?></p>
                        <?php endif; ?>
                        
                        <?php if(isset($failedProfileUpdate)): ?>
                            <p class="text-red-500"><?php echo $failedProfileUpdate ?></p>
                        <?php endif; ?>
                        
                        <?php if(isset($successProfileUpdate)): ?>
                            <p class="text-green-500"><?php echo $successProfileUpdate ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" name="name" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                    </div>

                    <div>
                        <label for="cdn" class="block text-sm font-medium text-gray-700">CDN Profile</label>
                        <input type="text" id="cdn" name="cdn" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2 border">
                    </div>

                    <div class="flex justify-end space-x-3 mt-5">
                        <button type="button" id="cancelBtn"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg transition duration-200">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/userScript/profile.js" defer></script>
<?php
    require_once __DIR__.'/../partials/footer.php';
 
?>