<?php

    /*
        We want to store some text in a file. 
        As we need the text in different places of our
        script, we'll store the filename in a variable. 
        That allows us to change the name easily and in 
        one central location. 
    */
    $filename = "file.txt";

    /*
        DB Configuration
    */
    $link = mysqli_connect("127.0.0.1", "root", "", "i2_19w_phrases");

    if (!$link) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    // mysqli_close($link);


?>