<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Read</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>Read Data</h1>
                <a href="index.php" class="btn btn-success">Return Home</a>
            </div>

            <?php 
                $id = isset($_GET['id']) ?$_GET['id'] :die("Record ID not found");

                include "config/database.php";

                try {
                    $query = "SELECT id, name, email, phone, title, createdDate, modifiedDate FROM contacts WHERE id=? LIMIT 0,1";
                    
                    $stmt = $con->prepare($query);

                    $stmt->bindParam(1,$id);

                    $stmt->execute();

                    $row=$stmt->fetch(PDO::FETCH_ASSOC);

                    $Name = $row["name"];
                    $Email = $row["email"];
                    $Phone = $row["phone"];
                    $Title = $row["title"];
                    $CreatedDate = $row["createdDate"];
                    $ModifiedDate = $row["modifiedDate"];

                } catch (PDOException $e) {
                    die("ERROR: ".$e->getMessage());
                }
            ?>

            <table class="table talbe-hover table-responsive table-bordered">
                <tr>
                    <td>Name</td>
                    <td><?php echo $Name; ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?php echo $Email; ?></td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td><?php echo $Phone; ?></td>
                </tr>
                <tr>
                    <td>Title</td>
                    <td><?php echo $Title; ?></td>
                </tr>
                <tr>
                    <td>Created</td>
                    <td><?php echo $CreatedDate; ?></td>
                </tr>
                <tr>
                    <td>Modified</td>
                    <td><?php echo $ModifiedDate; ?></td>
                </tr>
            </table>

        </div>
    </body>
</html>