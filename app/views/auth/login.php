<?php include __DIR__ . '/../partials/header.php'; ?>

<div id="loginWrapper" class="w-full max-w-sm mx-auto bg-gray-800 p-8 rounded-lg shadow-md transform transition-all duration-500">
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
    // On submit: disable inputs, wait 3s, show slow popup (scale+fade) then submit
    (function () {
        const form = document.getElementById('loginForm');
        const btn = document.getElementById('loginBtn');
        const wrapper = document.getElementById('loginWrapper');
        if (!form || !btn || !wrapper) return;

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            // disable inputs to prevent multiple submits
            Array.from(form.elements).forEach(el => el.disabled = true);
            btn.textContent = 'Signing in...';
            btn.classList.add('opacity-70');

            // start subtle shrink then popup animation after 3s
            wrapper.style.transition = 'transform 600ms ease, opacity 600ms ease';
            wrapper.style.transform = 'scale(0.98)';
            wrapper.style.opacity = '0.85';

            // wait at least 3 seconds before final popup and submit
            setTimeout(() => {
                // popup: scale up and restore opacity slowly
                wrapper.style.transform = 'scale(1.02)';
                wrapper.style.opacity = '1';

                // small delay to allow popup animation to be visible
                setTimeout(() => {
                    // submit the form for real
                    form.submit();
                }, 600);
            }, 3000);
        });
    })();
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>