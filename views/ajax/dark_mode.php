<?php
session_start();

// Check if dark-mode status is passed via AJAX
if (isset($_POST['darkModeStatus'])) {
    if ($_POST['darkModeStatus'] === 'enabled') {
        $_SESSION['dark-mode'] = 'on';
    } else {
        $_SESSION['dark-mode'] = 'off';
    }
}
?>