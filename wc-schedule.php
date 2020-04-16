<!DOCTYPE html>
<html>
<head>
	<title>WC Schedule</title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="manifest" href="site.webmanifest">
	<link rel="stylesheet" href="http://hpd-php/signage/css/normalize.css">
	<link rel="stylesheet" href="http://hpd-php/signage/css/main.css">
</head>

<body>
	<br><br>
<header>WC Schedule</header>

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
		$tsql = "SELECT [id]
					,[year]
					,[month]
					,[day]
					,[lt_am]
					,[lt_flex]
					,[lt_pm]
					,[sgt_am_1]
					,[sgt_am_2]
					,[sgt_am_3]
					,[sgt_pm_1]
					,[sgt_pm_2]
					,[sgt_pm_3]
				FROM [signage].[dbo].[wc_schedule]
				WHERE YEAR(GETDATE()) = year
				AND MONTH(GETDATE()) = month
				AND DAY(GETDATE()) = day";

		$stmt = sqlsrv_query( $conn, $tsql);  
	
		if( $stmt === false )  /* Error handling for when the query fucks up */
			{
					echo "Error in query preparation/execution.\n";
					die( print_r( sqlsrv_errors(), true));
			} 

		
		/* Retrieve each row as a PHP object and display the results.*/
		while( $obj = sqlsrv_fetch_object( $stmt))
			{
				echo nl2br ("<article>"."For the day of: ".$obj->month."-".$obj->day."-".$obj->year."\n"."</article>"."\n");
				echo nl2br ("<heading>"."AM"."</heading>"."\n");
				echo nl2br ("<article>"."Lt. - ".$obj->lt_am."\n");
				echo nl2br ("Sgts. ".$obj->sgt_am_1." - ".$obj->sgt_am_2." - ".$obj->sgt_am_3."</article>"."\n");
				echo nl2br ("<heading>"."FLEX"."</heading>"."\n");
				echo nl2br ("<article>"."Lt. ".$obj->lt_flex."</article>"."\n");
				echo nl2br ("<heading>"."PM"."</heading>"."\n");
				echo nl2br ("<article>"."Lt. ".$obj->lt_pm."\n");
				echo nl2br ("Sgts. ".$obj->sgt_pm_1." - ".$obj->sgt_pm_2." - ".$obj->sgt_pm_3."</article>"."\n");
			}
		/* Free statement and connection resources. */
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn);
	?>

	<!--
<article style="text-align: center;">
	<div class="row">
		<div>For the date of: wc_fill[0]."-".wc_fill[1]."-".wc_fill[2] </div>
	</div>
	<div class="row">
		<div class="column">AM</div>
		<div class="column">FLEX</div>
		<div class="column">PM</div>
	</div>
	<div class="row">
		<div class="column">1</div>
		<div class="column">2</div>
		<div class="column">3</div>
	</div>
	<div class="row">
		<div class="column">1</div>
		<div class="column">2</div>
		<div class="column">3</div>
	</div>
	<div class="row">
		<div class="column">1</div>
		<div class="column">2</div>
		<div class="column">3</div>
	</div>
</article> 
		-->



</body>
</html>