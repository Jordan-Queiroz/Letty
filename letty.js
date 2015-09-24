/*
											Letty (Web Fingerprinting)

	Some important notes:

		* All attributes are gathered in a string. The string that contains all the attributes is splitted 
		  by this script, in order to make a JSON object and send it to 'handledata.php', so the attributes can
		  be saved on the DB. Split is also used to show attributes in the 'index.html'.

		* This fingerprinting is based only in JavaScript.

		* This fingerprinting uses MySQL to save collected attributes.

		* This fingerprinting uses md5 hashing to generate a key.

		* Split are based on the following patterns: "*," and "`".
*/

doFingerPrinting();

// Main function which is reponsible to do the fingerprinting.
function doFingerPrinting() {

	var coreAttributesNav = getCoreAttributesNav();
	var coreAttributesScr = getCoreAttributesScr();
	var pluginsList = getPluginsList();
	var mimeTypesList = getMimeTypesList();

	var attributes = coreAttributesNav + "," + coreAttributesScr + "," + pluginsList + mimeTypesList;
	var key = "";

	attributes = treatAttributes(attributes);
	key = makeKey(attributes);

	verifyDevice(coreAttributesScr[2], attributes, key);

}

// This function is called by doFingerPrinting().
// Getting some attributes from 'navigator' object.
function getCoreAttributesNav() {

	var coreAttributesNav = ['userAgent', 'product', 'productSub', 'cookieEnabled',
							 'vendor', 'platform', 'language', 'languages', 'javaEnabled',
							 'appName', 'appCodeName', 'appVersion', 'oscpu', 'maxTouchPoints'];
	var navAttributesValues = [];
	
	for (attribute in coreAttributesNav) {
		if (typeof navigator[coreAttributesNav[attribute]] !== "undefined") {

			navAttributesValues.push(navigator[coreAttributesNav[attribute]] + "*");
		} else {
			navAttributesValues.push("undefined" + "*");
		}
	}

	return navAttributesValues;
}
// This function is called by doFingerPrinting().
// Getting some attributes from 'screen' object.
function getCoreAttributesScr() {

	var coreAttributesScr = ['colorDepth', 'pixelDepth', 'width', 'height'];

	var scrAttributesValues = [];

	for (attribute in coreAttributesScr) {
		if (typeof screen[coreAttributesScr[attribute]] !== "undefined") {

			scrAttributesValues.push(screen[coreAttributesScr[attribute]] + "*");
		}
		else {
			scrAttributesValues.push("undefined" + "*");
		}
	}

	return scrAttributesValues;
}

// This function is called by doFingerPrinting().
// This function is getting just the plugins' name.
function getPluginsList() {

	var pluginsList = "";

	if (typeof navigator['plugins'] !== "undefined") {
		for (var i = 0; i < navigator.plugins.length; i++) {
			// This verification helps in the split. The split is done based on the "*,"
			if (i == (navigator.plugins.length - 1)) {
				pluginsList += navigator.plugins[i]['name'] + "*,";
			} else {
				pluginsList += navigator.plugins[i]['name'] + ",";
			}
		}
	}

	// Smartphones don't have plugins. So the string will be empty.
	// It is important don't let the string empty, otherwise it will break down the split.
	if (pluginsList == "") {
		pluginsList = "undefined*,";
	}

	return pluginsList;
}

// This function is called by doFingerPrinting().
// This function is getting just the mime types.
function getMimeTypesList() {

	var mimeTypesList = "";

	if (typeof navigator['mimeTypes'] !== "undefined") {		
		for (var i = 0; i < navigator.mimeTypes.length; i++) {
			// This verification helps in the split. The split is done based on the "*,"
			if (i == (navigator.mimeTypes.length - 1)) {
				mimeTypesList += navigator.mimeTypes[i]['type'] + "*,";
			} else {
				mimeTypesList += navigator.mimeTypes[i]['type'] + ",";
			}
		}
	}

	// Smartphones don't have mime types. So the string will be empty.
	// It is important don't let the string empty, otherwise it will break down the split.
	if (mimeTypesList == "") {
		mimeTypesList = "undefined*,"
	}

	return mimeTypesList;
}

// This function is called by doFingerPrinting().
function verifyDevice(screenWidth, attributes, key) {

	/* It removes the "``" and leaves just "`" on this string's last position.
	   This script will splip this string based on the "`".*/
	attributes = attributes.slice(0,(attributes.length - 1));
	
	if (parseInt(screenWidth) <= 900) {
		attributes = attributes + "mobile`";
	} else {
		attributes = attributes + "desktop`";
	}

	saveData(makeJson(attributes, key));
	showData(attributes, key);
}

// This function is called by doFingerPrinting().
/* Here the string in which the attributes are is treated, so that
   this script can process it correctly. */
function treatAttributes(attributes) {

	var attributes = attributes.split("*,");
	var aux = "";
	for (var i in attributes) {
		aux += attributes[i] + "`";
	}

	return aux;
}

// This function is called by doFingerPrinting().
function makeKey(attributes) {

	var key = CryptoJS.MD5(attributes).toString();

	return key;
}

// This function is called by verifyDevice(screenWidth, coreAttributes, key).
function saveData(attributes) {

	// MySQL
	$.post('handledata.php', {"attributes":attributes}, function(data){alert(data);});
}

// This function is called by verifyDevice(screenWidth, coreAttributes, key).
// This function is used just to show the collected data on the html page.
function showData(attributes, key) {

	attributes = attributes + key + "`";
	var attributes = attributes.split("`");

	var ids = ['ua', 'prod', 'prodsub', 'ce', 'vend', 'plat', 'lang', 'langs', 'je', 'an',
			   'ac', 'av', 'os', 'mtp', 'cd', 'pd', 'width', 'height', 'plugs', 'mime', 'dev', 'key'];


	if (attributes[20] == "desktop") {
		image = document.getElementById("image");
		image.setAttribute("src", "images/ferrari_grande.jpg");
		image.setAttribute("width", "1170");
		image.setAttribute("height", "877");
		image.setAttribute("alt", "488 GTB");
	} else {
		image = document.getElementById("image");
		image.setAttribute("src", "images/ferrari_pequena.png");
		image.setAttribute("width", "256");
		image.setAttribute("height", "256");
		image.setAttribute("alt", "360 Modena");
	}

	for(data in attributes) {
		document.getElementById(ids[data]).innerHTML = attributes[data];
	}

}

// This function is called by verifyDevice(screenWidth, attributes, key).
// This function is needed because 'handledata.php' accepts only JSON.
// The next function that will be called will send these data do 'handledata.php'.
function makeJson(attributes, key) {

	attributes = attributes + key + "`";
	var attributes = attributes.split("`");

	attributesJson = new Object();
	attributesJson.userAgent = attributes[0];
	attributesJson.product = attributes[1];
	attributesJson.productSub = attributes[2];
	attributesJson.cookieEnabled = attributes[3];
	attributesJson.vendor = attributes[4];
	attributesJson.platform = attributes[5];
	attributesJson.language = attributes[6];
	attributesJson.languages = attributes[7];
	attributesJson.javaEnabled = attributes[8];
	attributesJson.appName = attributes[9];
	attributesJson.appCodeName = attributes[10];
	attributesJson.appVersion = attributes[11];
	attributesJson.oscpu = attributes[12];
	attributesJson.maxTouchPoints = attributes[13];
	attributesJson.colorDepth = attributes[14];
	attributesJson.pixelDepth = attributes[15];
	attributesJson.width = attributes[16];
	attributesJson.height = attributes[17];
	attributesJson.plugins = attributes[18];
	attributesJson.mimeTypes = attributes[19];
	attributesJson.device = attributes[20];
	attributesJson.key = attributes[21];

	jsonString = JSON.stringify(attributesJson);

	console.log(jsonString);

	return jsonString;
}