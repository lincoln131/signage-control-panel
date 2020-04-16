<!DOCTYPE html>
<html>
<head>
	<title>PACT</title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="manifest" href="site.webmanifest">
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/main.css">
</head>

<body>
	<br><br>
<header>Pay Attention in City Traffic</header>

<?php
		/* Connect to the local server and specify the database to use. */
		$serverName = "sps-sql";  							/* Server Name */
		$connectionInfo = array( "Database"=>"signage", 	/* Database */
								"Uid" => "sa", 				/* Username */
								"PWD" => "");				/* Password */
		$conn = sqlsrv_connect( $serverName, $connectionInfo); /* Turn that shit into a usable connection */
		
		if( $conn === false ) /* Error handling for when the database connection string breaks */
			{
					echo "Could not connect.\n";
					die( print_r( sqlsrv_errors(), true));
			}
		
		
		

		/* Set up and execute the query.  */
		$tsql = "SELECT whatmonth,location1,location2,task1,task2,task3,task4 FROM [signage].[dbo].[payattention] WHERE [payattention].[latest] = 1";

		$stmt = sqlsrv_query( $conn, $tsql);  
	
		if( $stmt === false )  /* Error handling for when the query fucks up */
			{
					echo "Error in query preparation/execution.\n";
					die( print_r( sqlsrv_errors(), true));
			} 

		
		/* Retrieve each row as a PHP object and display the results.*/
		while( $obj = sqlsrv_fetch_object( $stmt))
			{
                echo nl2br ("<section>".$obj->whatmonth." Traffic Enforcement Areas"."\n"."</section>"); /* Note the html tags straight up in the echo */
                echo nl2br ("<article>".$obj->location1."\n".$obj->location2."\n"."</article>");		 /* They're there for CSS */
                echo nl2br ("<section>Enforcement Focus - Day & Night</section>");
				echo nl2br ("<article>".$obj->task1."\n".$obj->task2."\n".$obj->task3."\n".$obj->task4."\n"."<article>");
			}

		/* Free statement and connection resources. */
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn);
	?>

</body>
</html>