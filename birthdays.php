<!DOCTYPE html>
<html class="birthday">
<head>
	<title>Birthdays</title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="manifest" href="site.webmanifest">
	<link rel="stylesheet" href="http://hpd-php/signage/css/normalize.css">
	<link rel="stylesheet" href="http://hpd-php/signage/css/main.css">
</head>

<body>
	<br>
<header>Happy Birthday!</header>

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
		$tsql = "SELECT TOP 1 [id]
					,[year]
					,[month]
					,[day]
					
					,[officer]
					,[picture]
					,CASE
						WHEN month = 1 THEN 'January'
						WHEN month = 2 THEN 'February'
						WHEN month = 3 THEN 'March' 
						WHEN month = 4 THEN 'April' 
						WHEN month = 5 THEN 'May' 
						WHEN month = 6 THEN 'June' 
						WHEN month = 7 THEN 'July' 
						WHEN month = 8 THEN 'August' 
						WHEN month = 9 THEN 'September' 
						WHEN month = 10 THEN 'October' 
						WHEN month = 11 THEN 'November' 
						WHEN month = 12 THEN 'December' 
						ELSE 'Error'
					END AS wordmonth
					,CASE
						WHEN RIGHT(day, 1) = 1 then 'st'
						WHEN RIGHT(day, 1) = 2 then 'nd'
						WHEN RIGHT(day, 1) = 3 then 'rd'
						ELSE 'th'
					END AS fancyday
				FROM [signage].[dbo].[birthdays]
				WHERE MONTH(GETDATE()) = month
				ORDER BY NEWID()";

		$stmt = sqlsrv_query( $conn, $tsql);  
	
		if( $stmt === false )  /* Error handling for when the query fucks up */
			{
					echo "Error in query preparation/execution.\n";
					die( print_r( sqlsrv_errors(), true));
			} 

		
		/* Retrieve each row as a PHP object and display the results.*/
		while( $obj = sqlsrv_fetch_object( $stmt))
			{
				echo nl2br ("<section>".$obj->wordmonth.$obj->day.$obj->fancyday."\n"); 
				echo '<img class="headshot"src="data:image/jpeg;base64,'.base64_encode( $obj->picture ).'"/>';
				echo nl2br ("<br>".$obj->officer."</section>"."\n"); 
				
			}
		/* Free statement and connection resources. */
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn);
	?>

</body>
</html>