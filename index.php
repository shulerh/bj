<?php 
error_reporting(0);
session_start();

if (isset($_POST['reset'])){
	session_unset();
}

	
if (empty($_SESSION["gamestate"])){
	$_SESSION["gamestate"] = 1;
	$HandSize = 2;
	$HandVal = 0;
	$DealHandVal = 0;
	$Hand = array();
	$DealHand = array();
	$Cards = LoadDeck(); # Card Array
}else{
	$Hand = $_SESSION["Hand"];
	$Cards = $_SESSION["Cards"];
	$DealHand = $_SESSION["DealHand"];
	$HandSize = $_POST['handsize'];
	$HandVal = $_SESSION['HandVal'];
	$DealHandVal = $_SESSION['DealHandVal'];
}

		# Checks If You Have Pressed Hit #

	if (isset($_POST['submit'])){
		$HandSize = AddCard($HandSize);
	}

		# Checks If New Hand Card Is Needed #

	while (count($Hand) < $HandSize){
		$rCard = randCard($Cards);
		array_push($Hand,$rCard);
		$Cards = ReduceDeck($Cards,$rCard);
		$HandVal= $HandVal + $rCard[1];
	}

		# Checks If New Deal Hand Card Is Needed #

	while (count($DealHand) < 2){
		$rCard = randCard($Cards);
		array_push($DealHand,$rCard);
		$Cards = ReduceDeck($Cards,$rCard);
		$DealHandVal = $DealHandVal + $rCard[1];
	}

		#  Random Card Function #

	function randCard($Cards){
		return $Cards[rand(0,count($Cards)-1)];
	}

		# Adds Another Card #

	function AddCard($HandSize){
		$HandSize = $HandSize + 1;
		return $HandSize;
	}

		# Removes Card From The Deck #
	
	function ReduceDeck($Cards,$rCard){
		$i = 0;
		while ($i <= count($Cards)) {
			if ($Cards[$i][0] == $rCard[0]){
				array_splice($Cards,$i,1);
			}
			++$i;
		}
		return $Cards;
	}


		# Contains The Deck Array #

	function LoadDeck() {
		$Cards = array(
       		array("2H", 2, "Deuce"),
        	array("3H", 3, "Three"),
        	array("4H", 4, "Four"),
        	array("5H", 5, "Five"),
        	array("6H", 6, "Six"),
        	array("7H", 7, "Seven"),
        	array("8H", 8, "Eight"),
        	array("9H", 9, "Nine"),
        	array("10H", 10, "Ten"),
        	array("11H", 10, "Jack"),
        	array("12H", 10, "Queen"),
        	array("13H", 10, "King"),
        	array("14H", 1, "Ace"),
        	array("2D", 2, "Deuce"),
			array("3D", 3, "Three"),
        	array("4D", 4, "Four"),
        	array("5D", 5, "Five"),
        	array("6D", 6, "Six"),
        	array("7D", 7, "Seven"),
        	array("8D", 8, "Eight"),
        	array("9D", 9, "Nine"),
        	array("10D", 10, "Ten"),
        	array("11D", 10, "Jack"),
        	array("12D", 10, "Queen"),
        	array("13D", 10, "King"),
        	array("14D", 1, "Ace"),
        	array("2C", 2, "Deuce"),
        	array("3C", 3, "Three"),
        	array("4C", 4, "Four"),
        	array("5C", 5, "Five"),
        	array("6C", 6, "Six"),
        	array("7C", 7, "Seven"),
        	array("8C", 8, "Eight"),
        	array("9C", 9, "Nine"),
        	array("10C", 10, "Ten"),
        	array("11C", 10, "Jack"),
       		array("12C", 10, "Queen"),
        	array("13C", 10, "King"),
        	array("14C", 1, "Ace"),
        	array("2S", 2, "Deuce"),
        	array("3S", 3, "Three"),
        	array("4S", 4, "Four"),
        	array("5S", 5, "Five"),
        	array("6S", 6, "Six"),
        	array("7S", 7, "Seven"),
        	array("8S", 8, "Eight"),
        	array("9S", 9, "Nine"),
        	array("10S", 10, "Ten"),
        	array("11S", 10, "Jack"),
        	array("12S", 10, "Queen"),
        	array("13S", 10, "King"),
        	array("14S", 1, "Ace"),
    	);
    	return $Cards;
	}

		#Creates Globally Stored Arrays#
		
	$_SESSION["Hand"] = $Hand;
	$_SESSION["Cards"] = $Cards;
	$_SESSION["DealHand"] = $DealHand;
	$_SESSION["HandVal"] = $HandVal;
	$_SESSION["DealHandVal"] = $DealHandVal;


if (!isset($_POST['stand'])){
	if ($HandVal <21){
		# Outcome Screen 1 #
?>

<!DOCTYPE html>
<html>
<head>
<title>
	Blackjack
</title>
<link rel="stylesheet" href="styles.css">
</head>
<!-- BODY -->
<body align="center">


<table border="1" width="100%">

	<tr><td colspan="3" align="center">
		<h1 id="bj">BlackJack</h1>
	</td></tr>

    <tr><td colspan="3" align="center">
		<?php
				# Displays The Player's Cards #
			foreach ($Hand as $curHand){
				echo "<img width=\"200\" height=\"306\" src=\"images/".$curHand[0].".jpg\">";
			}
		?>
	</td></tr>

	<tr><td align="center">
			<!-- Hit Button And Hidden Values -->
		<form align="center" name="BJ Table Hit" method="post">
			<input type="hidden" name="gamestate" value="<?php echo $GameState; ?>">
			<input type="hidden" name="handsize" value="<?php echo $HandSize; ?>">
			<input type="hidden" name="handval" value="<?php echo $HandVal; ?>">
			<input type="hidden" name ="dealhandval" value="<?php echo $DealHandVal; ?>">
			<input type="submit" name="submit" value="HIT" class="button">
		</form>
	</td>
    <td>
        <form align="center" name="BJ Table Stand" method="post">
			<input type="submit" name="stand" value="STAND" class="button">
		</form>
    </td>
	<td align="center" width="50%">
			<!-- New Game Button -->
		<form align="center" name="BJ Table New Game" method="post">
			<input type="submit" name="reset" value="RESET" class="button">
		</form>
	</td></tr>
	
	<tr><td align="center">
		<?php
				# Displays The Dealer's Cards #
			foreach ($DealHand as $DealHandDisplay){
				echo "<img width=\"200\" height=\"306\" src=\"images/BACK.jpg\">";
			}
		?>
	</td></tr>
</table>

<?php }elseif ($HandVal >=22){
		# Outcome Screen 2 #	
?>
<link rel="stylesheet" href="styles.css">
<table align="center">
	
	<tr><td align="center">
		<h1 id="lose" align="center">You Lose</h1>
	</td></tr>
	<tr><td align="center"><h1 class="escd" text-align="center">Your Cards:</h1></td></tr>
	<tr><td colspan="3" align="center" border="1">
		<?php
				# Displays The Player's Cards #
			foreach ($Hand as $curHand){
				echo "<img width=\"200\" height=\"306\" src=\"images/".$curHand[0].".jpg\">";
			}
		?>
	</td></tr>
	<tr><td align="center"><h1 class="escd" text-align="center">Dealer's Cards:</h1></td></tr>
	<tr><td colspan="3" align="center" border="1">
		<?php
				# Displays The Dealer's Cards #
			foreach ($DealHand as $DealHandDisplay){
				echo "<img width=\"200\" height=\"306\" src=\"images/".$DealHandDisplay[0].".jpg\">";
			}
		?>
	</td></tr>
	<form align="center" name="lost" method="post">
	<tr><td align="center">
		<input type="hidden" name="gamestate" value="<?php echo $GameState; ?>">
		<input type="submit" name="reset" value="RESET" class="button">
	</td></tr>
	</form>
</table>
<?php }elseif ($HandVal == 21){
		# Outcome Screen 3 #
?>
<link rel="stylesheet" href="styles.css">
<table align="center">
	<tr><td align="center">
		<h1 id="won" align="center">Wow, good job!</h1>
	</td></tr>
	<tr><td align="center"><h1 class="escd" text-align="center">Your Cards:</h1></td></tr>
	<tr><td colspan="3" align="center" border="1">
		<?php
				# Displays The Player's Cards #
			foreach ($Hand as $curHand){
				echo "<img width=\"200\" height=\"306\" src=\"images/".$curHand[0].".jpg\">";
			}
		?>
	</td></tr>
	<tr><td align="center"><h1 class="escd" text-align="center">Dealer's Cards:</h1></td></tr>
	<tr><td colspan="3" align="center" border="1">
		<?php
				# Displays The Dealer's Cards #
			foreach ($DealHand as $DealHandDisplay){
				echo "<img width=\"200\" height=\"306\" src=\"images/".$DealHandDisplay[0].".jpg\">";
			}
		?>
	</td></tr>
	<form align="center" name="won" method="post">
	<tr><td align="center">
		<input type="submit" name="reset" value="RESET" class="button">
	</td></tr>
	</form>
</table>
<?php
}
}elseif (isset($_POST['stand'])){
	if ($HandVal == 21 | $HandVal < 21 and $DealHandVal < $HandVal){
		# Outcome Screen 4 #
?>
<link rel="stylesheet" href="styles.css">
<table align="center">
	<tr><td align="center">
		<h1 id="won" align="center">Wow, good job!</h1>
	</td></tr>
	<tr><td align="center"><h1 class="escd" text-align="center">Your Cards:</h1></td></tr>
	<tr><td colspan="3" align="center" border="1" >
		<?php
				# Displays The Player's Cards #
			foreach ($Hand as $curHand){
				echo "<img width=\"200\" height=\"306\" src=\"images/".$curHand[0].".jpg\">";
			}
		?>
	</td></tr>
	</br>
	<tr><td align="center"><h1 class="escd" text-align="center">Dealer's Cards:</h1></td></tr>
	<tr><td colspan="3" align="center" border="1" >
		<?php
				# Displays The Dealer's Cards #
			foreach ($DealHand as $DealHandDisplay){
				echo "<img width=\"200\" height=\"306\" src=\"images/".$DealHandDisplay[0].".jpg\">";
			}
		?>
	</td></tr>
	<form align="center" name="won" method="post">
		<tr><td align="center">
			<input type="hidden" name="gamestate" value="<?php echo $GameState; ?>">
			<input type="submit" name="reset" value="RESET" class="button">
		</td></tr>
	</form>
</table>
<?php }elseif ($HandVal < 21 and $DealHandVal > $HandVal){
		# Outcome Screen 5 # 
?>
<link rel="stylesheet" href="styles.css">
<table align="center">
	<tr><td align="center">
		<h1 id="lose" align="center">You Lose</h1>
	</td></tr>
	<tr><td align="center"><h1 class="escd" text-align="center">Your Cards:</h1></td></tr>
	<tr><td colspan="3" align="center" border="1">
		<?php
				# Displays The Player's Cards #
			foreach ($Hand as $curHand){
				echo "<img width=\"200\" height=\"306\" src=\"images/".$curHand[0].".jpg\">";
			}
		?>
	</td></tr>
	<tr><td align="center"><h1 class="escd" text-align="center">Dealer's Cards:</h1></td></tr>
	<tr><td colspan="3" align="center" border="1">
		<?php
				# Displays The Dealer's Cards #
			foreach ($DealHand as $DealHandDisplay){
				echo "<img width=\"200\" height=\"306\" src=\"images/".$DealHandDisplay[0].".jpg\">";
			}
		?>
	</td></tr>
	<form align="center" name="lost" method="post">
	<tr><td align="center">
		<input type="hidden" name="gamestate" value="<?php echo $GameState; ?>">
		<input type="submit" name="reset" value="RESET" class="button">
	</td></tr>
	</form>
</table>
<?php }} ?>
</body>
</html>
