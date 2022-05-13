<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<title>Update Contact</title>
	</head>
	<body>
		<!-- Container Start -->
		<div class="container">
			<div class="page-header">
				<h1>Edit Contact</h1>
			</div>

			<?php

				#Pulling the record by ID. Making sure the ID exists.
				$id=isset($_GET['id']) ?$_GET['id'] : die("ERROR: ID not found.");

				#include database connection
				include"config/database.php";

				if ($_POST)
				{
					#Set the correct time zone.
					date_default_timezone_set("America/Chicago");

					#Set the modified time and date.
					$DateModified = date("Y-m-d h:i:sa");
					
					try
					{

						#Create query to update the contact.
						$query = "UPDATE contacts SET name = ?, email = ?, phone = ?, title = ?, modifiedDate = ? WHERE id=?";

						#Prepare query for execution
						$stmt = $con -> prepare($query);

						$Name = htmlspecialchars(strip_tags($_POST['Name']));
						$Email = htmlspecialchars(strip_tags($_POST['Email']));
						$Phone = htmlspecialchars(strip_tags($_POST['Phone']));
						$Title = htmlspecialchars(strip_tags($_POST['Title']));
						$id = sanitize_input($id);

						#Bind the parameters
						$stmt -> bindParam(1, $Name);
						$stmt -> bindParam(2, $Email);
						$stmt -> bindParam(3, $Phone);
						$stmt -> bindParam(4, $Title);
						$stmt -> bindParam(5, $DateModified);
						$stmt -> bindParam(6, $id);

						#Execute the query
						if($stmt -> execute())
						{
							echo "<div class='alert alert-success'>Record updated successfully</div>";
                            header("Location: index.php?action=updated");
						}
						else
						{
							echo "<div class='alert alert-danger'>Unable to update the record. Please verify all information is correct then try again.</div>";
						}
					}
					#Get error
					catch (PDOException $e)
					{
						echo "ERROR: ".$e -> getMessage();
					}
				}

				try
				{
					#Prepare Select Query
					$query = "SELECT id, name, email, phone, title, modifiedDate FROM contacts WHERE id=? LIMIT 0,1";
					$stmt = $con -> prepare($query);

					#Bind Parameters
					$stmt -> bindParam(1,$id);

					#Execute Statement
					$stmt -> execute();

					#Convert the PDO object to an array.
					$row = $stmt -> fetch(PDO :: FETCH_ASSOC);

					#Values to fill up (these variables must be different than above.)
					$Name = $row["name"];
					$Email = $row["email"];
					$Phone = $row["phone"];
					$Title = $row["title"];

				}
				#Get error
				catch (PDOException $e)
				{
					echo "ERROR: ".$e -> getMessage();
				}

				#Sanitize the input data
				function sanitize_input ($data)
					{
						$data = trim($data);
						$data = stripslashes($data);
						$data = htmlspecialchars($data);
						return $data;
					}
			?>
			<form action="update.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
				<table class="table table-hover table-responsive table-bordered">
					<tr>
						<td>Title</td>
						<td>
							<input type="text" name="Title" class="form-control" value="<?php echo $Title ; ?>">
						</td>
					</tr>
					<tr>
						<td>Name</td>
						<td>
							<input type="text" name="Name" class="form-control" value="<?php echo $Name ; ?>">
						</td>
					</tr>
					<tr>
						<td>Email Address</td>
						<td>
							<input type="text" name="Email" class="form-control" value="<?php echo $Email ; ?>">
						</td>
					</tr>
					<tr>
						<td>Phone Number</td>
						<td>
							<input type="text" name="Phone" class="form-control" value="<?php echo $Phone ; ?>">
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type="submit" value="Save" name="Submit" class="btn btn-success">
							<a href="index.php" class="btn btn-danger">Home</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<!-- Container End -->
	</body>
</html>