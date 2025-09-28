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

  <form action="<?=site_url('users/update/'.$user['id'])?>" method="POST">
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

    <button type="submit">Update Now</button>
  </form>

</body>
</html>