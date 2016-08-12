<?php
/***********************************************************************************************
**Statements to change Recipe table (everything but nutrtional information)
************************************************************************************************/

//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","hackworj-db","gMQ8b826oBFYJHsd","hackworj-db");
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

//assigns variables to data recieved via post		
$nameRecipe = $_POST['recipeName'];
$serv = $_POST['totalServ'];


//adds new recipe to table
if($_POST['change'] == 'AddRow')
{
	if(!($stmt = $mysqli->prepare("INSERT INTO recipe(name, total_servings) VALUES(?,?)")))
	{
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	if(!($stmt->bind_param("si",$_POST['recipeName'], $_POST['totalServ'])))
	{
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
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

//updates servings made for recipe on table
else if($_POST['change'] == 'Update')
{
	if(!($stmt = $mysqli->prepare("UPDATE recipe SET total_servings='$serv' WHERE name='$nameRecipe'")))
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

//deletes recipe from table
else
{
	if(!($stmt = $mysqli->prepare("DELETE FROM recipe WHERE name='$nameRecipe'")))
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