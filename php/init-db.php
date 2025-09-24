<?php
$dbHost = getenv('DB_HOST') ?: 'db';
$dbName = getenv('DB_NAME') ?: 'myappdb';
$dbUser = getenv('DB_USER') ?: 'myappuser';
$dbPass = getenv('DB_PASS') ?: 'myapppassword';

// Retry until MySQL is ready
$maxAttempts = 20;
$attempt = 0;
$mysqli = null;

while ($attempt < $maxAttempts) {
    $mysqli = @new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    if (!$mysqli->connect_errno) {
        break; // connected successfully
    }
    $attempt++;
    echo "Waiting for MySQL ($attempt/$maxAttempts)...\n";
    sleep(2); // wait 2 seconds before retry
}

if ($mysqli->connect_errno) {
    http_response_code(500);
    echo "<h1>Database connection failed after $maxAttempts attempts</h1>";
    echo "<p>Error: " . htmlspecialchars($mysqli->connect_error) . "</p>";
    exit;
}

// Check if "greetings" table exists
$result = $mysqli->query("SHOW TABLES LIKE 'greetings'");
if ($result->num_rows == 0) {
    // Table doesn't exist — run init.sql
    $sqlFile = __DIR__ . '/../sql/init.sql';
    if (file_exists($sqlFile)) {
        $sql = file_get_contents($sqlFile);
        if ($mysqli->multi_query($sql)) {
            // Flush all results
            do { } while ($mysqli->more_results() && $mysqli->next_result());
            echo "Table 'greetings' created and sample rows inserted.\n";
        } else {
            echo "<p>Error initializing table: " . htmlspecialchars($mysqli->error) . "</p>";
            exit;
        }
    } else {
        echo "<p>init.sql file not found!</p>";
        exit;
    }
} else {
    echo "Table 'greetings' already exists.\n";
}

$mysqli->close();
