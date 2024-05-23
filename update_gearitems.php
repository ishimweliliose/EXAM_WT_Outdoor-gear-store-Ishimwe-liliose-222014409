<?php
include('db_connection.php');

// Check if ItemID is set
if(isset($_REQUEST['ItemID'])) {
    $ItemID = $_REQUEST['ItemID'];
    
    $stmt = $connection->prepare("SELECT * FROM gearitems WHERE ItemID=?");
    $stmt->bind_param("i", $ItemID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Name = $row['Name'];
        $Category = $row['Category'];
        $Price = $row['Price'];
    } else {
        echo "Item not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Record in Gearitems Table</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update gearitems form -->
    <h2><u>Update Form for Gearitems</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="Name">Name:</label>
        <input type="text" name="Name" value="<?php echo isset($Name) ? $Name : ''; ?>">
        <br><br>
        <label for="Category">Category:</label>
        <input type="text" name="Category" value="<?php echo isset($Category) ? $Category : ''; ?>">
        <br><br>
        <label for="Price">Price:</label>
        <input type="number" name="Price" value="<?php echo isset($Price) ? $Price : ''; ?>">
        <br><br>
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $Name = $_POST['Name'];
    $Category = $_POST['Category'];
    $Price = $_POST['Price'];
    
    // Update the gear item in the database
    $stmt = $connection->prepare("UPDATE gearitems SET Name=?, Category=?, Price=? WHERE ItemID=?");
    $stmt->bind_param("ssdi", $Name, $Category, $Price, $ItemID);
    $stmt->execute();
    
    // Redirect to view_gearitems.php
    header('Location: gearitems.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
