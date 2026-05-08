<?php
require_once __DIR__ . '/../config/db.php';
session_start();

if (isset($_SESSION['admin'])) {
  header('Location: index.php');
  exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';
  if ($username && $password) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['admin'] = $user['username'];
      header('Location: index.php');
      exit;
    }
  }
  $error = 'Invalid username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — Department of Immigration</title>
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body style="background:#003893;display:flex;align-items:center;justify-content:center;min-height:100vh;">
<div style="background:#fff;border-radius:12px;padding:40px;width:380px;max-width:95vw;">
  <div style="text-align:center;margin-bottom:28px;">
    <div style="width:52px;height:52px;border-radius:50%;background:#003893;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.5">
        <circle cx="12" cy="12" r="9"/><path d="M12 3v4M12 17v4M3 12h4M17 12h4"/>
      </svg>
    </div>
    <div style="font-size:16px;font-weight:700;color:#1a1a2e;">Department of Immigration</div>
    <div style="font-size:13px;color:#718096;margin-top:4px;">Admin Panel</div>
  </div>
  <?php if ($error): ?>
    <div class="alert alert-error"><?= h($error) ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="form-group" style="margin-bottom:16px;">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" autocomplete="username" required>
    </div>
    <div class="form-group" style="margin-bottom:24px;">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" autocomplete="current-password" required>
    </div>
    <button type="submit" class="btn btn-primary" style="width:100%;">Sign In</button>
  </form>
  <p style="text-align:center;margin-top:16px;font-size:12px;color:#a0aec0;">
    <a href="../index.php" style="color:#003893;text-decoration:none;">← Back to public site</a>
  </p>
</div>
<?php function h($s){return htmlspecialchars($s,ENT_QUOTES,'UTF-8');} ?>
</body>
</html>
