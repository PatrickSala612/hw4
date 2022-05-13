<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Lab One</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style>
            .nav {
                padding: 3px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Contacts</h2>
            <div class="nav">
                <a href="create.php" class="btn btn-success">Add Data</a>

                <?php 
            
                    $action = isset($_GET['action']) ? $_GET['action'] :"";

                    if ($action == "deleted"){
                        echo "<div class='alert alert-danger'>Record was deleted</div>";
                    } elseif ($action == "added") {
                        echo "<div class='alert alert-success'>Record was added</div>";
                    }elseif ($action == "updated") {
                        echo "<div class='alert alert-success'>Record was updated</div>";
                    }

                ?>

            </div>
            <table class="table">
                <head>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Title</th>
                        <th>Created Date</th>
                        <th>Modified Date</th>
                    </tr>
                </head>
                <tbody>
                    <?php 
                        include "config/database.php";
                    
                        $query = "SELECT id, name, email, phone, title, createdDate, modifiedDate FROM contacts ORDER by id ASC";

                        $stmt = $con->prepare($query);
                        $stmt->execute();
                        $num = $stmt->rowCount();

                        while($row=$stmt->fetch(PDO :: FETCH_ASSOC)){
                            extract($row);

                            echo "<tr>";
                            echo "  <td>{$id}</td>";
                            echo "  <td>{$name}</td>";
                            echo "  <td>{$email}</td>";
                            echo "  <td>{$phone}</td>";
                            echo "  <td>{$title}</td>";
                            echo "  <td>{$createdDate}</td>";
                            echo "  <td>{$modifiedDate}</td>";
                            echo "  <td>";
                            echo "      <a href='read.php?id={$id}'  class='btn btn-primary btn-sm'>Read</a>";
                            echo "      <a href='update.php?id={$id}'  class='btn btn-warning btn-sm'>Edit</a>";
                            echo "      <a href='#' onclick='delete_user({$id})' class='btn btn-danger btn-sm'>Delete</a>";
                            echo "  </td>";
                            echo "</tr>";
                            
                        }

                    ?>
                </tbody>
            </table>
        </div>

        <script>
            function delete_user(id){
                var answer = confirm("Are you sure you want to delete this user?");
                console.log(answer);
                if (answer) {
                window.location = "delete.php?id="+id;
                }
            }

        </script>
    </body>
</html>