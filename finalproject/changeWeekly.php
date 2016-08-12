<?php
/***********************************************************************************************
**Statements to change weekly_meals table
************************************************************************************************/

//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","hackworj-db","gMQ8b826oBFYJHsd","hackworj-db");
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

//assigns variables to data recieved via post		
$startDate = $_POST['start'];	
$type = $_POST['mealType'];	
$recipeID = $_POST['recipeName'];

//Adds meal to table
if($_POST['change'] == 'AddRow')
{
	if(!($stmt = $mysqli->prepare("INSERT INTO weekly_menu(date, meal_type, recipe_id) VALUES('$startDate','$type','$recipeID')")))
	{
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
	else
	{
			if(!$stmt->execute())
		{
			echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
		} 
		else 
		{
			/* Redirect browser */
			header("Location: weeklyMeals.php");	
		}
	}	
}

//updates recipe information on table
else if($_POST['change'] == 'UpdateRecipe')
{	
	if(!($stmt = $mysqli->prepare("UPDATE weekly_menu SET recipe_id='$recipeID' WHERE date='$startDate' and meal_type='$type'")))
	{
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	else
	{	
		if(!$stmt->execute())
		{
			echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
		} 
		else 
		{
		/* Redirect browser */
		header("Location: weeklyMeals.php");	
		}
	}
}

//Updates meal type on table	
else if($_POST['change'] == 'UpdateMeal')
{	
	if(!($stmt = $mysqli->prepare("UPDATE weekly_menu SET meal_type='$type' WHERE date='$startDate' and recipe_id='$recipeID'")))
	{
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	else
	{	
		if(!$stmt->execute())
		{
			echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
		} 
		else 
		{
		/* Redirect browser */
		header("Location: weeklyMeals.php");	
		}
	}
}

//deletes row
else
{
	if(!($stmt = $mysqli->prepare("DELETE FROM weekly_menu WHERE date='$startDate' and meal_type='$type'")))
	{
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
		
	else
	{	
		if(!$stmt->execute())
		{
			echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
		} 
		else 
		{
			/* Redirect browser */
			header("Location: weeklyMeals.php");	
		}
	}
}
	

?>