<!--Displays and allows user interaction with shopping_list table-->

<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","hackworj-db","gMQ8b826oBFYJHsd","hackworj-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Meal Planner</title>
  <head>
  <title>Meal Planner - Shopping List</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>

<body>
<div class="container">
	<!--nav bar-->
	<nav class="navbar navbar-light" style="background-color: #e3f2fd;">
		<a class="navbar-brand" href="main.html">OSU CS 340 Final Project</a>
		<ul class="nav navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="food.php">Foods</a>
				</li>		
			<li class="nav-item">
				<a class="nav-link" href="recipes.php">Recipes</a>
				</li>
			<li class="nav-item">
			  <a class="nav-link" href="weeklyMeals.php">Weekly Meal Planner</a>
			</li>
		</ul>
</nav>

		<!--Displays shopping list-->
		<div class="row">
			<div class="col-md-12">	
				<h2 class="text-center">Shopping List</h2>
				<table class="table">
					<thead class="thead-inverse">
					<tr>
						<th>Name</th>
						<th>Quantity</th>
					</tr>
					<?php
					//displays shopping list table
					if(!($stmt = $mysqli->prepare("SELECT F.name, L.quantity FROM food F INNER JOIN shopping_list L ON F.id = L.food_id"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					} 
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($fname, $lquantity)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}	
					while($stmt->fetch()){
						echo "<tr><td>" . $fname . "</td><td>" . $lquantity .  "</td></tr>";
					}
					$stmt->close();
					?>
					</thead>	
				</table>
			</div>
		</div>	
		
<!--form to interact with shopping_list table-->		
		<div class="row">
			<div class="col-md-12 text-center">	
				<h2>Change List</h2>	
				</br>
				<form method="post" action="changeList.php">
				<fieldset class="form-group">
			</div>
		</div>	
				<div class="row">
					<div class="col-md-12 text-center">	
						<legend>Food Name</legend>
						<select class="c-select" name="foodName">
							<option selected>foods</option>						
							<?php
								if(!($stmt = $mysqli->prepare("SELECT id, name FROM food"))){
									echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
								}

								if(!$stmt->execute()){
									echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
								}
								if(!$stmt->bind_result($fId, $fName)){
									echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
								}
								while($stmt->fetch()){
									echo '<option value=" '. $fId. ' "> ' . $fName . '</option>\n';
								}
								$stmt->close();
							?>
						</select>	
				</div>			
			</div>	
			
				<div class="row">
					<div class="col-md-12 text-center">
						<legend>Quantity</legend>
						<p><input type="number" name="quantities" maxlength="8"/></p>
			</div>
			</div>
			

						</br>				
				<div class="row">
					<div class="col-md-12 text-center">
						<p><input type="submit" class="btn btn-success" name="change" value="AddRow"/></p>
				</div>
				</div>					
				<div class="row">
					<div class="col-md-12 text-center">
						<p><input type="submit" class="btn btn-info" name="change" value="Update"/></p>
					</div>
				</div>	
				<div class="row">
					<div class="col-md-12 text-center">
						<p><input type="submit" class="btn btn-danger" name="change" value="DeleteRow"/></p>
					</div>
				</div>	
			</fieldset>	
			</form>

	</div>	
</body>
</html>