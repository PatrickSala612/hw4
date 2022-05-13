<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <style>
            .error {
                color: red;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="pageHeader">
                <h1>Add Information</h1>
            </div>
            <?php 

                $Name = "";
                $NameErr = "";
                $isNameValid = false;

                $Email = "";
                $EmailErr = "";
                $isEmailValid = false;

                $Phone = "";
                $PhoneErr = "";
                $isPhoneValid = false;

                $Title = "";
                $TitleErr = "";
                $isTitleValid = false;

            if($_POST) {


                // Name Validation
                if (empty($_POST['NAME'])) {

                    $NameErr = "Required Field";
                    $isNameValid = false;
                } else {
                    $Name = sanitize_input($_POST['NAME']);
                    if (!preg_match("/^[a-zA-Z-' ]*$/", $Name)) {
                        $Name = "Only letters and white space allowed";
                        $isNameValid = false;
                    } else {
                        $isNameValid = true;
                    }
                }

                //Email Validation
                if (empty($_POST['EMAIL'])) {

                    $EmailErr = "Required Field";
                    $isEmailValid = false;
                } else {
                    $Email = sanitize_input($_POST['EMAIL']);
                    if (!preg_match("/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)*(\.[a-zA-Z]{2,3})$/", $Email)) {
                        $EmailErr = "Invalid Syntax";
                        $isEmailValid = false;
                    } else {
                        $isEmailValid = true;
                    }
                }

                //Phone Validation
                if (empty($_POST['PHONE'])) {

                    $PhoneErr = "Required Field";
                    $isPhoneValid = false;
                } else {
                    $Phone = sanitize_input($_POST['PHONE']);
                    if (!preg_match("/^[a-z0-9- ]+$/i", $Phone)) {
                        $PhoneErr = "Numbers only";
                        $isPhoneValid = false;
                    } else {
                        $isPhoneValid = true;
                    }
                }

                //Title Validation
                if (empty($_POST['TITLE'])) {

                    $TitleErr = "Required Field";
                    $isTitleValid = false;
                } else {
                    $Title = sanitize_input($_POST['TITLE']);
                    if (!preg_match("/^[a-zA-Z-' ]*$/", $Title)) {
                        $TitleErr = "Only letters and white space allowed";
                        $isTitleValid = false;
                    } else {
                        $isTitleValid = true;
                    }
                }

                if ($isNameValid && $isEmailValid && $isPhoneValid && $isTitleValid) {
                    
                    include "config/database.php";
                    
                    try {

                        $query = "INSERT INTO contacts SET name =:NAME, email =:EMAIL, phone =:PHONE, title =:TITLE";

                        $stmt = $con->prepare($query); 

                        $Name = htmlspecialchars(strip_tags($_POST['NAME']));
                        $Email = htmlspecialchars(strip_tags($_POST['EMAIL']));
                        $Phone = htmlspecialchars(strip_tags($_POST['PHONE']));
                        $Title = htmlspecialchars(strip_tags($_POST['TITLE']));

                        $stmt->bindParam(':NAME', $Name);
                        $stmt->bindParam(':EMAIL', $Email);
                        $stmt->bindParam(':PHONE', $Phone);
                        $stmt->bindParam(':TITLE', $Title);

                        if ($stmt -> execute()){
                            echo '<div class="alert alert-success" role="alert">Entry Successful</div>';
                            header("Location: index.php?action=added");
                        } else {
                            echo '<div class="alert alert-succeshs" role="alert">Entry failed. Please verify data is correct and resubmit.</div>';
                        }
                        } catch (PDOException $e) {
                            echo "error".$e->getMessage();
                        }
                    }
                }

            function sanitize_input ($data){

                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
      
              }
            
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <table class="table table-hover table-responsive table-bordered">

                    <tr>
                        <td>Name</td>
                        <td>
                            <input type="text" name="NAME" class="form-control">
                            <span class="error"><?php echo $NameErr; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>
                            <input type="text" name="EMAIL" class="form-control">
                            <span class="error"><?php echo $EmailErr; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td>
                            <input type="text" name="PHONE" class="form-control">
                            <span class="error"><?php echo $PhoneErr; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Title</td>
                        <td>
                            <input type="text" name="TITLE" class="form-control">
                            <span class="error"><?php echo $TitleErr; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="Submit" class="btn btn-primary" >
                            <a href="index.php" class="btn btn-danger">Cancel</a>
                        </td>
                    </tr>

                </table>
            </form>
        </div>
    </body>
</html>