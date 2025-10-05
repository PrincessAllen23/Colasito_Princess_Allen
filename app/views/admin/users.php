<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="bg-gray-800 p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
        <div class="flex items-center gap-3">
            <a href="<?= site_url('') ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded text-sm">
                <i class="fa-solid fa-arrow-left"></i> Back to Users
            </a>
            <div class="relative">
                <input id="adminSearch" type="text" name="q" value="<?= isset($q) ? htmlspecialchars($q, ENT_QUOTES) : '' ?>" placeholder="Search email or name"
                    class="px-3 py-2 rounded bg-gray-700 text-white text-sm" />
                <button id="clearSearch" class="absolute right-0 top-0 mt-2 mr-2 text-xs text-gray-400">Clear</button>
            </div>
        </div>
        <div></div>
    </div>

    <div id="adminResults">
        <table class="w-full text-left">
            <thead>
                <tr class="text-sm text-gray-300">
                    <th class="p-2">#</th>
                    <th class="p-2">User</th>
                    <th class="p-2">Name</th>
                    <th class="p-2">Role</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-200">
                <?php foreach ($users as $u): ?>
                    <?php $full = trim(($u['fname'] ?? '') . ' ' . ($u['lname'] ?? '')); ?>
                    <tr class="border-t border-gray-700 hover:bg-white/2 transition-colors">
                        <td class="p-3 font-medium text-sm"><?= $u['id'] ?></td>
                        <td class="p-3 flex items-center gap-3">
                            <div class="w-10 h-10"><?= avatar_for($u['email'] ?? null, $full ?: ($u['email'] ?? null), 40) ?></div>
                            <div class="text-left">
                                <div class="text-sm font-semibold"><?= htmlspecialchars($u['email']) ?></div>
                                <div class="text-xs text-gray-400"><?= htmlspecialchars($full ?: '—') ?></div>
                            </div>
                        </td>
                        <td class="p-3"><?= htmlspecialchars($full ?: '—') ?></td>
                        <td class="p-3"><span class="px-2 py-1 rounded-full bg-white/5 text-xs"><?= htmlspecialchars($u['role'] ?? 'user') ?></span></td>
                        <td class="p-3">
                            <form method="post" action="<?= site_url('admin/set_role/'.$u['id']) ?><?= isset($_GET['page']) ? '?page='.(int)$_GET['page'] : '' ?>">
                                <select name="role" class="bg-gray-700 text-white px-2 py-1 rounded">
                                    <option value="user" <?= (isset($u['role']) && $u['role'] === 'user') ? 'selected' : '' ?>>User</option>
                                    <option value="admin" <?= (isset($u['role']) && $u['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                                </select>
                                <button type="submit" class="ml-2 bg-indigo-600 px-3 py-1 rounded">Save</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="mt-4">
            <?php if (!empty($pagination_html)): ?>
                <?= $pagination_html; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Debounced live search to reload page with q param (simple implementation)
    const searchInput = document.getElementById('adminSearch');
    const clearBtn = document.getElementById('clearSearch');
    let timeout = null;
    function doSearch(q) {
        const url = new URL(window.location.href);
        if (q && q.trim() !== '') {
            url.searchParams.set('q', q.trim());
        } else {
            url.searchParams.delete('q');
        }
        url.searchParams.delete('page'); // reset to first page
        window.location.href = url.toString();
    }
    searchInput && searchInput.addEventListener('input', function (e) {
        clearTimeout(timeout);
        timeout = setTimeout(() => doSearch(e.target.value), 400);
    });
    clearBtn && clearBtn.addEventListener('click', function (e) {
        e.preventDefault();
        searchInput.value = '';
        doSearch('');
    });
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>