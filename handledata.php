<?php
	# Here the data will me handled, checked and stored.
	
	# Getting JSON string passed through letty.js.
	$attributes = $_POST["attributes"];

	# Converting JSON string into JSON Object.
	$attributesDecoded = json_decode($attributes, true); 

	# Oppening connection with the database.
	$connection = mysql_connect("localhost", "root", "root");
	if (!$connection) {
		die("<p>The database server is not available</p>" .
		"<p>Error code: " . mysql_connect_errno() .
		": " . mysql_connect_error() . "</p>");
	}

	# Selecting a database.
	$database  = mysql_select_db("devices", $connection);
	if (!$database) {
		die("<p>It was not possible to select the database</p>" .
		"<p>Error code: " . mysql_errno($connection) .
		": " . mysql_error($connection) . "<br />");
	}

	# Getting attributes from JSON Object.
	$userAgent = $attributesDecoded['userAgent'];
	$product = $attributesDecoded['product'];
	$productSub = $attributesDecoded['productSub'];
	$cookieEnabled = $attributesDecoded['cookieEnabled'];
	$vendor = $attributesDecoded['vendor'];
	$platform = $attributesDecoded['platform'];
	$language = $attributesDecoded['language'];
	$languages = $attributesDecoded['languages'];
	$javaEnabled = $attributesDecoded['javaEnabled'];
	$appName = $attributesDecoded['appName'];
	$appCodeName = $attributesDecoded['appCodeName'];
	$appVersion = $attributesDecoded['appVersion'];
	$oscpu = $attributesDecoded['oscpu'];
	$maxTouchPoints = $attributesDecoded['maxTouchPoints'];
	$colorDepth = $attributesDecoded['colorDepth'];
	$pixelDepth = $attributesDecoded['pixelDepth'];
	$width = $attributesDecoded['width']; 
	$height = $attributesDecoded['height'];
	$plugins = $attributesDecoded['plugins'];
	$mimeTypes = $attributesDecoded['mimeTypes'];
	$device = $attributesDecoded['device'];
	$key = $attributesDecoded['key'];

	# Building query. This query is for the first access of a client.
	$query_clients = "INSERT INTO clients (userAgent,product,productSub,cookieEnabled,
			 					   		   vendor,platform,language,languages,javaEnabled,
			 					   		   appName, appCodeName,appVersion,oscpu,
			 					   		   maxTouchPoints,colorDepth,pixelDepth,width,
			 					   		   height,plugins,mimeTypes,device,ckey) VALUES 
     							  		  ('$userAgent','$product','$productSub', '$cookieEnabled',
								   		   '$vendor', '$platform','$language', '$languages',
								   		   '$javaEnabled', '$appName','$appCodeName', '$appVersion',
								   		   '$oscpu', '$maxTouchPoints','$colorDepth', '$pixelDepth',
								   		   '$width', '$height','$plugins', '$mimeTypes',
								   		   '$device', '$key')";

	# Building query. This query is for second access of a client (or for a hashing collision).
	$query_dup_clients = "INSERT INTO dup_clients (userAgent,product,productSub,cookieEnabled,
			 					   		   	   	   vendor,platform,language,languages,javaEnabled,
			 					   		   	   	   appName, appCodeName,appVersion,oscpu,
			 					   		   	   	   maxTouchPoints,colorDepth,pixelDepth,width,
			 					   		   	   	   height,plugins,mimeTypes,device,ckey) VALUES 
     							  		  	  	  ('$userAgent','$product','$productSub', '$cookieEnabled',
								   		   	   	   '$vendor', '$platform','$language', '$languages',
								   		   	   	   '$javaEnabled', '$appName','$appCodeName', '$appVersion',
								   		   	   	   '$oscpu', '$maxTouchPoints','$colorDepth', '$pixelDepth',
								   		   	   	   '$width', '$height','$plugins', '$mimeTypes',
								   		   	   	   '$device', '$key')";


	$result = mysql_query($query_clients, $connection);
	
	if ($result) {
		echo "Your data were recorded.";
	} else {
		$result = mysql_query($query_dup_clients, $connection);
		if ($result) {
			echo "Your data were recorded (duplicated).";
		} else {
			echo "Something wrong occured while trying to record your data.";
		}
	}

	mysql_close($connection);
?>