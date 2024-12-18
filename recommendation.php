<?php
function getCropRecommendation($soil_type, $pH, $rainfall, $temperature) {
    $python_path = 'C:/Python312/python.exe'; // Adjust this path based on your system
    $command = "$python_path predict_crop.py $soil_type $pH $rainfall $temperature 2>&1"; // Command with arguments
    // echo "Debug: Command: " . htmlspecialchars($command) . "<br>"; // Debug the command
    $output = shell_exec($command);
    // echo "Debug: Full Python Script Output: " . htmlspecialchars($output) . "<br>";
    
    // Filter out warnings and only keep the crop recommendation
    $lines = explode("\n", $output);
    $clean_output = '';
    foreach ($lines as $line) {
        if (strpos($line, 'UserWarning') === false && trim($line) !== '') {
            $clean_output = trim($line);
            break;
        }
    }

    return $clean_output;
}
?>
