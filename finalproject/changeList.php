<?php
/***********************************************************************************************
**Statements to change shopping_list table
************************************************************************************************/

//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","hackworj-db","gMQ8b826oBFYJHsd","hackworj-db");
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

//assigns variables to data recieved via post		
$foodID = $_POST['foodName'];
$amount = $_POST['quantities'];

//adds new item to shopping list
if($_POST['change'] == 'AddRow')
{
	if(!($stmt = $mysqli->prepare("INSERT INTO shopping_list(food_id, quantity) VALUES(?,?)")))
	{
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	if(!($stmt->bind_param("ii",$_POST['foodName'], $_POST['quantities'])))
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
		header("Location: list.php");	
	}
}

//updates quantity of item in list
else if($_POST['change'] == 'Update')
{
	if(!($stmt = $mysqli->prepare("UPDATE shopping_list SET quantity='$amount' WHERE food_id='$foodID'")))
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
		header("Location: list.php");	
		}
	}
}

//deletes item from list
else
{
	if(!($stmt = $mysqli->prepare("DELETE FROM shopping_list WHERE food_id='$foodID'")))
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
			header("Location: list.php");		
		}
	}
}
	

?>