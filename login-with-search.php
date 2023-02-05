<?php

// Connect to the database
$host = "localhost";
$user = "database_user";
$password = "database_password";
$dbname = "database_name";

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Login
if (isset($_POST['login'])) {
    // Escape user inputs for security
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the username exists in the database
    $query = "SELECT password FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Start a session
            session_start();
            $_SESSION['username'] = $username;
            header("Location: welcome.php");
            exit();
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "Incorrect username";
    }
}

// Sign up
if (isset($_POST['signup'])) {
    // Escape user inputs for security
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username or email already exists in the database
    $query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "Username or email already exists";
    } else {
        // Insert the new user into the database
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Sign up successful";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }
}

// Search
if (isset($_POST['search'])) {
    // Escape user inputs for security
    $search_term = mysqli_real_escape_string($conn, $_POST['search_term']);

    // Search for the term in the database
    $query = "SELECT * FROM users WHERE username LIKE '%$search_term%' OR email LIKE '%$search_term%'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr>";
        echo "<th>Username</th>";
        echo "<th>Email</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No results found";
    }
}

// Close the connection
mysqli_close($conn);

?>
