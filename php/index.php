<?php
require_once __DIR__ . '/init-db.php';

// Read DB settings from environment
$dbHost = getenv('DB_HOST') ?: 'db';
$dbName = getenv('DB_NAME') ?: 'myappdb';
$dbUser = getenv('DB_USER') ?: 'myappuser';
$dbPass = getenv('DB_PASS') ?: 'myapppassword';

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($mysqli->connect_errno) {
    http_response_code(500);
    echo "<h1>Database connection failed</h1>";
    echo "<p>Error: " . htmlspecialchars($mysqli->connect_error) . "</p>";
    exit;
}

$result = $mysqli->query("SELECT id, name, message FROM greetings ORDER BY id DESC LIMIT 10");

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <title>MyApp - Greetings</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 2rem; }
    table { border-collapse: collapse; width: 100%; max-width: 700px; }
    th, td { border: 1px solid #ddd; padding: 8px; }
    th { background: #f4f4f4; }
  </style>
</head>
<body>
  <h1>Greetings from the Database</h1>
  <?php if ($result && $result->num_rows): ?>
    <table>
      <thead><tr><th>ID</th><th>Name</th><th>Message</th></tr></thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['message']); ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No greetings yet. Add some rows to the <code>greetings</code> table.</p>
  <?php endif; ?>

  <p style="margin-top: 1rem;"><em>Connected to <?php echo htmlspecialchars($dbHost . '/' . $dbName); ?></em></p>
</body>
</html>
