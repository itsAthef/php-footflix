<?php
include 'db.php';

// Function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Insert Data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $valid = true;

    // Validation
    if (empty($_POST["jerseyName"])) {
        $nameErr = "Name is required";
        $valid = false;
    } else {
        $jerseyName = test_input($_POST["jerseyName"]);
    }

    if (empty($_POST["quantityAvailable"]) || !is_numeric($_POST["quantityAvailable"])) {
        $quantityErr = "Quantity is required and must be a number";
        $valid = false;
    } else {
        $quantityAvailable = test_input($_POST["quantityAvailable"]);
    }

    if (empty($_POST["price"]) || !is_numeric($_POST["price"])) {
        $priceErr = "Price is required and must be a number";
        $valid = false;
    } else {
        $price = test_input($_POST["price"]);
    }

    $jerseyDescription = test_input($_POST["jerseyDescription"]);
    $productAddedBy = test_input($_POST["productAddedBy"]);

    // Insert data if valid
    if ($valid) {
        $stmt = $conn->prepare("INSERT INTO jerseys (JerseyName, JerseyDescription, QuantityAvailable, Price, ProductAddedBy) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssids", $jerseyName, $jerseyDescription, $quantityAvailable, $price, $productAddedBy);

        if ($stmt->execute()) {
            header("Location: index.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FOOTFLIX - Add Jersey</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="./index.php">FOOTFLIX</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
            </li>
        </ul>
    </div>
</nav>

<div class="banner"></div>
<h1>FootFlix Admin Portal</h1>

<div class="container">
    <div class="card mt-5">
        <div class="card-header">Add New Jersey</div>
        <div class="card-body">
            <form method="post" action="add.php">
                <div class="form-group">
                    <label for="jerseyName">Jersey Name</label>
                    <input type="text" class="form-control" id="jerseyName" name="jerseyName">
                    <span class="text-danger"><?php echo $nameErr;?></span>
                </div>
                <div class="form-group">
                    <label for="jerseyDescription">Jersey Description</label>
                    <textarea class="form-control" id="jerseyDescription" name="jerseyDescription"></textarea>
                </div>
                <div class="form-group">
                    <label for="quantityAvailable">Quantity Available</label>
                    <input type="number" class="form-control" id="quantityAvailable" name="quantityAvailable">
                    <span class="text-danger"><?php echo $quantityErr;?></span>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" name="price">
                    <span class="text-danger"><?php echo $priceErr;?></span>
                </div>
                <div class="form-group">
                    <label for="productAddedBy">Product Added By</label>
                    <input type="text" class="form-control" id="productAddedBy" name="productAddedBy" value="Athef" readonly>
                </div>
                <button type="submit" name="submit"  class="btn btn-sporty btn-block">Submit</button>
            </form>
        </div>
    </div>
</div>

<footer>
    <p>&copy; Footflix 2024. All Rights Reserved.</p>
</footer>

</body>
</html>
