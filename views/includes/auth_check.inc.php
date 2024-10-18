<?php
#
# This function will check if the user logged in or not. If not, user will redirect to the login page.
# This file should include in all files except the login page. 
# 

session_start();

# Check if user is already Logged
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../LT/views/login.php");
    exit();
}
