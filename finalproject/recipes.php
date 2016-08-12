<!--Displays and allows user interaction with recipe table-->

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
  <title>Meal Planner - Recipe Database</title>
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
			  <a class="nav-link" href="weeklyMeals.php">Weekly Meal Planner</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="list.php">Shopping List</a>
			</li>			
		</ul>
	</nav>
	
	<!--Displays recipe table-->
		<div class="row">
			<div class="col-md-12 text-center">	
				<h2 class="text-center">Recipe Database</h2>
				<table class="table">
					<thead class="thead-inverse">
					<tr>
						<th>Name</th>
						<th>Total Calories</th>
						<th>Total protein (grams)</th>
						<th>Total fat (grams)</th>
						<th>Total carbs (grams)</th>
						<th>Servings Made</th>
					</tr>
					</thead>
					<?php
					//Displays recipe table
					if(!($stmt = $mysqli->prepare("SELECT name, total_calories, total_protein_grams, total_fat_grams, total_carbs_grams, total_servings FROM recipe"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					} 
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($name, $calories, $protein, $fat, $carbs, $servings)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}	
					while($stmt->fetch()){
						echo "<tr><td>" . $name . "</td><td>" . $calories . "</td><td>" . $protein . "</td><td>" . $fat . "</td><td>" . $carbs .  "</td><td>" . $servings .  "</td></tr>";
					}
					$stmt->close();
					?>		
				</table>			
			</div>
		</div>
		<!--Form to view ingredients in single recipe-->
		<div class="row">
			<div class="col-md-12 text-center">	
				<form method="post" class="form-inline" action="viewRecipe.php">
					<div class="form-group">
						<select class="c-select" name="recipeName">
							<option selected>Recipes</option>						
							<?php
							    //creates dropdown box for recipe names
								if(!($stmt = $mysqli->prepare("SELECT id, name FROM recipe"))){
									echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
								}

								if(!$stmt->execute()){
									echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
								}
								if(!$stmt->bind_result($rId, $rName)){
									echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
								}
								while($stmt->fetch()){
									echo '<option value=" '. $rId . ' "> ' . $rName . '</option>\n';
								}
								$stmt->close();
							?>
						</select>
					</div>
					<input type="submit" class="btn btn-primary" name="viewRecipe" value="view recipe"/>
				</form>
			</div>
		</div>	
		
		<!--Form to update recipe table-->
		<div class="row">
			<div class="col-md-6 text-center">	
				<h2>Create, Update, Delete Recipe</h2>
				<p>To add a recipe, enter name, and number of servings, to delete enter name.</p>  
					<p>To change number of servings, enter name and new servings amount.</p>
				</br>
				<form method="post" action="changeRecipe.php">
					<fieldset class="form-group">

						<legend>Name</legend>
						<p><input type="text" name="recipeName"/></p>
						
						<legend>Total Servings</legend>
						<p><input type="number" name="totalServ"  maxlength="8"/></p>

						<p><input type="submit" class="btn btn-success" name="change" value="AddRow"/></p>
						<p><input type="submit" class="btn btn-info" name="change" value="Update"/></p>
						<p><input type="submit" class="btn btn-danger" name="change" value="DeleteRow"/></p>
					</fieldset>
				</form>
			</div>
			
			<!--form to update recipe_ingredients table-->
			<div class="col-md-6 text-center">	
				<h2>Connect Foods to Recipes</h2>
				<p>Enter a food from the food database, recipe name, and servings to connect foods to recipes.</p>
				<p>To change servings, enter recipe name and food name along with correct number of servings</p>
				<p>To delete row, recipe and food name.</p>
				<p>Once all the foods have been entered, click total to update table with nutritional values.</p>
				</br>	
				<form method="post" action="createRecipe.php">
					<fieldset class="form-group">
	
						<legend>food Name</legend>
						<select class="c-select" name="foodName">
							<option selected>foods</option>						
							<?php
							    //creates dropdown box for food names
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
						<legend>Recipe Name</legend>
						<select class="c-select" name="recipeName">
							<option selected>Recipes</option>						
							<?php
							    //creates dropdown box for recipe names
								if(!($stmt = $mysqli->prepare("SELECT id, name FROM recipe"))){
									echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
								}

								if(!$stmt->execute()){
									echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
								}
								if(!$stmt->bind_result($rId, $rName)){
									echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
								}
								while($stmt->fetch()){
									echo '<option value=" '. $rId . ' "> ' . $rName . '</option>\n';
								}
								$stmt->close();
							?>
						</select>	
						
						<legend>Servings of Food Used</legend>
						<p><input type="number" name="servings"  maxlength="8"/></p>
						
						<p><input type="submit" class="btn btn-success" name="create" value="AddRow"/></p>
						<p><input type="submit" class="btn btn-info" name="create" value="Update"/></p>
						<p><input type="submit" class="btn btn-danger" name="create" value="DeleteRow"/></p>
						<p><input type="submit" class="btn btn-primary" name="create" value="Total"/></p>			
					</fieldset>		
				</form>
			</div>
		</div>
	</div>	
</body>
</html>