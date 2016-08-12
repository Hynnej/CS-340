<?php
/***********************************************************************************************
**Statements to change food table
************************************************************************************************/

//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","hackworj-db","gMQ8b826oBFYJHsd","hackworj-db");
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

//assigns variables to data recieved via post	
$nameFood = $_POST['foodName'];
$cal = $_POST['calories'];
$prot = $_POST['protein'];
$fats = $_POST['fat']; 
$carb = $_POST['carbs'];
$size = $_POST['servingSize'];

if($_POST['change'] == 'AddRow')
{
	//inserts food information into table
	if(!($stmt = $mysqli->prepare("INSERT INTO food(name, calories, protein_grams, fat_grams, carbs_grams, serving_size_grams) VALUES(?,?,?,?,?,?)")))
	{
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	if(!($stmt->bind_param("siiiii",$_POST['foodName'],$_POST['calories'],$_POST['protein'],$_POST['fat'],$_POST['carbs'],$_POST['servingSize'])))
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
		header("Location: food.php");	
	}
}

else if($_POST['change'] == 'Update')
{
	//if calories are entered, updates calories with new amount
	if($cal)
	{	
		if(!($stmt = $mysqli->prepare("UPDATE food SET calories='$cal' WHERE name='$nameFood'")))
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
		header("Location: food.php");
			}
		}
	}
	//if Protien is entered, updates protien with new amount	
	if($prot)
	{	
		if(!($stmt = $mysqli->prepare("UPDATE food SET protein_grams='$prot' WHERE name='$nameFood'")))
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
		header("Location: food.php");
			}
		}
	}	
		//if fat is entered, updates fat with new amount
	if($fats)
	{	
		if(!($stmt = $mysqli->prepare("UPDATE food SET fat_grams='$fats' WHERE name='$nameFood'")))
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
		header("Location: food.php");
			}
		}
	}
		//if carbs is entered, updates carb with new amount
	if($carb)
	{	
		if(!($stmt = $mysqli->prepare("UPDATE food SET carbs_grams='$carb' WHERE name='$nameFood'")))
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
		header("Location: food.php");
			}
		}
	}
	//if serving size is entered, updates servingsize with new amount	
	if($size)
	{	
		if(!($stmt = $mysqli->prepare("UPDATE food SET serving_size_grams='$size' WHERE name='$nameFood'")))
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
		header("Location: food.php");
			}
		}
	}
}

else
{
	//deletes frow from table
	if(!($stmt = $mysqli->prepare("DELETE FROM food WHERE name='$nameFood'")))
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
		header("Location: food.php");
		}
	}
}
	

?>
		