<!--Displays ingredients for a single recipe-->

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
  <title>Meal Planner - Recipe Details</title>
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
				<li class="nav-item">
					<a class="nav-link" href="list.php">Shopping List</a>
				</li>			
			</ul>
		</nav> 
		
		<!--table display-->
		<div class="row">
			<div class="col-md-12">	
				<?php
					//created a header with recipe name
					$recipeID = $_POST['recipeName'];
					
					//Selects the name of the food and number of servings for the selected recipe
					if(!($stmt = $mysqli->prepare("SELECT name
													FROM recipe
													WHERE id='$recipeID'"))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					} 

					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}

					if(!$stmt->bind_result($rname)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}	
					while($stmt->fetch()){
												echo "<h2>" . $rname . "</h2>";
					}

					$stmt->close();		
				?>	
				<table class="table">
					 <thead class="thead-inverse">
						<tr>
							<th>Food Ingredient</th>
							<th>Servings</th>
						</tr>
					</thead>
					<?php
						//Selects the name of the food and number of servings for the selected recipe
						if(!($stmt = $mysqli->prepare("SELECT F.name, RI.servings 
														FROM food F 
														INNER JOIN recipe_ingredients RI ON RI.food_id=F.id
														WHERE RI.recipe_id='$recipeID'"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
						} 
						
						if(!$stmt->execute()){
							echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}
						if(!$stmt->bind_result($fname, $fservings)){
							echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
						}	
						while($stmt->fetch()){
							echo "<tr><td>" . $fname . "</td><td>"  . $fservings .  "</td></tr>";
						}
						$stmt->close();
					?>	
				</table>			
			</div>
		</div>	
	</div>	
</body>
</html>		