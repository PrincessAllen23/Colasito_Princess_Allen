<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="w-full max-w-sm mx-auto bg-gray-800 p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Sign In</h2>
    <?php if (!empty($error)): ?>
        <div class="bg-red-600 text-white p-2 rounded mb-4"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>
    <form id="loginForm" method="post" action="<?= site_url('auth/login') ?>">
        <label class="block mb-2 text-sm font-medium">Email</label>
        <input type="email" name="email" required class="w-full mb-3 px-3 py-2 rounded bg-gray-700 text-white" />

        <label class="block mb-2 text-sm font-medium">Password</label>
        <input type="password" name="password" required class="w-full mb-3 px-3 py-2 rounded bg-gray-700 text-white" />

        <button id="loginBtn" type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded transition-opacity duration-300">Sign In</button>
    </form>
    <div class="mt-4 text-center text-sm">
        <a href="<?= site_url('auth/register') ?>" class="text-indigo-400 hover:underline">Create an account</a>
    </div>
</div>

<script>
    // Simple submit transition: fade the form and disable submit
    const form = document.getElementById('loginForm');
    const btn = document.getElementById('loginBtn');
    form && form.addEventListener('submit', function (e) {
        btn.disabled = true;
        btn.textContent = 'Signing in...';
        form.classList.add('opacity-50');
    });
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>