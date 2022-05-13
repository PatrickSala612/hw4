<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <h1>Delete.php</h1>
    </body>

    <?php 
    
        $id = isset($_GET['id']) ? $_GET['id'] :die("Record ID not found");

        include "config/database.php";

        //delete queary
        $query = "DELETE FROM contacts WHERE id=?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1,$id);
        

        if($stmt->execute()){
            header("Location: index.php?action=deleted");
        } else {
            die("Error deleting");
        }
        
    ?>

</html>