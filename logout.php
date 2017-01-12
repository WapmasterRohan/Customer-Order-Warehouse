<?php
session_start(); // access the current session 
// if no session variable exists then redirect the user 
if (! isset($_SESSION['cust_id'])) {
    header("location: index.php");
    exit();
}
// cancel the session and redirect the user: 
else { // cancel the session 
    $_SESSION = array(); // Destroy the variables. 
    
    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finally, destroy the session.
    session_destroy();

    header("location: index.php");
    exit();
}
?>