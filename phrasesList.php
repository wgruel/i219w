<?php
            /*
                Inlcude our config file
                "Inculde" includes AND evaluates (i.e. executes the PHP code) 
                the specified file.
                Any variables available at that line in the calling file will
                be available within the called file, from that point forward. 
            */
            include('config.inc');




           $sqlStmt = "SELECT * FROM `phrases`";

            /* 
                SECOND step: submit statememt to DB
            */
           $result = $link->query($sqlStmt);

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
                This was used when reading data from a file... 
            
                $statements = file($filename, FILE_IGNORE_NEW_LINES);
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

        <h1>I say YES to... </h1>



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
                echo "</tr>"; 
                echo "</thead>";                 
                foreach($statements as $stmt){
                    echo "<tr>";
                        echo "<td>" . $stmt['id'] . "</td>";
                        echo "<td>" . $stmt['phrase'] . "</td>";
                        echo "<td>" . $stmt['publishdate'] . "</td>";
                    echo "</tr>";            }
                echo "</table>";
            }
            else {
                echo "No statements found";
            }
        ?>
        </main>

        <?php
            include('footer.inc');
        ?>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>

</html>

