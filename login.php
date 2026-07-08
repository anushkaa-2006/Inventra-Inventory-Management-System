<?php  
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; 

    // Fetch user data
    $query = "SELECT * FROM invetra_admin.users WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Compare plain text password (No hashing)
        if ($password === $user['password']) {
            session_start();
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password'); window.location.href='login_form.php';</script>";
        }
    } else {
        echo "<script>alert('No user found with this email'); window.location.href='login_form.php';</script>";
    }
}
?>
