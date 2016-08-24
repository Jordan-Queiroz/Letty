<?php
	# Script used to verify if repeated keys is due a MD5 collision or if it is due to subsequent access.

	# Oppening connection with the database.
	$connection = mysqli_connect("", "", "");
	if (!$connection) {
		die("<p>The database server is not available</p>" .
		"<p>Error code: " . mysqli_connect_errno() .
		": " . mysqli_connect_error() . "</p>");
	}

	# Selecting a database.
	$database  = mysqli_select_db($connection, "");
	if (!$database) {
		die("<p>It was not possible to select the database</p>" .
		"<p>Error code: " . mysqli_errno($connection) .
		": " . mysqli_error($connection) . "<br />");
	}

	# Getting all students in the database.
    $query = "SELECT * FROM clients";
    $clients = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_array($clients)) {

        $key = $row["ckey"];
        $query = "SELECT * FROM dup_clients WHERE dup_clients.ckey = '$key'";
        $dup_clients = mysqli_query($connection, $query);

        while ($row_dup = mysqli_fetch_array($dup_clients)) {
        	if($row["userAgent"] == $row_dup["userAgent"] &&
        	   $row["product"] == $row_dup["product"] &&
        	   $row["productSub"] == $row_dup["productSub"] &&
        	   $row["cookieEnabled"] == $row_dup["cookieEnabled"] &&
        	   $row["vendor"] == $row_dup["vendor"] &&
        	   $row["platform"] == $row_dup["platform"] &&
        	   $row["language"] == $row_dup["language"] &&
        	   $row["languages"] == $row_dup["languages"] &&
        	   $row["javaEnabled"] == $row_dup["javaEnabled"] &&
        	   $row["appName"] == $row_dup["appName"] &&
        	   $row["appCodeName"] == $row_dup["appCodeName"] &&
        	   $row["appVersion"] == $row_dup["appVersion"] &&
        	   $row["oscpu"] == $row_dup["oscpu"] &&
        	   $row["maxTouchPoints"] == $row_dup["maxTouchPoints"] &&
        	   $row["colorDepth"] == $row_dup["colorDepth"] &&
        	   $row["pixelDepth"] == $row_dup["pixelDepth"] &&
        	   $row["width"] == $row_dup["width"] &&
        	   $row["height"] == $row_dup["height"] &&
        	   $row["plugins"] == $row_dup["plugins"] &&
        	   $row["mimeTypes"] == $row_dup["mimeTypes"] &&
        	   $row["device"] == $row_dup["device"]) {
				echo "client " . $key . " is ok <br />";
			} else {
				echo "client " . $key . "collided <br />";
			}
        }
    }
?>
