<?php
// Usage (run from project root):
// php create_admin.php username password
// or to only promote existing user: php create_admin.php promote username

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/core/Database.php';

function usage() {
    echo "Usage:\n";
    echo "  php create_admin.php username password    # create or update user and set role=admin\n";
    echo "  php create_admin.php promote username     # promote existing user to admin\n";
    echo "\nSecurity: remove this file after use to avoid exposing admin creation.\n";
    exit(1);
}

if (PHP_SAPI !== 'cli') {
    echo "This script must be run from the command line.\n";
    exit(1);
}

if ($argc < 2) usage();

$action = $argv[1];

try {
    $db = Database::connect();
} catch (Exception $e) {
    echo "Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

if ($action === 'promote') {
    if ($argc !== 3) usage();
    $username = $argv[2];

    $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User '$username' not found.\n";
        exit(1);
    }

    $upd = $db->prepare("UPDATE users SET role = 'admin' WHERE username = ?");
    $upd->execute([$username]);
    echo "User '$username' promoted to admin.\n";
    exit(0);
}

// Otherwise treat as create/update: php create_admin.php username password
if ($argc !== 3) usage();

$username = $argv[1];
$password = $argv[2];

// hash password
$hash = password_hash($password, PASSWORD_DEFAULT);

// check if user exists
$stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // update password and role
    $upd = $db->prepare("UPDATE users SET password = ?, role = 'admin' WHERE username = ?");
    $upd->execute([$hash, $username]);
    echo "Existing user '$username' updated and promoted to admin.\n";
} else {
    // insert new admin user
    $ins = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')");
    $ins->execute([$username, $hash]);
    echo "New admin user '$username' created.\n";
}

exit(0);
