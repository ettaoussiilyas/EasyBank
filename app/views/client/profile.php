<?php

require_once __DIR__.'/../partials/headerUser.php';
require_once __DIR__.'/../partials/sidebarUser.php';

?>



<div class="flex-1 p-8 mt-14">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center space-x-6">
            <div class="w-24 h-24 rounded-full overflow-hidden">
                <img src="<?php echo $data['profile_pic'] ?? 'assets/images/default-profile.png'; ?>" 
                     alt="Profile Picture"
                     class="w-full h-full object-cover">
            </div>
            <div>
                <h1 class="text-2xl font-bold"><?php echo htmlspecialchars($data['name']); ?></h1>
                <p class="text-gray-600"><?php echo htmlspecialchars($data['email']); ?></p>
            </div>
        </div>
        
        <div class="mt-6 border-t pt-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-500">Member since:</p>
                    <p><?php echo date('F j, Y', strtotime($data['created_at'])); ?></p>
                </div>
                <div>
                    <p class="text-gray-500">Last updated:</p>
                    <p><?php echo date('F j, Y', strtotime($data['updated_at'])); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>




<?php
    require_once __DIR__.'/../partials/footer.php';
 
?>