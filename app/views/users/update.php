<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update User - Glassmorphism</title>
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
          <?php $suser = lava_instance()->UsersModel->find($uid); ?>
          <div class="text-sm text-white">Signed in as <strong><?= htmlspecialchars($suser['email'] ?? 'unknown') ?></strong>
            <a href="<?= site_url('auth/logout') ?>" class="ml-3 text-indigo-300 hover:underline">Logout</a>
            <?php if (isset($suser['role']) && $suser['role'] === 'admin'): ?>
              <a href="<?= site_url('admin') ?>" class="ml-3 text-indigo-300 hover:underline">Admin Panel</a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="overflow-x-auto rounded-xl">
      <!-- Instead of the table, show the update form centered inside the glass container -->
      <div class="w-full flex justify-center py-8">
        <div class="w-full max-w-2xl bg-white/5 backdrop-blur-md p-8 rounded-2xl border border-gray-700">
          <div class="flex items-center gap-4 mb-4">
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full p-3 shadow-md">
              <i class="fa-solid fa-user-pen text-white text-2xl"></i>
            </div>
            <div>
              <h2 class="text-2xl font-bold text-white">Update User</h2>
              <p class="text-gray-400 text-sm">Edit user details. Leave password blank to keep current password.</p>
            </div>
          </div>

          <?php $current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1; ?>
          <?php $q_param = isset($q) ? $q : ''; ?>
          <form action="<?=site_url('index.php/users/update/'.$user['id'])?>" method="POST" class="space-y-5">
            <input type="hidden" name="page" value="<?= $current_page ?>">

            <div>
              <label class="block text-gray-300 mb-1 font-medium">First Name</label>
              <input type="text" name="fname" value="<?= html_escape($user['fname'])?>" required
                   class="w-full px-4 py-3 bg-black/30 text-gray-200 border border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none shadow-sm transition duration-200">
            </div>

            <div>
              <label class="block text-gray-300 mb-1 font-medium">Last Name</label>
              <input type="text" name="lname" value="<?= html_escape($user['lname'])?>" required
                   class="w-full px-4 py-3 bg-black/30 text-gray-200 border border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none shadow-sm transition duration-200">
            </div>

            <div>
              <label class="block text-gray-300 mb-1 font-medium">Email Address</label>
              <input type="email" name="email" value="<?= html_escape($user['email'])?>" required
                   class="w-full px-4 py-3 bg-black/30 text-gray-200 border border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none shadow-sm transition duration-200">
            </div>

            <div>
              <label class="block text-gray-300 mb-1 font-medium">Password (leave blank to keep current)</label>
              <input type="password" name="password" value=""
                   class="w-full px-4 py-3 bg-black/30 text-gray-200 border border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none shadow-sm transition duration-200">
            </div>

            <div class="flex gap-3 items-center">
              <button type="submit"
                  class="flex-1 bg-gradient-to-r from-yellow-500 to-amber-600 hover:from-yellow-600 hover:to-amber-700 text-black font-semibold py-3 rounded-xl shadow-lg transition duration-200">
                <i class="fa-solid fa-save mr-2"></i> Update Now
              </button>

              <?php
                $back_q = $q_param !== '' ? '?q=' . urlencode($q_param) . '&page=' . $current_page : '?page=' . $current_page;
              ?>
              <a href="<?= site_url('') . $back_q ?>"
                 class="px-4 py-3 bg-gray-700 text-gray-200 rounded-xl hover:bg-gray-600 transition duration-200">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
        
    <div class="mt-6">
      <!-- empty spot for pagination if needed -->
    </div>
  </div>
</body>
</html>