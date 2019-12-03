<?php

            include('adminheader.inc');
            /*
                Inlcude our config file
                "Inculde" includes AND evaluates (i.e. executes the PHP code) 
                the specified file.
                Any variables available at that line in the calling file will
                be available within the called file, from that point forward. 
            */
            include('../config.inc');

            // Message variable - if it is set, it will be displayed in an alert...
            $msg = ""; 

            /***
             * 
             * SAVE DATA 
             * 
             */

            /*
                We use the variable $_GET in order to transfer 
                data to our script. $_GET is an associative array 
                of variables passed to the current script via the 
                URL parameters. 

                As we don't want to create error messages when the 
                script is called without any parameter, we have to 
                check if the respective parameters are set. 
                If we don't do that and just call the script, we'll 
                get the an error message like that:
                "Notice: Undefined index: phrase_01 in /Applications/XAMPP/xamppfiles/htdocs/i219w/index.php on line 42"
            */

            if (isset($_GET['phrase_01']) && isset($_GET['phrase_02']) && isset($_GET['phrase_03'])){
                /* 
                    We'll put together the phrase that we just received
                    and store it in a variable called $text. 
                    In order to concatinate a string (i.e. to put a string
                    together), we use the dot operator. To add spaces, 
                    we add empty strings " ". 
                    \n creates a new line. 
                */
                $text = $_GET['phrase_01'] . " ". $_GET['phrase_02'] . " " . $_GET['phrase_03'] . "\n";
                
                // The next line displays the phrase, we just received
                // echo "<p>You entered: " . $text . "</p>";
                
                /*
                    file_put_contents stores the content of the variable
                    $text in a file called $filename. 
                    The optional flag FILE_APPEND adds text to the file
                    instead of recreating the file every time the function 
                    is called. 
                */
                // file_put_contents($filename, $text, FILE_APPEND);

                /*
                    WRITE STATEMENTS INTO DB
                    FIRST step: create a statement.
                */
                $sqlStmt = "INSERT INTO `phrases` (`id`, `phrase`, `publishdate`) VALUES (NULL, '" . $text . "', NOW())";
                // in case of a promlem, display $sqlStmt, copy it and enter it in SQL-area of PhpMyAdmin

                /* 
                    SECOND step: send query to database
                    query sends a query to the currently active database on the 
                    server that's associated with the specified link identifier.
                */
                $result = $link->query($sqlStmt);

                /*
                    THIRD step: handle results / error                
                    $link->error Returns a string description of the last error
                */
                if(!empty($link->error)){
                    echo $link->error;
                    die("error");     
                }

                /* 
                    reload the page in order to remove the URL parameters 
                    -- prevents storing data that has just been submitted over 
                    and over again when you refresh the page. 
                    header() is used to send a raw HTTP header. header() must 
                    be called before any actual output is sent, either by normal 
                    HTML tags, blank lines in a file, or from PHP. It is a very 
                    common error to read code with include, functions, or another
                    file access function, and have spaces or empty lines that
                    are output before header() is called. 

                    $_SERVER is an array containing information such as headers, 
                    paths, and script locations. The entries in this array are created
                    by the web server.
                    $_SERVER['PHP_SELF']: The filename of the currently executing
                    script, relative to the document root. For instance, 
                    $_SERVER['PHP_SELF'] in a script at the address 
                    http://example.com/foo/bar.php would be /foo/bar.php
                */
                header('Location: '. $_SERVER['PHP_SELF']);
                die();            
            }
            
            /***
             * 
             * DELETE DATA 
             * 
             */
            if(isset($_GET['delete-id'])){
                $sqlStmt = "DELETE FROM `phrases` WHERE `phrases`.`id` = " . $_GET['delete-id'];
                $result = $link->query($sqlStmt);            
    
                $deleteCount = 0; 
                if ($link->affected_rows == 0){
                    die ("nichts gelöscht!!!");
                }
                else {
                    $deleteCount = $link->affected_rows; 
                    $msg = $deleteCount .= " Zeilen gelöscht";
                }                
            }




            /***
             * 
             * READ DATA 
             * 
             */

            /* 
                FIRST step: Create SQL-Statement that we need to query the DB
            */

            $sqlStmt = "SELECT * FROM `phrases` ORDER BY id DESC";

            /* 
                SECOND step: submit statememt to DB
            */
           $result = $link->query($sqlStmt);

           if (!empty(mysqli_error($link))){
                echo "ACHTUNG BÖSER FEHLER!!! ";
                echo mysqli_error($link);
                die();
           }

            /* 
                THIRD step: handle results
                if there is more than one row in result set
                store this data in variable $statements

            */
           $statements = array(); 
           
           if ($result->num_rows > 0){
               while($row = mysqli_fetch_assoc($result)){
                   /* 
                    add a new item to $statements array

                    ATTENTION: We put an array into an array here!
                        the statement array contains an associative array
                        with the fields id, phrase, publishdate
                   */
                   $statements[] = array(
                       'id' => $row['id'], 
                       'phrase' => $row['phrase'],
                       'publishdate' => $row['publishdate'] 
                   );


               }
           }
           else {
               echo ("no results found");
           }             

/*             
            // This was used when reading data from a file... 
            // $statements = file_get_contents($filename);
            // $statements = file($filename, FILE_IGNORE_NEW_LINES);
            // var_dump($statements); 
            $i = 1; 
            foreach ($statements as $row){
                echo "<p style='color: rgb(" . $i * 10 .  ", 100, 100)'>";
                echo $row; 
                echo "</p>\n";
                $i++; 
            }
            
            // Testausgabe des Arrays
            // var_dump($statements);
            // print_r($statements); 
    */



        ?>
<!DOCTYPE html>        
<html>
    <head>
            <title>Eine Phrasendreschmaschine!</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <main role="main">
        
        <?php 
                // if msg is set, show msg in layer 
                if ($msg != ""){
                    echo '<div class="alert alert-secondary" role="alert">'; 
                    echo $msg; 
                    echo '</div>'; 
                }
        ?>

        <h1>I say YES to... </h1>

        <div class="row">
                <div class="col-md-10">
                </div>
                <div class="col-md-2">
                    <a href="phrase_add.php"  class="btn btn-success">Add new phrase</a>
               </div>
        </div>

        <hr style="margin: 40px 0px 40px 0px ">

        <?php

            echo "<h4>". count($statements) . " unglaublich großartige Sätze sind schon gespeichert!!! Mehr davon!</h4>"; 


            /*
            // Illustration of a for-loom
            // create a for-loop and read all the elements in $statements
            for ($i = 0; $i < count($statements); $i++){
                print_r "<p>" . $statements[$i] . "</p>";
            }

            */
            
            if (count($statements) > 0){
                // create a foreach-loop... and do the same
                // for each element in the array statements ... 
                // each element is accessible as $stmt (variable name can be chosen freely)
                echo "<table class='table table-striped' style='width: 100%'>";
                echo "<thead class='thead-dark'>"; 
                echo "<tr>"; 
                echo "<th scope='col'>#</th>"; 
                echo "<th scope='col'>Phrase</th>"; 
                echo "<th scope='col'>Date</th>"; 
                echo "<th scope='col'>Delete</th>"; 
                echo "<th scope='col'>Edit</th>"; 
                echo "</tr>"; 
                echo "</thead>";                 
                foreach($statements as $stmt){
                    echo "<tr>";
                        echo "<td>" . $stmt['id'] . "</td>";
                        echo "<td>" . $stmt['phrase'] . "</td>";
                        echo "<td>" . $stmt['publishdate'] . "</td>";
                        echo "<td><a href='?delete-id=" . $stmt['id'] . "'>delete</a></td>"; 
                        echo "<td><a href='phrase_edit.php?edit-id=" . $stmt['id'] . "'>edit</a></td>"; 
                        echo "</tr>";            }
                echo "</table>";
            }
            else {
                echo "No statements found";
            }
        ?>
        </main>

        <?php
            include('../footer.inc');
        ?>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>

</html>

