<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update User</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-slate-900 via-indigo-950 to-black min-h-screen flex items-center justify-center font-sans text-gray-200">

  <div class="bg-white/5 backdrop-blur-lg p-8 rounded-3xl shadow-2xl w-full max-w-md border border-gray-700">
    <div class="flex items-center gap-4 mb-6">
      <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full p-3 shadow-md">
        <i class="fa-solid fa-user-pen text-white text-2xl"></i>
      </div>
      <div>
        <h2 class="text-2xl font-bold text-white">Update User</h2>
        <p class="text-gray-400 text-sm">Edit user details. Leave password blank to keep current password.</p>
      </div>
    </div>

    <?php $current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1; ?>
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

      <?php $current_role = $user['role'] ?? 'user'; $viewer_role = function_exists('lava_instance') ? lava_instance()->session->userdata('role') : null; ?>
      <?php if ($viewer_role === 'admin'): ?>
      <div>
        <label class="block text-gray-300 mb-1 font-medium">Role</label>
        <select name="role" class="w-full px-4 py-3 bg-black/30 text-gray-200 border border-gray-600 rounded-xl">
          <option value="user" <?= $current_role === 'user' ? 'selected' : '' ?>>User</option>
          <option value="admin" <?= $current_role === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
      </div>
      <?php endif; ?>

      <div class="flex gap-3 items-center">
        <button type="submit"
                class="flex-1 bg-gradient-to-r from-yellow-500 to-amber-600 hover:from-yellow-600 hover:to-amber-700 text-black font-semibold py-3 rounded-xl shadow-lg transition duration-200">
          <i class="fa-solid fa-save mr-2"></i> Update Now
        </button>

        <a href="<?= site_url('') . '?page=' . $current_page ?>"
           class="px-4 py-3 bg-gray-700 text-gray-200 rounded-xl hover:bg-gray-600 transition duration-200">Cancel</a>
      </div>
    </form>
  </div>
</body>
</html>