<!--Displays and allows user interaction with food table-->

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
  <title>Meal Planner - Food Database</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>

<body>
<div class="container">
<!--nav bar-->
	<nav class="navbar navbar-light" style="background-color: #e3f2fd;">
		<a class="navbar-brand" href="main.html">OSU CS 340 Final Project</a>
		<ul class="nav navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="recipes.php">Recipes</a>
				</li>
			<li class="nav-item">
			  <a class="nav-link" href="weeklyMeals.php">Weekly Meal Planner</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="list.php">Shopping List</a>
			</li>			
		</ul>
</nav>

<!--Displays table-->
		<div class="row">
			<div class="col-md-12">	
				<h2 class="text-center">Food Database</h2>
				<table class="table">
					<thead class="thead-inverse">
					<tr>
						<th>Name</th>
						<th>Calories</th>
						<th>protein (grams)</th>
						<th>fat (grams)</th>
						<th>carbs (grams)</th>
						<th>Serving Size (grams)</th>
					</tr>
					<?php
					//displays table
					if(!($stmt = $mysqli->prepare("SELECT name, calories, protein_grams, fat_grams, carbs_grams, serving_size_grams FROM food"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					} 
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($name, $calories, $protein, $fat, $carbs, $serving)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}	
					while($stmt->fetch()){
						echo "<tr><td>" . $name . "</td><td>" . $calories . "</td><td>" . $protein . "</td><td>" . $fat . "</td><td>" . $carbs .  "</td><td>" . $serving .  "</td></tr>";
					}
					$stmt->close();
					?>
					</thead>
				</table>
			</div>
		</div>	
		
		<!--form to change food table-->
		<div class="row">
			<div class="col-md-12 text-center">	
				<h2>Change Table</h2>	
				<p>To add a food, enter food name and nutritional infomation.  Food name must be unique.</p>
				<p>To change food infomation enter name and infomation to change.  Cannot change name at this time.</p>
				<p>To delete food item, enter name</p>
				</br>
				<form method="post" action="changeFood.php">
				<fieldset class="form-group">
			</div>
		</div>	
		<div class="row">
			<div class="col-md-4 text-center">	
						<legend>Name</legend>
						<p><input type="text" name="foodName"/></p>
			</div>			
			<div class="col-md-4 text-center">
						<legend>Calories</legend>
						<p><input type="number" name="calories" max="99999999"/></p>
			</div>			
			<div class="col-md-4 text-center">						
						<legend>Protein</legend>
						<p><input type="number" name="protein" maxlength="8"/></p>
			</div>			
			<div class="col-md-4 text-center">
						<legend>Fat</legend>
						<p><input type="number" name="fat" maxlength="8"/></p>
			</div>			
			<div class="col-md-4 text-center">
						<legend>Carbs</legend>
						<p><input type="number" name="carbs" maxlength="8"/></p>
			</div>			
			<div class="col-md-4 text-center">			
						<legend>serving size</legend>
						<p><input type="number" name="servingSize" maxlength="8"/></p>
			</div>			
		</div>				
				</br>
				<div class="row">
					<div class="col-md-4 text-center">
						<p><input type="submit" class="btn btn-success" name="change" value="AddRow"/></p>
				</div>
					<div class="col-md-4 text-center">
						<p><input type="submit" class="btn btn-info" name="change" value="Update"/></p>
					</div>
					<div class="col-md-4 text-center">
						<p><input type="submit" class="btn btn-danger" name="change" value="DeleteRow"/></p>
					</div>
				</div>	
			</fieldset>		
			</form>
	</div>	

</body>
</html>