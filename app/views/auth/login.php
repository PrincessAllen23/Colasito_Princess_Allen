<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">
    <div class="w-full max-w-sm bg-gray-800 p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Sign In</h2>
        <?php if (!empty($error)): ?>
            <div class="bg-red-600 text-white p-2 rounded mb-4"><?=htmlspecialchars($error)?></div>
        <?php endif; ?>
        <form method="post" action="<?= site_url('auth/login') ?>">
            <label class="block mb-2 text-sm font-medium">Email</label>
            <input type="email" name="email" required class="w-full mb-3 px-3 py-2 rounded bg-gray-700 text-white" />

            <label class="block mb-2 text-sm font-medium">Password</label>
            <input type="password" name="password" required class="w-full mb-3 px-3 py-2 rounded bg-gray-700 text-white" />

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded">Sign In</button>
        </form>
    </div>
</body>
</html>