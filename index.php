<?php
include('db_connection.php');
include('recommendation.php');

// Function to generate image URL based on the predicted crop
function getCropImage($crop_name) {
    $image_folder = "images/";  // Folder where crop images are stored
    $image_file = strtolower($crop_name) . ".webp";  // Image filename
    $image_path = $image_folder . $image_file;

    if (file_exists($image_path)) {
        return $image_path;
    } else {
        return "images/default.jpg";  // Default image if the crop image is not found
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Crop Recommendation System</title>
</head>
<body>
    <h1>Crop Recommendation System</h1>
    <form method="POST" action="">
        <label for="soil_type">Soil Type:</label>
        <input type="text" id="soil_type" name="soil_type" required><br><br>
        <label for="pH">pH Level:</label>
        <input type="text" id="pH" name="pH" required><br><br>
        <label for="rainfall">Rainfall (mm):</label>
        <input type="text" id="rainfall" name="rainfall" required><br><br>
        <label for="temperature">Temperature (°C):</label>
        <input type="text" id="temperature" name="temperature" required><br><br>
        <input type="submit" value="Get Recommendation">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $soil_type = $_POST['soil_type'];
        $pH = $_POST['pH'];
        $rainfall = $_POST['rainfall'];
        $temperature = $_POST['temperature'];

        echo "Debug: Soil Type: " . htmlspecialchars($soil_type) . "<br>";
        echo "Debug: pH: " . htmlspecialchars($pH) . "<br>";
        echo "Debug: Rainfall: " . htmlspecialchars($rainfall) . "<br>";
        echo "Debug: Temperature: " . htmlspecialchars($temperature) . "<br>";

        // Get the recommended crop name
        $recommended_crop = getCropRecommendation($soil_type, $pH, $rainfall, $temperature);
        echo "Debug: Recommended Crop: " . htmlspecialchars($recommended_crop) . "<br>";

        echo "Recommended Crop: " . htmlspecialchars($recommended_crop) . "<br>";

        // Get the corresponding image for the crop
        $crop_image = getCropImage($recommended_crop);
        echo "<img src='$crop_image' alt='$recommended_crop' width='300'><br>";
    }
    ?>
</body>
</html>
