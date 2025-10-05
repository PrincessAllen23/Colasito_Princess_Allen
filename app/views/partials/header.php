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
    <!-- header removed by request: minimal top spacing preserved -->
    <div class="h-4"></div>
    <main class="max-w-6xl mx-auto p-6">
