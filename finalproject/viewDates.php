<!--Displays meals between certian dates, as well as, total nutrtional information for time period-->

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
  <title>Meal Planner - Date Search</title>
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
				<a class="nav-link" href="weeklyMeals.php">Weekly Meal Planner</a>
			</li>
				<li class="nav-item">
					<a class="nav-link" href="list.php">Shopping List</a>
				</li>			
			</ul>
		</nav> 
		
		<!--Displays table for meals-->
		<div class="row">
			<div class="col-md-12">	
				<?php
				    /*Creates header showing dates selected*/
					$dateFrom = $_POST['from'];
					$dateTo = $_POST['to'];					
					echo "<h2>" . "Meals from " . $dateFrom . " to " . $dateTo . "</h2>";
				?>	
				<table class="table">
					 <thead class="thead-inverse">
						<tr>
							<th>Date</th>
							<th>Meal Type</th>
							<th>Recipe</th>
						</tr>
					</thead>
					<?php
					/*displays information for the dates selected*/
					if(!($stmt = $mysqli->prepare("SELECT W.date, W.meal_type, R.name FROM weekly_menu W 
													INNER JOIN recipe R ON R.id = W.recipe_id 
													WHERE date between '$dateFrom' and '$dateTo'"))){
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
		<!--Displays nutrtional information-->
		<div class="row">
			<div class="col-md-12">	
				<h2>Total Nutritional infomation</h2>
				<table class="table">
					 <thead class="thead-inverse">
						<tr>
						<th>Total Calories</th>
						<th>Total protein (grams)</th>
						<th>Total fat (grams)</th>
						<th>Total carbs (grams)</th>
						</tr>
					</thead>		

					<?php
					/*sums total calories for the dates selected*/
					if(!($stmt = $mysqli->prepare("SELECT SUM( R.total_calories ) 
													FROM recipe R
													INNER JOIN weekly_menu W ON R.id = W.recipe_id
													WHERE W.date between '$dateFrom' and '$dateTo'"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					} 
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}

					if(!$stmt->bind_result($calories)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}					
					while($stmt->fetch()){
						echo "<tr><td>" . $calories  . "</td>";
					}
					$stmt->close();

					/*sums total protien for the dates selected*/
					if(!($stmt = $mysqli->prepare("SELECT SUM( R.total_protein_grams ) 
													FROM recipe R
													INNER JOIN weekly_menu W ON R.id = W.recipe_id
													WHERE W.date between '$dateFrom' and '$dateTo'"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					} 
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($protien)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}					
					while($stmt->fetch()){
						echo "<td>" . $protien . "</td>";
					}
					$stmt->close();
					
					/*sums total fat for the dates selected*/
					if(!($stmt = $mysqli->prepare("SELECT SUM( R.total_fat_grams ) 
													FROM recipe R
													INNER JOIN weekly_menu W ON R.id = W.recipe_id
													WHERE W.date between '$dateFrom' and '$dateTo'"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					} 
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($fat)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}					
					while($stmt->fetch()){
						echo "<td>" . $fat . "</td>";
					}
					$stmt->close();
					
					/*sums total carbs for the dates selected*/
					if(!($stmt = $mysqli->prepare("SELECT SUM( R.total_carbs_grams ) 
													FROM recipe R
													INNER JOIN weekly_menu W ON R.id = W.recipe_id
													WHERE W.date between '$dateFrom' and '$dateTo'"))){
							echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					} 
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					if(!$stmt->bind_result($carbs)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}					
					while($stmt->fetch()){
						echo "<td>" . $carbs . "</td></tr>";
					}
					$stmt->close();
					?>	
				</table>			
			</div>
		</div>					
	</div>	
</body>
</html>	