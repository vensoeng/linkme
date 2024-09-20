<?php
// Ensure that $item is available and display its value
if (isset($item)) {
    echo "<h1>Details for Item: " . htmlspecialchars($item) . "</h1>";
    // Additional logic to display item details
} else {
    echo "<h1>No Item Selected</h1>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

    </style>
</head>
<body>
    <div class="main-loader">
        <div class="loader-container">
            <div class="loader">
                <div class="inner-circle"></div>
            </div>
            <p>Please wait</p>
        </div>
    </div>
</body>
</html>
