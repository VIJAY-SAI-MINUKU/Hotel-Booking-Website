<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = "";     // Replace with your database password
$dbname = "hoteldetails";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    
    // Query to check if the user exists
    $sql = "SELECT * FROM logindetails WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists
        $user = $result->fetch_assoc();
        echo "<h2>Welcome back, " . htmlspecialchars($user['fullname']) . "!</h2>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($user['email']) . "</p>";
        echo "<p><strong>Age:</strong> " . htmlspecialchars($user['age']) . "</p>";
        echo "<p><strong>Gender:</strong> " . htmlspecialchars($user['gender']) . "</p>";
        echo "<p><strong>Mobile:</strong> " . htmlspecialchars($user['mobile']) . "</p>";
        echo "<p><strong>Address:</strong> " . htmlspecialchars($user['address']) . "</p>";
    } else {
        // New user registration
        if (isset($_POST['fullname'], $_POST['age'], $_POST['gender'], $_POST['mobile'], $_POST['address'])) {
            $fullname = $conn->real_escape_string($_POST['fullname']);
            $age = $conn->real_escape_string($_POST['age']);
            $gender = $conn->real_escape_string($_POST['gender']);
            $mobile = $conn->real_escape_string($_POST['mobile']);
            $address = $conn->real_escape_string($_POST['address']);
            
            // Insert new user details
            $insertSql = "INSERT INTO logindetails (fullname, age, gender, mobile, address, email, password) 
                          VALUES ('$fullname', '$age', '$gender', '$mobile', '$address', '$email', '$password')";
            
            if ($conn->query($insertSql) === TRUE) {
                echo "<h2>Registration successful! Welcome, $fullname.</h2>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>User not found, and registration details are incomplete.</p>";
        }
    }
}

$conn->close();
?>
