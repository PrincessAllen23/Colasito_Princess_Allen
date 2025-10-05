<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
$title = isset($title) ? $title : 'LavaLust App';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= htmlspecialchars($title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* subtle global styles */
        body { background: linear-gradient(135deg, #0f172a 0%, #0b1220 100%); }
    </style>
</head>
<body class="min-h-screen text-white">
    <!-- compact header with avatar and subtle glass bar -->
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between py-3 px-4 rounded-xl bg-white/3 backdrop-blur-md shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-cyan-400 text-white font-extrabold text-lg shadow-inner">LL</div>
                <div class="text-sm text-white/90">LavaLust</div>
            </div>
            <div class="flex items-center gap-3">
                <?php if (function_exists('lava_instance') && lava_instance()->session->userdata('user_id')): ?>
                    <?php $uid = lava_instance()->session->userdata('user_id');
                          $me = lava_instance()->UsersModel->find($uid);
                          $displayName = trim(($me['fname'] ?? '') . ' ' . ($me['lname'] ?? '')) ?: ($me['email'] ?? '');
                    ?>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10"><?= avatar_for($me['email'] ?? null, $displayName, 40) ?></div>
                        <div class="text-sm text-white">
                            <div class="font-semibold"><?= htmlspecialchars($displayName) ?></div>
                            <a href="<?= site_url('auth/logout') ?>" class="text-xs text-indigo-200 hover:underline">Logout</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="h-4"></div>
    <main class="max-w-6xl mx-auto p-6">
