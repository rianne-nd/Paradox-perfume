<?php
// debug_paths.php
// Upload this to your htdocs folder and visit /debug_paths.php to check file visibility.

echo "<h1>File System Debugger</h1>";
echo "<p>Current Directory: " . __DIR__ . "</p>";

$files = scandir(__DIR__);
echo "<h2>Files in this directory:</h2><ul>";
foreach ($files as $file) {
    echo "<li>" . $file . "</li>";
}
echo "</ul>";

echo "<h2>Checking Critical Files:</h2>";
$critical = ['index.php', 'api/db.php', 'assets/style.css'];
foreach ($critical as $f) {
    if (file_exists(__DIR__ . '/' . $f)) {
        echo "<p style='color:green'>FOUND: $f</p>";
    } else {
        echo "<p style='color:red'>MISSING: $f (Check casing!)</p>";
    }
}
?>