<?php include("includes/a_config.php");?>
<!DOCTYPE html>
<html>
<head>
	<?php include("includes/head-tag-contents.php");?>
</head>
<body style="text-align:center;">

<?php include("includes/design-top.php");?>
<?php include("includes/navigation.php");?>

<div class="container" id="main-content">
	<br>
	<br>
	<br><br>
	<br>
	<br>
	<h1>New Hires</h1>
	
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
$tsql = "SELECT [emlname],[emfname],[radioid],[emdatehire],
		CASE
			WHEN emsection IN ('ADAM','BAKR','CHAR','COMS','DAVI','EDWA','PATR','TRAF','CANI','STRE') THEN 'Patrol'
			WHEN emsection IN ('ADMN','COUR') THEN 'Administration'
			WHEN emsection IN ('QTR','REC','SECU','SUPP','VOL','PARK','DESK','CROS','ANIM','CODE') THEN 'Support Services'
			WHEN emsection IN ('INV','EVID','NARC') THEN 'Investigations'
			WHEN emsection IN ('TELE') THEN 'Telecomunications'
			WHEN emsection IN ('POT') THEN 'Police Officer Trainee'
		END AS section

		FROM [rms8].[dbo].[emmain] 
        WHERE [emdateterm] IS NULL 
        	AND [emtype] in ('CIV','FULL','PART')
			AND [emdatehire] >= GETDATE() -60
		ORDER BY [emdatehire] ASC";

$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in query preparation/execution.\n";
     die( print_r( sqlsrv_errors(), true));
}
/* Retrieve each row as a PHP object and display the results.*/
while( $obj = sqlsrv_fetch_object( $stmt))
{
    echo nl2br ($obj->emlname.", ".$obj->emfname."   -   ".$obj->section."\n");
}
/* Free statement and connection resources. */
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);
?>
<br>





</div>

<?php include("includes/footer.php");?>

</body>
</html>