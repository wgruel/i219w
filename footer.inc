<?php   
    /* 
        Display a little bit of text and the current date 
        date() is a function that formats a local date/time
        date() expects a parameter $format --> date($format)
        This format-string determines how the date will be
        formatted. Some examples: 
        date ("d.m.y") // 09.11.19                    
        date ("D.M.Y") // Sat.Nov.2019
        date ("d.m.Y h:i:s" ) // 09.11.2019 11:57:04
        More information can be found here: 
        https://www.php.net/manual/en/function.date.php    
    */
    echo "<p>It is " . date('l jS \of F Y h:i:s') . "</p>";
?>
