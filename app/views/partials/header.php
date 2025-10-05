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
    <header class="bg-gray-900/60 backdrop-blur sticky top-0 z-20">
        <div class="max-w-6xl mx-auto flex items-center justify-between p-4">
            <a href="<?= site_url('') ?>" class="text-xl font-extrabold">LavaLust</a>
            <div class="flex items-center gap-4 text-sm">
                <?php $uid = function_exists('lava_instance') ? lava_instance()->session->userdata('user_id') : null; ?>
                <?php if ($uid): ?>
                    <?php $user = function_exists('lava_instance') ? lava_instance()->UsersModel->find($uid) : null; ?>
                    <span class="text-gray-300">Signed in as <strong class="text-white"><?= htmlspecialchars($user['email'] ?? 'unknown') ?></strong></span>
                    <a href="<?= site_url('auth/logout') ?>" class="text-indigo-300 hover:underline">Logout</a>
                    <?php if (isset($user['email']) && $user['email'] === 'colasito@admin'): ?>
                        <a href="<?= site_url('admin') ?>" class="text-indigo-300 hover:underline">Admin</a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?= site_url('auth/login') ?>" class="text-indigo-300 hover:underline">Sign In</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <main class="max-w-6xl mx-auto p-6">
