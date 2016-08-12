<!--Displays and allows user interaction with weekly_meals table-->

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
  <title>Meal Planner - Daily Meals</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>

<body>
	<div class="container">
	<!--Nav bar-->
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
					<a class="nav-link" href="list.php">Shopping List</a>
				</li>				
			</ul>
		</nav> 
		<!--search by dates form-->
		<div class="row">
			<div class="col-md-12 text-center">	
				<form method="post" class="form-inline" action="viewDates.php">
					<div class="form-group">
						<label for="recipeName">Date From</label>
						<input type="date" class="form-control" name="from"/>
						<label for="recipeName">Date To</label>
						<input type="date" class="form-control" name="to">
					</div>
					<input type="submit" class="btn btn-primary" name="viewDate" value="view"/>
				</form>
			</div>
		</div>	
		<!--table for weekly_meals-->
		<div class="row">
			<div class="col-md-12">	
				<h2 class="text-center">Meals</h2>
				<table class="table">
					 <thead class="thead-inverse">
						<tr>
							<th>Date</th>
							<th>Meal Type</th>
							<th>Recipe</th>
						</tr>
					</thead>
					
					<?php
					//displays table
					if(!($stmt = $mysqli->prepare("SELECT W.date, W.meal_type, R.name FROM weekly_menu W INNER JOIN recipe R ON R.id = W.recipe_id"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					} 
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($date, $type, $name)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}	
					while($stmt->fetch()){
						echo "<tr><td>" . $date . "</td><td>" . $type . "</td><td>" . $name . "</td></tr>";
					}
					$stmt->close();
					?>
				</table>
			</div>
		</div>
		
		<!--form to change table-->
		<div class="row">
			<div class="col-md-12 text-center">	
				<h2>Change Table</h2>
				<p>To add a meal, enter date, meal type, and Recipe Name. The combination of date and meal type must be unique</p>
				<p>To change meal Type enter date and recipe, to change recipe enter date and meal type.</p>
				<p>To delete row, enter date and meal type.</p>
				</br>
				<form method="post" action="changeWeekly.php">
					<fieldset class="form-group">

						<legend>Date</legend>
						<p><input type="date" name="start"/></p>

						<legend>Meal Type</legend>
						<select class="c-select" name="mealType">
							<option selected>meal type options</option>
							<option value="breakfast">breakfast</option>
							<option value="midmorning Snack">midmorning snack</option>
							<option value="lunch">lunch</option>
							<option value="afternoon snack">afternoon snack</option>
							<option value="dinner">dinner</option>
							<option value="dessert">dessert</option>
							<option value="preworkout">pre workout</option>
							<option value="postworkout">postworkout</option>	
						</select>
						
						<legend>Recipe Name</legend>
						<select class="c-select" name="recipeName">
							<option selected>Recipes</option>						
							<?php
								//creates drop down box for recipe names
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
		</div>			
				<div class="row">
					<div class="col-md-3">
						<p><input type="submit" class="btn btn-success" name="change" value="AddRow"/></p>
				</div>
					<div class="col-md-3">
						<p><input type="submit" class="btn btn-info" name="change" value="UpdateMeal"/></p>
					</div>
					<div class="col-md-3">					
						<p><input type="submit" class="btn btn-info" name="change" value="UpdateRecipe"/></p>				
					</div>
					<div class="col-md-3">
						<p><input type="submit" class="btn btn-danger" name="change" value="DeleteRow"/></p>
					</div>
				</fieldset>
				</form>
			</div>	
	</div>	
</body>
</html>