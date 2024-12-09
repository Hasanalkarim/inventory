<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Inventory_Management_System"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from the form
    $name = $conn->real_escape_string($_POST['name']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $email = $conn->real_escape_string($_POST['email']);
    $city = $conn->real_escape_string($_POST['city']);
    $thana = $conn->real_escape_string($_POST['thana']);
    $zip_code = $conn->real_escape_string($_POST['zip_code']);
    $initials = $conn->real_escape_string($_POST['initials']);
    $license = $conn->real_escape_string($_POST['license_number']);
    $NID = $conn->real_escape_string($_POST['nid']);
    // Generate unique IDs
    $locationID = "LOC" . rand(100, 999);
   
    $DNID = $NID; // DNID is the same as NID as it's a foreign key relationship

    // Insert into Location_T
    $sql_location = "INSERT INTO Location_T (locationID, city, thana) 
                     VALUES ('$locationID', '$city', '$thana')";

    // Insert into Stakeholder_T
    $sql_stakeholder = "INSERT INTO Stakeholder_T (NID, locationID, firstName, lastName, gender, initials, registrationDate, stakeholderType) 
                        VALUES ('$NID', '$locationID', '$name', '', '$gender', '$initials', NOW(), 'Distributor')";

    // Insert into Distributor_T
    $sql_distributor = "INSERT INTO Distributor_T (DNID, license) 
                        VALUES ('$DNID', '$license')";

    // Execute the queries
    if ($conn->query($sql_location) === TRUE) {
        if ($conn->query($sql_stakeholder) === TRUE) {
            if ($conn->query($sql_distributor) === TRUE) {
                echo "New distributor added successfully!";
            } else {
                echo "Error inserting into Distributor_T: " . $conn->error;
            }
        } else {
            echo "Error inserting into Stakeholder_T: " . $conn->error;
        }
    } else {
        echo "Error inserting into Location_T: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>
