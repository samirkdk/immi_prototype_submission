<?php
require_once __DIR__ . '/../includes/functions.php';
session_start();

// Auth check
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit;
}

$db = getDB();
$msg = '';
$msgType = 'info';

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
  $id  = (int)($_POST['app_id'] ?? 0);
  $status = $_POST['new_status'] ?? '';
  $notes = trim($_POST['admin_notes'] ?? '');
  $allowed = ['Submitted','Under Review','Approved','Rejected'];
  if ($id && in_array($status, $allowed)) {
    $stmt = $db->prepare("UPDATE visa_applications SET status=?, admin_notes=? WHERE id=?");
    $stmt->execute([$status, $notes ?: null, $id]);
    // Send status update notification
    $updated = $db->prepare('SELECT * FROM visa_applications WHERE id = ?');
    $updated->execute([$id]);
    $updatedApp = $updated->fetch();
    if ($updatedApp) {
      require_once __DIR__ . '/../includes/notifications.php';
      sendStatusUpdateEmail($updatedApp);
      sendStatusUpdateSMS($updatedApp['phone'], $updatedApp['reference_number'], $updatedApp['full_name'], $status);
    }
    $msg = "Application updated successfully.";
    $msgType = 'success';
  }
}

// Filters
$filterStatus = $_GET['status'] ?? '';
$search = trim($_GET['q'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 20;
$offset = ($page - 1) * $perPage;

$where = [];
$params = [];
if ($filterStatus) { $where[] = "status = ?"; $params[] = $filterStatus; }
if ($search) { $where[] = "(reference_number LIKE ? OR full_name LIKE ? OR email LIKE ?)"; $params = array_merge($params, ["%$search%","%$search%","%$search%"]); }
$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$total = $db->prepare("SELECT COUNT(*) FROM visa_applications $whereSQL");
$total->execute($params);
$totalRows = (int)$total->fetchColumn();
$totalPages = max(1, ceil($totalRows / $perPage));

$stmt = $db->prepare("SELECT * FROM visa_applications $whereSQL ORDER BY submitted_at DESC LIMIT $perPage OFFSET $offset");
$stmt->execute($params);
$applications = $stmt->fetchAll();

// Stats
$stats = $db->query("SELECT status, COUNT(*) as cnt FROM visa_applications GROUP BY status")->fetchAll();
$statMap = array_column($stats, 'cnt', 'status');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel — Department of Immigration</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <style>
    .admin-wrap{max-width:1200px;margin:0 auto;padding:32px;}
    .admin-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;}
    .admin-header h1{font-size:22px;font-weight:700;color:#1a1a2e;}
    .stat-row{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:28px;}
    .stat-card{background:#fff;border-radius:10px;border:1px solid #e2e8f0;padding:16px;text-align:center;}
    .stat-card .sv{font-size:28px;font-weight:700;color:#003893;}
    .stat-card .sl{font-size:12px;color:#718096;margin-top:4px;}
    .filter-row{display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;}
    .filter-row input,.filter-row select{padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:6px;font-size:13px;}
    .filter-row button{padding:8px 16px;background:#003893;color:#fff;border:none;border-radius:6px;cursor:pointer;font-size:13px;}
    .pagination{display:flex;gap:6px;margin-top:20px;justify-content:center;}
    .pagination a,.pagination span{padding:6px 12px;border-radius:6px;font-size:13px;text-decoration:none;border:1px solid #e2e8f0;color:#003893;}
    .pagination .current{background:#003893;color:#fff;border-color:#003893;}
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:200;align-items:center;justify-content:center;}
    .modal-overlay.open{display:flex;}
    .modal{background:#fff;border-radius:12px;padding:28px;width:480px;max-width:95vw;}
    .modal h3{font-size:16px;font-weight:700;margin-bottom:16px;}
    .modal select,.modal textarea{width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:6px;font-size:13px;margin-bottom:12px;font-family:inherit;}
    .modal-btns{display:flex;gap:10px;margin-top:4px;}
    .logout-link{font-size:13px;color:#DC143C;text-decoration:none;}
    @media (max-width:768px){
      .admin-wrap{padding:20px 16px;}
      .admin-header{flex-direction:column;align-items:flex-start;gap:12px;}
      .stat-row{grid-template-columns:repeat(2,1fr);}
      .filter-row input{min-width:0!important;width:100%;}
    }
    @media (max-width:480px){
      .stat-row{grid-template-columns:1fr;}
    }
  </style>
</head>
<body style="background:#f0f2f5;">
<div class="admin-wrap">
  <div class="admin-header">
    <h1>Admin Panel — Visa Applications</h1>
    <a href="logout.php" class="logout-link">Log out</a>
  </div>

  <?php if ($msg): ?>
    <div class="alert alert-<?= $msgType ?>"><?= h($msg) ?></div>
  <?php endif; ?>

  <!-- Stats -->
  <div class="stat-row">
    <div class="stat-card"><div class="sv"><?= $statMap['Submitted'] ?? 0 ?></div><div class="sl">Submitted</div></div>
    <div class="stat-card"><div class="sv" style="color:#633806;"><?= $statMap['Under Review'] ?? 0 ?></div><div class="sl">Under Review</div></div>
    <div class="stat-card"><div class="sv" style="color:#27500A;"><?= $statMap['Approved'] ?? 0 ?></div><div class="sl">Approved</div></div>
    <div class="stat-card"><div class="sv" style="color:#DC143C;"><?= $statMap['Rejected'] ?? 0 ?></div><div class="sl">Rejected</div></div>
  </div>

  <!-- Filters -->
  <form method="GET" class="filter-row">
    <input type="text" name="q" placeholder="Search name, email, reference..." value="<?= h($search) ?>" style="flex:1;min-width:200px;">
    <select name="status">
      <option value="">All statuses</option>
      <?php foreach (['Submitted','Under Review','Approved','Rejected'] as $s): ?>
        <option value="<?= $s ?>" <?= $filterStatus === $s ? 'selected' : '' ?>><?= $s ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit">Filter</button>
    <a href="index.php" style="padding:8px 16px;border:1px solid #e2e8f0;border-radius:6px;font-size:13px;color:#718096;text-decoration:none;">Clear</a>
  </form>

  <!-- Table -->
  <div class="data-table-wrap" style="background:#fff;border-radius:12px;border:1px solid #e2e8f0;">
    <table class="data-table">
      <thead>
        <tr>
          <th>Reference</th>
          <th>Name</th>
          <th>Nationality</th>
          <th>Visa Type</th>
          <th>Entry Date</th>
          <th>Submitted</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($applications)): ?>
          <tr><td colspan="8" style="text-align:center;color:#a0aec0;padding:32px;">No applications found.</td></tr>
        <?php else: foreach ($applications as $app):
          $badge = statusBadge($app['status']);
        ?>
          <tr>
            <td style="font-weight:600;font-family:monospace;font-size:12px;"><?= h($app['reference_number']) ?></td>
            <td><?= h($app['full_name']) ?></td>
            <td><?= h($app['nationality']) ?></td>
            <td><?= h($app['visa_type']) ?></td>
            <td><?= h(date('d M Y', strtotime($app['entry_date']))) ?></td>
            <td><?= h(date('d M Y', strtotime($app['submitted_at']))) ?></td>
            <td><span class="status-badge" style="background:<?= $badge['bg'] ?>;color:<?= $badge['color'] ?>;"><?= h($app['status']) ?></span></td>
            <td>
              <button onclick="openModal(<?= $app['id'] ?>, '<?= h($app['reference_number']) ?>', '<?= h($app['status']) ?>', '<?= h(addslashes($app['admin_notes'] ?? '')) ?>')"
                style="background:#003893;color:#fff;border:none;padding:5px 12px;border-radius:4px;font-size:12px;cursor:pointer;">
                Update
              </button>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <?php if ($totalPages > 1): ?>
    <div class="pagination">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php
        $params = array_filter(['q' => $search, 'status' => $filterStatus, 'page' => $i]);
        $qs = http_build_query($params);
        ?>
        <?php if ($i === $page): ?>
          <span class="current"><?= $i ?></span>
        <?php else: ?>
          <a href="?<?= $qs ?>"><?= $i ?></a>
        <?php endif; ?>
      <?php endfor; ?>
    </div>
  <?php endif; ?>
</div>

<!-- Update modal -->
<div class="modal-overlay" id="modal">
  <div class="modal">
    <h3>Update Application Status</h3>
    <form method="POST">
      <input type="hidden" name="app_id" id="modal-id">
      <input type="hidden" name="update_status" value="1">
      <p style="font-size:13px;color:#718096;margin-bottom:12px;">Reference: <strong id="modal-ref"></strong></p>
      <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">New Status</label>
      <select name="new_status" id="modal-status">
        <option value="Submitted">Submitted</option>
        <option value="Under Review">Under Review</option>
        <option value="Approved">Approved</option>
        <option value="Rejected">Rejected</option>
      </select>
      <label style="font-size:12px;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Admin Notes (optional)</label>
      <textarea name="admin_notes" id="modal-notes" rows="3" placeholder="Add a note visible to the applicant..."></textarea>
      <div class="modal-btns">
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <button type="button" onclick="closeModal()" class="btn btn-outline">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
function openModal(id, ref, status, notes) {
  document.getElementById('modal-id').value = id;
  document.getElementById('modal-ref').textContent = ref;
  document.getElementById('modal-status').value = status;
  document.getElementById('modal-notes').value = notes;
  document.getElementById('modal').classList.add('open');
}
function closeModal() {
  document.getElementById('modal').classList.remove('open');
}
document.getElementById('modal').addEventListener('click', function(e) {
  if (e.target === this) closeModal();
});
</script>
</body>
</html>
