<?php   
    session_start();   // First we need to start the session 
    session_destroy(); // delete all session varibale

    $last_page = $_SERVER['HTTP_REFERER'];
    //var_dump("Location: " . $last_page);

    // Go back to the previous page
    header("Location: " . $last_page);
?>