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
            <a href="<?=site_url('users/create')?>"
                class="inline-flex items-center gap-2 bg-white bg-opacity-20 hover:bg-opacity-30 border border-white border-opacity-30 text-white font-semibold px-6 py-3 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg">
                <i class="fa-solid fa-user-plus"></i> Add New User
            </a>
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
                                    <a href="<?=site_url('users/update/'.$user['id']);?>"
                                        class="text-green-300 hover:text-green-500 transition-colors" title="Update">
                                        <i class="fa-solid fa-pen-to-square text-lg"></i>
                                    </a>
                                    <a href="<?=site_url('users/delete/'.$user['id']);?>"
                                        class="text-red-300 hover:text-red-500 transition-colors" title="Delete">
                                        <i class="fa-solid fa-trash text-lg"></i>
                                    </a>
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
        <?php if(isset($debug_db_total)): ?>
            <div class="mt-4 text-sm text-gray-300">
                <strong>Debug:</strong> total rows = <?= $debug_db_total; ?>
                <pre class="text-xs text-gray-200 bg-black/20 p-3 rounded mt-2"><?= htmlspecialchars(print_r($debug_db_sample, true)); ?></pre>
                <div class="mt-2 text-xs">
                    <strong>Raw all() fetch:</strong>
                    <pre class="text-xs text-gray-200 bg-black/20 p-3 rounded mt-2"><?= htmlspecialchars(print_r($debug_raw_all ?? [], true)); ?></pre>
                </div>
            </div>
        <?php endif; ?>
        <div class="mt-6">
            <?php if(!empty($pagination_html)): ?>
                <?= $pagination_html; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>