<?php
	# Here the data will me handled, checked and stored.
	
	# Getting JSON string passed through letty.js.
	$attributes = $_POST["attributes"];

	# Converting JSON string into JSON Object.
	$attributesDecoded = json_decode($attributes, true); 

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


	$result = mysqli_query($connection, $query_clients);
	
	if ($result) {
		echo "Obrigado pela sua colaboração para o nosso experimento. Sua participação é muito importante.";
	} else {
		$result = mysqli_query($connection, $query_dup_clients);
		if ($result) {
			echo "Obrigado pela sua colaboração para o nosso experimento. Sua participação é muito importante (parece que você já participou antes).";
		} else {
			echo "Oops, algo durante a sua participação deu errado";
		}
	}

	mysqli_close($connection);
?>
