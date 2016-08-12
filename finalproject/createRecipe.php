<?php
/***********************************************************************************************
**Updates information on the recipe_ingredients table, as well as, caculates total nutritional
**infomation for a recipe and adds to recipe table
************************************************************************************************/

//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","hackworj-db","gMQ8b826oBFYJHsd","hackworj-db");
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

//assigns variables to data recieved via post		
$recipeId = $_POST['recipeName'];
$foodId = $_POST['foodName'];
$serv = $_POST['servings'];	


//adds a food - recipe combo to table
if($_POST['create'] == 'AddRow')
{
	if(!($stmt = $mysqli->prepare("INSERT INTO recipe_ingredients(food_id, recipe_id, servings) 
		VALUES('$foodId','$recipeId','$serv')")))
	{
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

	if(!$stmt->execute())
	{
		echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
	} 
	else 
	{
			/* Redirect browser */
			header("Location: recipes.php");		
	}
}

//Updates servings on table
else if($_POST['create'] == 'Update')
{
	
	
	if(!($stmt = $mysqli->prepare("Update recipe_ingredients SET servings='$serv' WHERE food_id ='$foodId' and recipe_id='$recipeId'")))
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
			header("Location: recipes.php");		
		}
	}
}

//deletes row
else if($_POST['create'] == 'DeleteRow')
{
	if(!($stmt = $mysqli->prepare("DELETE FROM recipe_ingredients 
	WHERE food_id ='$foodId' and recipe_id='$recipeId'")))
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
			header("Location: recipes.php");	
		}
	}
}

//calculates and adds nutritional information to recipe table
else
{
	//calculates calories for recipe
	if(!($stmt = $mysqli->prepare("UPDATE recipe
	SET total_calories=(SELECT SUM(F.calories*RI.servings)  / (SELECT total_servings FROM(Select total_servings From recipe WHERE id='$recipeId') AS Serv)
	From food F 
	INNER JOIN recipe_ingredients RI ON RI.food_id = F.id 
	WHERE RI.recipe_id='$recipeId'
	GROUP BY RI.recipe_id) WHERE id='$recipeId'")))
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
			header("Location: recipes.php");	
		}
	}
	
	//calculates protien for recipe
	if(!($stmt = $mysqli->prepare("UPDATE recipe
	SET total_protein_grams=(SELECT SUM(F.protein_grams*RI.servings)  / (SELECT total_servings FROM(Select total_servings From recipe WHERE id='$recipeId') AS Serv)
	From food F 
	INNER JOIN recipe_ingredients RI ON RI.food_id = F.id 
	WHERE RI.recipe_id='$recipeId'
	GROUP BY RI.recipe_id) WHERE id='$recipeId'")))
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
			header("Location: recipes.php");	
		}
	}	

	//calculates fat for recipe	
	if(!($stmt = $mysqli->prepare("UPDATE recipe
	SET total_fat_grams=(SELECT SUM(F.fat_grams*RI.servings) / (SELECT total_servings FROM(Select total_servings From recipe WHERE id='$recipeId') AS Serv)
	From food F 
	INNER JOIN recipe_ingredients RI ON RI.food_id = F.id 
	WHERE RI.recipe_id='$recipeId'
	GROUP BY RI.recipe_id) WHERE id='$recipeId'")))
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
			header("Location: recipes.php");	
		}
	}

	//calculates carbs for recipe	
	if(!($stmt = $mysqli->prepare("UPDATE recipe
	SET total_carbs_grams=(SELECT SUM(F.carbs_grams*RI.servings)  / (SELECT total_servings FROM(Select total_servings From recipe WHERE id='$recipeId') AS Serv)
	From food F 
	INNER JOIN recipe_ingredients RI ON RI.food_id = F.id 
	WHERE RI.recipe_id='$recipeId'
	GROUP BY RI.recipe_id) WHERE id='$recipeId'")))
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
			header("Location: recipes.php");	
		}
	}		
}	
?>