<!DOCTYPE html>
<html>

<head>
<title>BAKER</title>
<style>
* {
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 33.33%;
  padding: 10px;
  height: 300px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
</style>
</head>

<body style="text-align:center;background-color:#0080c0;">
<font face="verdana" color="white">
<br><br>
<h1>BAKER PACT</h1>

	<div class="row">
		<div class="column">
			<h3># of Self Initiated Calls - Last 30 Days</h3>
				<?php
					/* Connect to the local server using Windows Authentication and
					specify the AdventureWorks database as the database in use. */
					$serverName = "sps-sql";
					$connectionInfo = array( "Database"=>"rms8",
											"Uid" => "PHPUser",
											"PWD" => "HPDphp5551");
					$conn = sqlsrv_connect( $serverName, $connectionInfo);
					
					if( $conn === false )
						{
							 echo "Could not connect.\n";
							 die( print_r( sqlsrv_errors(), true));
						}
					
					/* Set up and execute the query. */
					$tsql = "SELECT CONCAT(emlname,', ',emfname) AS [officername],
									count([incilog].[parent_id]) as totals
			
							FROM [cad].[dbo].[incilog]	
				
							LEFT JOIN [cad].[dbo].[unit]
								ON [incilog].[unitcode] = [unit].[unitcode] 
						
							LEFT JOIN [cad].[dbo].[inmain]
								ON [incilog].[inci_id] = [inmain].[inci_id] 
							
							LEFT JOIN [cad].[dbo].[emmain]
								ON [unit].[officerid] = [emmain].[empl_id] 
							
							WHERE [incilog].[timestamp] > GETDATE() - 30 
								AND descript = 'Cleared'
								AND [inmain].[cancelled] = '0'
								AND [emmain].[emsection] = 'BAKR'
								AND [inmain].[callsource] = 'SELF'
								AND [emmain].[emdateterm] IS NULL
								AND NOT [emmain].[emrank] in ('LT','SGT')
							
							GROUP BY CONCAT(emlname,', ',emfname)
							
							ORDER BY totals DESC";

					$stmt = sqlsrv_query( $conn, $tsql);
					
					if( $stmt === false )
						{
							 echo "Error in query preparation/execution.\n";
							 die( print_r( sqlsrv_errors(), true));
						}
					/* Retrieve each row as a PHP object and display the results.*/
					
					while( $obj = sqlsrv_fetch_object( $stmt))
						{
							echo nl2br ($obj->officername."   -   ".$obj->totals."\n");
						}
					/* Free statement and connection resources. */
					sqlsrv_free_stmt( $stmt);
					sqlsrv_close( $conn);
				?>
			<br><br>
		</div>
		
		<div class="column" >
			<h3># of Dispatched Calls - Last 30 Days</h3>
	
				<?php
				/* Connect to the local server using Windows Authentication and
				specify the AdventureWorks database as the database in use. */
				$serverName = "sps-sql";
				$connectionInfo = array( "Database"=>"rms8",
										"Uid" => "PHPUser",
										"PWD" => "HPDphp5551");
				$conn = sqlsrv_connect( $serverName, $connectionInfo);
				if( $conn === false )
				{
					 echo "Could not connect.\n";
					 die( print_r( sqlsrv_errors(), true));
				}
					/* Set up and execute the query. */
					$tsql = "SELECT CONCAT(emlname,', ',emfname) AS [officername],
									count([incilog].[parent_id]) as totals
			
							FROM [cad].[dbo].[incilog]	
				
							LEFT JOIN [cad].[dbo].[unit]
								ON [incilog].[unitcode] = [unit].[unitcode] 
						
							LEFT JOIN [cad].[dbo].[inmain]
								ON [incilog].[inci_id] = [inmain].[inci_id] 
							
							LEFT JOIN [cad].[dbo].[emmain]
								ON [unit].[officerid] = [emmain].[empl_id] 
							
							WHERE [incilog].[timestamp] > GETDATE() - 30 
								AND descript = 'Cleared'
								AND [inmain].[cancelled] = '0'
								AND [emmain].[emsection] = 'BAKR'
								AND [callsource] in ('PHONE', 'E911','W911')
								AND [emmain].[emdateterm] IS NULL
								AND NOT [emmain].[emrank] in ('LT','SGT')
							
							GROUP BY CONCAT(emlname,', ',emfname)
							
							ORDER BY totals DESC";

				$stmt = sqlsrv_query( $conn, $tsql);
				if( $stmt === false )
				{
					 echo "Error in query preparation/execution.\n";
					 die( print_r( sqlsrv_errors(), true));
				}
				/* Retrieve each row as a PHP object and display the results.*/
				while( $obj = sqlsrv_fetch_object( $stmt))
				{
					echo nl2br ($obj->officername."   -   ".$obj->totals."\n");
				}
				/* Free statement and connection resources. */
				sqlsrv_free_stmt( $stmt);
				sqlsrv_close( $conn);
				?>
			<br><br>
		</div>

		<div class="column" >
			<h3># of Arrests - Last 30 Days</h3>
	
				<?php
					/* Connect to the local server using Windows Authentication and
					specify the AdventureWorks database as the database in use. */
					$serverName = "sps-sql";
					$connectionInfo = array( "Database"=>"rms8",
										"Uid" => "PHPUser",
										"PWD" => "HPDphp5551");
					$conn = sqlsrv_connect( $serverName, $connectionInfo);
					if( $conn === false )
					{
						echo "Could not connect.\n";
						die( print_r( sqlsrv_errors(), true));
					}
					/* Set up and execute the query. */
					$tsql = "SELECT CONCAT(emlname,', ',emfname) AS [officername],
									count([armain].[armainid]) as totals
			
							FROM [rms8].[dbo].[armain]	
								
							LEFT JOIN [rms8].[dbo].[emmain]
										ON [armain].[arre_offcr] = [emmain].[empl_id] 
							
							WHERE [armain].[date_arr] > GETDATE() - 30 
								AND [emmain].[emsection] = 'BAKR'
								AND [emmain].[emdateterm] IS NULL
								AND NOT [emmain].[emrank] in ('LT','SGT')
								
							GROUP BY CONCAT(emlname,', ',emfname)
							
							ORDER BY count([armain].[armainid]) DESC";

					$stmt = sqlsrv_query( $conn, $tsql);
					if( $stmt === false )
					{
						echo "Error in query preparation/execution.\n";
						die( print_r( sqlsrv_errors(), true));
					}
					/* Retrieve each row as a PHP object and display the results.*/
					while( $obj = sqlsrv_fetch_object( $stmt))
					{
						echo nl2br ($obj->officername."   -   ".$obj->totals."\n");
					}
					/* Free statement and connection resources. */
					sqlsrv_free_stmt( $stmt);
					sqlsrv_close( $conn);
				?>
			<br><br>
		</div>
			<br><br>

</div>
<br><br><br>
<br><br><br>
<p>UPDATED ON: <span id="datetime"></span></p>
<script>
var dt = new Date();
document.getElementById("datetime").innerHTML = dt.toLocaleString();
</script>

</font>
</body>
</html>