Authentication & Admin setup

1) Add DB columns
Run the SQL migration in `migrations/001_add_auth_columns.sql` against your app database to add the `password` and `role` columns to the `students` table.

2) Seed the default admin
By default the app will attempt to seed a default admin user with email `admin` and password `aldge042224` automatically on first visit to the login page. If you prefer to seed manually:

- Generate password hash in PHP:

  php -r "echo password_hash('aldge042224', PASSWORD_DEFAULT).PHP_EOL;"

- Update the record (replace HASH):

  UPDATE students SET password = 'HASH_HERE', role = 'admin' WHERE email = 'admin';

3) Admin actions
- Log in as admin to access the Admin Panel at `/admin`.
- From the Admin Panel you can change any user's role between `user` and `admin`.
- Only admins can create users from the admin Create page or edit roles and passwords.

Security notes
- Passwords are hashed with password_hash().
- CSRF protection is available in the framework and can be enabled in `app/config/config.php` by setting `csrf_protection = TRUE`. If enabled, you'll need to include CSRF tokens in forms.
