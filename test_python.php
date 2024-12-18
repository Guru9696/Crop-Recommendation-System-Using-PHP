<?php
$python_path = 'C:/Python312/python.exe'; // Adjust this path based on your system
$command = escapeshellcmd("$python_path -V 2>&1"); // Redirect errors to output
$output = shell_exec($command);
echo "Python Version: " . htmlspecialchars($output);
?>
