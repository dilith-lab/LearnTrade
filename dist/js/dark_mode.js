// dark_mode.js

// Function to toggle dark mode
function toggleDarkMode() {
    const body = document.body;
    const modeIcon = document.getElementById('mode'); // Get the icon element
    let darkModeStatus;

    // Check if dark mode is enabled and toggle it
    if (body.classList.contains('dark-mode')) {
        body.classList.remove('dark-mode');
        localStorage.setItem('darkMode', 'disabled');
        darkModeStatus = 'disabled';

        // Change the icon to sun
        modeIcon.classList.remove('fa-moon');
        modeIcon.classList.add('fa-sun');
    } else {
        body.classList.add('dark-mode');
        localStorage.setItem('darkMode', 'enabled');
        darkModeStatus = 'enabled';

        // Change the icon to moon
        modeIcon.classList.remove('fa-sun');
        modeIcon.classList.add('fa-moon');
    }

    // Send the updated dark mode status to the server (session update)
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/dark_mode.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("darkModeStatus=" + darkModeStatus);
}

// Load the dark mode setting from localStorage when the page loads
window.onload = function () {
    const darkModeSetting = localStorage.getItem('darkMode');
    const modeIcon = document.getElementById('mode'); // Get the icon element

    if (darkModeSetting === 'enabled') {
        document.body.classList.add('dark-mode');
        // Set icon to moon
        modeIcon.classList.remove('fa-sun');
        modeIcon.classList.add('fa-moon');
    } else {
        // Set icon to sun
        modeIcon.classList.remove('fa-moon');
        modeIcon.classList.add('fa-sun');
    }

    // Add an event listener for the dark mode toggle button
    document.getElementById('dark-mode-toggle').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default link behavior
        toggleDarkMode();
    });
};
