<?php
include 'db.php';

// Sanitize data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check update
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM jerseys WHERE JerseyID = $id");
    $row = $result->fetch_assoc();
    $jerseyName = $row['JerseyName'];
    $jerseyDescription = $row['JerseyDescription'];
    $quantityAvailable = $row['QuantityAvailable'];
    $price = $row['Price'];
}

// Update Data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['jerseyID'];
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

    // Update data if valid
    if ($valid) {
        $stmt = $conn->prepare("UPDATE jerseys SET JerseyName = ?, JerseyDescription = ?, QuantityAvailable = ?, Price = ? WHERE JerseyID = ?");
        $stmt->bind_param("ssidi", $jerseyName, $jerseyDescription, $quantityAvailable, $price, $id);

        if ($stmt->execute()) {
            echo "Record updated successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();

        header("Location: index.php");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FOOTFLIX - Update Jersey</title>
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
        <div class="card-header">Update Jersey</div>
        <div class="card-body">
            <form method="post" action="update.php">
                <input type="hidden" name="jerseyID" value="<?php echo $id; ?>">
                <div class="form-group">
                    <label for="updateJerseyName">Jersey Name</label>
                    <input type="text" class="form-control" id="updateJerseyName" name="jerseyName" value="<?php echo $jerseyName; ?>">
                </div>
                <div class="form-group">
                    <label for="updateJerseyDescription">Jersey Description</label>
                    <textarea class="form-control" id="updateJerseyDescription" name="jerseyDescription"><?php echo $jerseyDescription; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="updateQuantityAvailable">Quantity Available</label>
                    <input type="number" class="form-control" id="updateQuantityAvailable" name="quantityAvailable" value="<?php echo $quantityAvailable; ?>">
                </div>
                <div class="form-group">
                    <label for="updatePrice">Price</label>
                    <input type="text" class="form-control" id="updatePrice" name="price" value="<?php echo $price; ?>">
                </div>
                <button type="submit" name="update" class="btn btn-sporty btn-block">Update</button>
            </form>
        </div>
    </div>
</div>

<footer>
    <p>&copy; Footflix 2024. All Rights Reserved.</p>
</footer>

</body>
</html>
