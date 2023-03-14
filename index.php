<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab10</title>
    <link rel="stylesheet" href="styles.css">
    <?php require_once 'login.php'?>

</head>
<body>

    <h1> Musicians </h1>

    <?php
        $conn = new mysqli($hn, $un, $pw, $db);

        // REQUIRED FUNCTIONALITY #3: "If errors occur, 
        //                              they should be notified of the errors and offered options of where to go next." (1 of 7)
        if ($conn->connect_error) die ('FATAL ERROR 1');
        

        if ( !EMPTY($_POST['create']) ){

            // REQUIRED FUNCTIONALITY #6: "Your web form should be secure" (1 of 3)
            $muMusicianID = sanitizeMySQL($conn, $_POST['MusicianID']);
            $muNameID = sanitizeMySQL($conn, $_POST['Name']);
            $muGenre = sanitizeMySQL($conn, $_POST['Genre']);

            // REQUIRED FUNCTIONALITY #3: "If errors occur, 
            //                              they should be notified of the errors and offered options of where to go next." (2 of 7)
            if ($muMusicianID == "") {
		        exit('MusicianID is empty. Select the back arrow');
	        }


            // REQUIRED FUNCTIONALITY #5: "Your web form should validate the information being managed." (1 of 3)
            // Validate that muMusicianID variable is an integer
            $muMusicianID = filter_var($muMusicianID, FILTER_VALIDATE_INT);
            // REQUIRED FUNCTIONALITY #3: "If errors occur, 
            //                              they should be notified of the errors and offered options of where to go next." (3 of 7)
            if ($muMusicianID === false) {
		        exit('MusicianID must be an integer. Select the back arrow');
	        }


            // REQUIRED FUNCTIONALITY #1: "Successful create, read, update, delete of the database tables" (1 of 4)
            // Write an insert query (Create)
            if ($muNameID == "" && $muGenre == "") {
		        $addQuery = "INSERT INTO musician (musicianid, name, genre) VALUES ('$muMusicianID', NULL, NULL)";
	        }
            elseif ($muNameID == "") {
		        $addQuery = "INSERT INTO musician (musicianid, name, genre) VALUES ('$muMusicianID', NULL, '$muGenre')";
	        }
            elseif ($muGenre == "") {
		        $addQuery = "INSERT INTO musician (musicianid, name, genre) VALUES ('$muMusicianID', '$muNameID', NULL)";
	        }
            else {
                $addQuery = "INSERT INTO musician (musicianid, name, genre) VALUES ('$muMusicianID', '$muNameID', '$muGenre')";
            }
            


            $addResult = $conn->query($addQuery);


            // REQUIRED FUNCTIONALITY #2: "your user should be notified of their success on screen with a clear message" (1 of 3)
            // Notify user of insert query (Create)
            echo "Created entry " . $muNameID . ", musician id: " . $muMusicianID . "<br><br>";


        }


        if ( !EMPTY($_POST['delete']) ){

            // REQUIRED FUNCTIONALITY #6: "Your web form should be secure" (2 of 3)
            $muMusicianID = sanitizeMySQL($conn, $_POST['MusicianID']);
            $muNameID = sanitizeMySQL($conn, $_POST['Name']);
            $muGenre = sanitizeMySQL($conn, $_POST['Genre']);

            if ($muMusicianID == "") {
		        exit('MusicianID is empty. Select the back arrow');
	        }


            // REQUIRED FUNCTIONALITY #5: "Your web form should validate the information being managed." (2 of 3)
            // Validate that muMusicianID variable is an integer
            $muMusicianID = filter_var($muMusicianID, FILTER_VALIDATE_INT);

	        if ($muMusicianID === false) {

                // REQUIRED FUNCTIONALITY #3: "If errors occur, 
                //                              they should be notified of the errors and offered options of where to go next." (4 of 7)
		        exit('MusicianID must be an integer. Select the back arrow');
	        }

            
            // REQUIRED FUNCTIONALITY #2: "your user should be notified of their success on screen with a clear message" (2 of 3)
            // Notify user of delete query (Delete)
            echo "Deleted entry: musician id - " . $muMusicianID . "<br><br>";

            // REQUIRED FUNCTIONALITY #1: "Successful create, read, update, delete of the database tables" (2 of 4)
            // Write an insert query (Delete)
            $deleteQuery = "DELETE FROM musician WHERE MusicianID = '$muMusicianID'";
            $deleteResult = $conn->query($deleteQuery);

        }

        if ( !EMPTY($_POST['update']) ){


            // REQUIRED FUNCTIONALITY #6: "Your web form should be secure" (3 of 3)
            $muMusicianID = sanitizeMySQL($conn, $_POST['MusicianID']);
            $muNameID = sanitizeMySQL($conn, $_POST['Name']);
            $muGenre = sanitizeMySQL($conn, $_POST['Genre']);


            // REQUIRED FUNCTIONALITY #3: "If errors occur, 
            //                              they should be notified of the errors and offered options of where to go next." (5 of 7)
            if ($muMusicianID == "") {
		        exit('MusicianID is empty. Select the back arrow');
	        }


            // REQUIRED FUNCTIONALITY #5: "Your web form should validate the information being managed." (3 of 3)
            // Validate that muMusicianID variable is an integer
            $muMusicianID = filter_var($muMusicianID, FILTER_VALIDATE_INT);

            // REQUIRED FUNCTIONALITY #3: "If errors occur, 
            //                              they should be notified of the errors and offered options of where to go next." (6 of 7)
	        if ($muMusicianID === false) {
                
		        exit('MusicianID must be an integer. Select the back arrow');
	        }


            
            // REQUIRED FUNCTIONALITY #2: "your user should be notified of their success on screen with a clear message" (3 of 3)
            // Notify user of updatate query (Update)
            echo "Updated entry musician id: " . $muMusicianID . " to " . $muNameID . " - " . $muGenre . "<br><br>";
            


            // REQUIRED FUNCTIONALITY #1: "Successful create, read, update, delete of the database tables" (3 of 4)
            // Write an insert query (Update)
            if ($muNameID == "" && $muGenre == "") {
		        $updateQuery = "UPDATE musician SET Name = NULL, Genre = NULL WHERE MusicianID = '$muMusicianID'";
	        }
            elseif ($muNameID == "") {
		        $updateQuery = "UPDATE musician SET Name = NULL, Genre = $muGenre WHERE MusicianID = '$muMusicianID'";
	        }
            elseif ($muGenre == "") {
		        $updateQuery = "UPDATE musician SET Name = $muNameID, Genre = NULL WHERE MusicianID = '$muMusicianID'";
	        }
            else {
                $updateQuery = "UPDATE musician SET Name = '$muNameID', Genre = '$muGenre' WHERE MusicianID = '$muMusicianID'";
            }
            

            $updateResult = $conn->query($updateQuery);

        }

        $query = "SELECT * FROM musician";
        $result = $conn->query($query);

        // REQUIRED FUNCTIONALITY #3: "If errors occur, 
        //                              they should be notified of the errors and offered options of where to go next." (7 of 7)
        if (!$result) die ('FATAL ERROR 2');

        $rows = $result->num_rows;


        function sanitizeString($var) {
            
            if (get_magic_quotes_gpc()) {
                $var = stripslashes($var);
                $var = strip_tags($var);
                $var = htmlentities($var);
            }
            return $var;
        }
        function sanitizeMySQL($connection, $var) {
            
            $var = $connection->real_escape_string($var);
            $var = sanitizeString($var);
            return $var;
        }

    ?>
    
    <table>
        <tr>
            <th>MusicianID</th>
            <th>Name</th>
            <th>Genre</th>
        </tr>

        <?php
            for ($i = 0; $i < $rows; $i++) {

                // REQUIRED FUNCTIONALITY #1: "Successful create, read, update, delete of the database tables" (4 of 4)
                // Write an insert query (Read)
                $fullRow = $result->fetch_array(MYSQLI_ASSOC);
                echo '<tr><td>' . $fullRow['MusicianID'] . '</td>';
                echo '<td>' . $fullRow['Name'] . '</td>';
                echo '<td>' . $fullRow['Genre'] . '</td></tr>';
                
            }
        ?>


    </table>
<br>
    <form actions="index.php" method="post">
        MusicianID: <input type="text" name="MusicianID"><br>
        Name: <input type="text" name="Name"><br>
        Genre: <input type="text" name="Genre"><br>
        <input type="submit" name="create" value="ADD RECORD">
        <input type="submit" name="delete" value="DELETE RECORD">
        <input type="submit" name="update" value="UPDATE RECORD">
    </form>

    <?php
        $result->close();
        $conn->close();
    ?>

</body>
</html>