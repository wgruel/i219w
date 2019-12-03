<?php

            /*** 
             * 
             * Check required parameters... If parameters are missing stop script... 
             * 
             * */ 
            if (!isset($_GET['edit-id'])){
                die("Edit-Id missing!");
            }
            else {
                $editId = $_GET['edit-id'];
            }
            if (isset($_GET['phrase'])){
                $phrase = $_GET['phrase'];
            }

            /**
             * Adminheader... 
             * Checks password stuff...
             */
            include('adminheader.inc');

            /**
             *   Inlcude our config file
             *   "Inculde" includes AND evaluates (i.e. executes the PHP code) 
             *   the specified file.
             *   Any variables available at that line in the calling file will
             *   be available within the called file, from that point forward. 
             */
            include('../config.inc');

            /**
             * 
             * EDIT DATA 
             * 
             */

            // updateSuccess indicates if update has been performed successfully
            $updateSuccess = 0; 
            if (isset($_GET['btn-save'])){
                // create update statement 
                $sqlStmt = "UPDATE `phrases` SET `phrase` = '" . $phrase . "' WHERE `phrases`.`id` = " . $editId . ";";
                $result = $link->query($sqlStmt);
                
                // updateSuccess is set when more than 1 row is updated 
                // - with only one id, we will have only one update -                
                if ($link->affected_rows > 0){
                    $updateSuccess = 1; 
                    // if you want to go back to index page after update, 
                    // uncomment the following line.
                    // header('Location: index.php?msg=Update+Successful');
                }
            }

            /**
             * 
             * Select phrase with respective editId from database in order to 
             * pre-populate the text-field... 
             * 
             */
            $sqlStmt = "SELECT * FROM `phrases` WHERE `id` = " . $editId;
            $result = $link->query($sqlStmt);
            $row = mysqli_fetch_row($result); 

            // store current phrase in this row... 
            $currentPhrase = $row[1];

        ?>
<!DOCTYPE html>        
<html>
    <head>
            <title>Eine Phrasendreschmaschine!</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <main role="main">

        <h1>Edit this phrase... </h1>


        <!-- a form tag -->
        <form>
            <?php 
                // if update has been performed successfully, show an 
                // alert-layer.... 
                if ($updateSuccess > 0){
            ?>
                    <div class="alert alert-primary" role="alert">
                        Update successful!<br>
                        Back to <a href="index.php">index </a>                        
                    </div>
            <?php
                }
            ?>

            <div class="row">
                <div class="col-md-9">
                    <input type="text" name="phrase" class="form-control" value="<?php echo $currentPhrase ?>">
                    </input>
                    <input type="hidden" name="edit-id" value="<?php echo $editId ?>">
                </div>
            </div>        
            <div class="row" style="margin-top: 20px">
                <div class="col-md-6">please submit your phrase
                </div>
                <div class="col-md-3">
                    <input type="submit" name="btn-save" class="form-control btn btn-success">
                </div>
            </div>
        </div>

        </form>
        </main>

        <?php
            include('../footer.inc');
        ?>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>

</html>

