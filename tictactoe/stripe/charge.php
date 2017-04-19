<?php
session_start();
$fbuid = $_SESSION["fbuid"];
if(intval($fbuid) == 0){
	header("Location: ../");
}

echo "<img style='max-height:100px;' src='https://graph.facebook.com/$fbuid/picture?type=large'>  User Id: " . $fbuid . "<br>";
?>
<?php
require_once("config.php");
      
$token = $_POST['stripeToken'];
    
$customer = \Stripe\Customer::create(array(
		'email' => 'customer@example.com',
		'source' => $token
	));
      
$charge = \Stripe\Charge::create(array(
		'customer' => $customer->id,
		'amount' => 379,
		'description' => 'Example Charge',
		'currency' => 'usd'
	));
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Payment Successful</title>
        <link rel="icon" href="../assets/img/tictactoe-1.png">

        <link href="../assets/css/stripe.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Bahiana" rel="stylesheet">
        <link href="./assets/css/phone-default.css" rel="stylesheet">
    
	</head>

	<body class="stripeBody">
	
		<script>
			var fbuid = "<?php echo "$fbuid" ?>";
		</script>
		<script src="https://www.gstatic.com/firebasejs/3.7.0/firebase.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script src="https://www.gstatic.com/firebasejs/3.6.10/firebase-app.js"></script>
		<script src="https://www.gstatic.com/firebasejs/3.6.10/firebase-auth.js"></script>
		<script src="https://www.gstatic.com/firebasejs/3.6.10/firebase-database.js"></script>
		<script src="https://www.gstatic.com/firebasejs/3.6.10/firebase-messaging.js"></script>
		<script>
			// Initialize Firebase
			var config = {
				apiKey: "AIzaSyALwnsnwRHcliN-8rdC89tfYAQ2HIyeZHI",
				authDomain: "uvu-falcons.firebaseapp.com",
				databaseURL: "https://uvu-falcons.firebaseio.com",
				storageBucket: "uvu-falcons.appspot.com",
				messagingSenderId: "515391920741"
			};
			firebase.initializeApp(config);
			
			var paid = false;
			
			$(document).ready(function(){
				
					firebase.database().ref('users/' + fbuid).set({
							fbuid: fbuid,
							paid: "true"
						});
					
					while (paid != true)
					{
						firebase.database().ref('users/' + fbuid).set({
							fbuid: fbuid,
							paid: "true"
						});
						
						return firebase.database().ref('/users/' + fbuid).once('value').then(function(snapshot) {
							
							try{
								paid = snapshot.val().paid;
						
								if (paid == "true")
								{
									window.location.href = "../public/checkForPending.php?fbuid=<?php echo $fbuid; ?>";
								}
							} catch (e ) {
								
							}

				  
						});
					}
					
				});

			function savedPayment()
			{
				window.location.href = "../public/checkForPending.php?fbuid=<?php echo $fbuid; ?>";
			}
			
			
		</script>
    
		<h1>Successfully charged $3.79</h1>
    
	</body>
</html>
