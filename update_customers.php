<?php
include('db_connection.php');

// Check if CustomerID is set
if(isset($_REQUEST['CustomerID'])) {
    $CustomerID = $_REQUEST['CustomerID'];
    
    $stmt = $connection->prepare("SELECT * FROM customers WHERE CustomerID=?");
    $stmt->bind_param("i", $CustomerID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Name = $row['Name'];
        $Email = $row['Email'];
        $Phone = $row['Phone'];
    } else {
        echo "Customer not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Record in Customers Table</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update customers form -->
    <h2><u>Update Form for Customers</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="Name">Name:</label>
        <input type="text" name="Name" value="<?php echo isset($Name) ? $Name : ''; ?>">
        <br><br>
        <label for="Email">Email:</label>
        <input type="email" name="Email" value="<?php echo isset($Email) ? $Email : ''; ?>">
        <br><br>
        <label for="Phone">Phone:</label>
        <input type="tel" name="Phone" value="<?php echo isset($Phone) ? $Phone : ''; ?>">
        <br><br>
        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $Phone = $_POST['Phone'];
    
    // Update the customer in the database
    $stmt = $connection->prepare("UPDATE customers SET Name=?, Email=?, Phone=? WHERE CustomerID=?");
    $stmt->bind_param("sssi", $Name, $Email, $Phone, $CustomerID);
    $stmt->execute();
    
    // Redirect to view_customers.php
    header('Location: customers.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
