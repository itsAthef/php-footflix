<?php
// Include the database connection file
include 'db.php';

// Delete Data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM jerseys WHERE JerseyID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}

// Retrieve Data
$jerseys = $conn->query("SELECT * FROM jerseys");

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FOOTFLIX</title>
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
                <a class="nav-link" href="./index.php">Home</a>
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
        <div class="card-header">Jersey List</div>
        <div class="card-body">
            <a href="add.php" class="btn btn-sporty btn-block mb-3">Add New Jersey</a>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Product Added By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $jerseys->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['JerseyID']; ?></td>
                            <td><?php echo $row['JerseyName']; ?></td>
                            <td><?php echo $row['JerseyDescription']; ?></td>
                            <td><?php echo $row['QuantityAvailable']; ?></td>
                            <td>$<?php echo $row['Price']; ?></td>
                            <td><?php echo $row['ProductAddedBy']; ?></td>
                            <td>
                                <a href="index.php?delete=<?php echo $row['JerseyID']; ?>" class="btn btn-sporty delete"><i class="fas fa-trash"></i> Delete</a>
                                <a href="update.php?edit=<?php echo $row['JerseyID']; ?>" class="btn btn-sporty update"><i class="fas fa-edit"></i> Update</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<footer>
    <p>&copy; Footflix 2024. All Rights Reserved.</p>
    <p>By Athef</p>
</footer>

</body>
</html>
