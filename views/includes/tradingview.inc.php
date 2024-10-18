<?php
// Define your parameters in PHP
//$widgetWidth = "50%";  // You can set this dynamically based on your needs
//$widgetHeight = "700"; // You can set this dynamically based on your needs
//$widgetSymbol = "CSELK:ASI"; // You can set this dynamically based on your needs

?>

<!-- Include the TradingView script -->
<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>

<script>
    // Function to toggle dark mode
    function toggleDarkMode() {
        const body = document.body;
        const navBar = document.querySelector('nav.main-header'); // Select the nav bar element
        let darkModeStatus;

        // Check if dark mode is enabled and toggle it
        if (body.classList.contains('dark-mode')) {
            body.classList.remove('dark-mode');
            localStorage.setItem('darkMode', 'disabled');
            darkModeStatus = 'disabled';

            // Change nav bar to light mode
            navBar.classList.remove('navbar-dark', 'border-bottom-0');
            navBar.classList.add('navbar-white', 'navbar-light');
        } else {
            body.classList.add('dark-mode');
            localStorage.setItem('darkMode', 'enabled');
            darkModeStatus = 'enabled';

            // Change nav bar to dark mode
            navBar.classList.remove('navbar-white', 'navbar-light');
            navBar.classList.add('navbar-dark', 'border-bottom-0');
        }

        // Send the updated dark mode status to the server (session update)
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/dark_mode.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("darkModeStatus=" + darkModeStatus);
    
        <?php if(isset($widgetSymbol)): ?>
        // Reinitialize the TradingView widget after toggling dark mode
        initializeTradingViewWidget(<?php echo json_encode($widgetWidth); ?>, <?php echo json_encode($widgetHeight); ?>, <?php echo json_encode($widgetSymbol); ?>);
        <?php endif; ?>    
    }

    // Function to initialize or reinitialize the TradingView widget dynamically
    function initializeTradingViewWidget(width, height, symbol) {
        const darkModeSetting = localStorage.getItem('darkMode');
        const theme = darkModeSetting === 'enabled' ? 'dark' : 'light';

        // Remove the existing TradingView widget if it exists
        const widgetContainer = document.getElementById('tradingview-widget');
        if (widgetContainer) {
            widgetContainer.innerHTML = '';  // Clear existing widget content
        }

        // Check if TradingView is defined (to avoid the ReferenceError)
        if (typeof TradingView !== 'undefined') {
            new TradingView.widget({
                "autosize": false,
                "width": width,
                "height": height,
                "symbol": symbol,
                "timezone": "Asia/Colombo",
                "theme": theme,
                "style": "1",
                "locale": "en",
                "withdateranges": true,
                "range": "YTD",
                "allow_symbol_change": true,
                "details": false,
                "calendar": false,
                "container_id": "tradingview-widget"
            });
        } else {
            console.error("TradingView is not defined. Ensure the TradingView script is loaded.");
        }
    }

    // Load the dark mode setting from localStorage when the page loads
    window.onload = function () {
        const darkModeSetting = localStorage.getItem('darkMode');
        const navBar = document.querySelector('nav.main-header'); // Select the nav bar element

        if (darkModeSetting === 'enabled') {
            document.body.classList.add('dark-mode');

            // Set nav bar to dark mode on page load
            navBar.classList.remove('navbar-white', 'navbar-light');
            navBar.classList.add('navbar-dark', 'border-bottom-0');
        } else {
            // Set nav bar to light mode on page load
            navBar.classList.remove('navbar-dark', 'border-bottom-0');
            navBar.classList.add('navbar-white', 'navbar-light');
        }
        <?php if(isset($widgetSymbol)): ?>
        // Initialize the TradingView widget when the page loads with PHP parameters
        initializeTradingViewWidget(<?php echo json_encode($widgetWidth); ?>, <?php echo json_encode($widgetHeight); ?>, <?php echo json_encode($widgetSymbol); ?>);
        <?php endif; ?>
    };

    // Add an event listener for the dark mode toggle button
    document.getElementById('dark-mode-toggle').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default link behavior
        toggleDarkMode();
    });
</script>


