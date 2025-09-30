<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?=base_url();?>public/css/styles.css">
  <title>Update User</title>
</head>
<body>

  <h2>Update User Information</h2>

  <?php $current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1; ?>
  <form action="<?=site_url('index.php/users/update/'.$user['id'])?>" method="POST">
    <input type="hidden" name="page" value="<?= $current_page ?>">
    <div>
      <label>First Name</label><br>
      <input type="text" name="fname" value="<?= html_escape($user['fname'])?>" required>
    </div>
    <br>

    <div>
      <label>Last Name</label><br>
      <input type="text" name="lname" value="<?= html_escape($user['lname'])?>" required>
    </div>
    <br>

    <div>
      <label>Email Address</label><br>
      <input type="email" name="email" value="<?= html_escape($user['email'])?>" required>
    </div>
    <br>

    <div>
      <label>Password (leave blank to keep current)</label><br>
      <input type="password" name="password" value="">
    </div>
    <br>

    <?php $current_role = $user['role'] ?? 'user'; $viewer_role = function_exists('lava_instance') ? lava_instance()->session->userdata('role') : null; ?>
    <?php if ($viewer_role === 'admin'): ?>
    <div>
      <label>Role</label><br>
      <select name="role">
        <option value="user" <?= $current_role === 'user' ? 'selected' : '' ?>>User</option>
        <option value="admin" <?= $current_role === 'admin' ? 'selected' : '' ?>>Admin</option>
      </select>
    </div>
    <br>
    <?php endif; ?>

    <button type="submit">Update Now</button>
  </form>

</body>
</html>