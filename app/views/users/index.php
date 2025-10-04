<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Directory - Glassmorphism</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            background-attachment: fixed;
        }
        .glass-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
        .table-bg {
            background: rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="font-sans text-white">

    <div class="max-w-6xl mx-auto mt-10 p-8 rounded-3xl glass-container">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-extrabold text-white drop-shadow-lg">User Directory</h1>
            <div class="flex items-center gap-4">
                <form method="get" action="<?=site_url('')?>" class="flex items-center gap-2">
                    <input type="text" name="q" value="<?= isset($q) ? htmlspecialchars($q, ENT_QUOTES) : '' ?>" placeholder="Search name or email"
                        class="px-4 py-2 rounded-full bg-white bg-opacity-10 text-white focus:outline-none" />
                    <button type="submit" class="px-4 py-2 rounded-full bg-indigo-600 hover:bg-indigo-500">Search</button>
                </form>

                <!-- show signed-in user and logout -->
                <?php $uid = function_exists('lava_instance') ? lava_instance()->session->userdata('user_id') : null; ?>
                <?php if ($uid): ?>
                    <?php $user = lava_instance()->UsersModel->find($uid); ?>
                    <div class="text-sm text-white">Signed in as <strong><?= htmlspecialchars($user['email'] ?? 'unknown') ?></strong>
                        <a href="<?= site_url('auth/logout') ?>" class="ml-3 text-indigo-300 hover:underline">Logout</a>
                        <?php if (isset($user['email']) && $user['email'] === 'colasito@admin'): ?>
                            <a href="<?= site_url('admin') ?>" class="ml-3 text-indigo-300 hover:underline">Admin Panel</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="overflow-x-auto rounded-xl">
            <table class="w-full text-center table-bg rounded-xl overflow-hidden">
                <thead>
                    <tr class="bg-white bg-opacity-10 uppercase text-xs font-bold tracking-wider">
                        <th class="py-4 px-4">ID</th>
                        <th class="py-4 px-4">Lastname</th>
                        <th class="py-4 px-4">Firstname</th>
                        <th class="py-4 px-4">Email</th>
                        <th class="py-4 px-4">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <?php if (!empty($users) && is_array($users)): ?>
                        <?php foreach($users as $user): ?>
                            <tr class="hover:bg-white hover:bg-opacity-5 transition duration-200">
                                <td class="py-4 px-4 font-medium"><?=($user['id']);?></td>
                                <td class="py-4 px-4"><?=($user['lname']);?></td>
                                <td class="py-4 px-4"><?=($user['fname']);?></td>
                                <td class="py-4 px-4">
                                    <span class="bg-cyan-500 bg-opacity-50 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                        <?=($user['email']);?>
                                    </span>
                                </td>
                                <td class="py-4 px-4 flex justify-center gap-4">
                                    <?php
                                    // Check session role; lava_instance()->session is available via kernel
                                    $role = function_exists('lava_instance') ? lava_instance()->session->userdata('role') : null;
                                    $qs = isset($q) && $q !== '' ? '?q=' . urlencode($q) . (isset($_GET['page']) ? '&page=' . (int)$_GET['page'] : '') : (isset($_GET['page']) ? '?page=' . (int)$_GET['page'] : '');
                                    $update_url = site_url('users/update/'.$user['id']) . $qs;
                                    $delete_url = site_url('users/delete/'.$user['id']) . $qs;
                                    ?>
                                    <?php if ($role === 'admin'): ?>
                                    <a href="<?= $update_url; ?>"
                                        class="text-green-300 hover:text-green-500 transition-colors" title="Update">
                                        <i class="fa-solid fa-pen-to-square text-lg"></i>
                                    </a>
                                    <a href="<?= $delete_url; ?>"
                                        class="text-red-300 hover:text-red-500 transition-colors" title="Delete">
                                        <i class="fa-solid fa-trash text-lg"></i>
                                    </a>
                                    <?php else: ?>
                                    <span class="text-gray-300 text-xs italic">Restricted</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-8 px-4 text-center text-gray-200">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            <?php if(!empty($pagination_html)): ?>
                <?= $pagination_html; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>