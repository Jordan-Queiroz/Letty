CREATE DATABASE IF NOT EXISTS devices;
USE devices;

-- This database is being used by the fingerprinting script.
CREATE TABLE IF NOT EXISTS clients(

	userAgent		VARCHAR(200),	
	product			VARCHAR(20),		
	productSub		VARCHAR(20),		
	cookieEnabled	VARCHAR(5),			
	vendor			VARCHAR(20),		
	platform		VARCHAR(20),		
	language		VARCHAR(6),		
	languages		VARCHAR(50),		
	javaEnabled		VARCHAR(5),			
	appName			VARCHAR(200),	
	appCodeName		VARCHAR(200),	
	appVersion		VARCHAR(200),	
	oscpu			VARCHAR(50),		
	maxTouchPoints	VARCHAR(10),				
	colorDepth		VARCHAR(10),				
	pixelDepth		VARCHAR(10),				
	width			VARCHAR(10),			
	height			VARCHAR(10),
    plugins			TEXT,
    mimeTypes		TEXT,
    device			VARCHAR(10),
	ckey 			VARCHAR(200),

	PRIMARY KEY (ckey)
);

CREATE TABLE IF NOT EXISTS dup_clients(

	userAgent		VARCHAR(200),	
	product			VARCHAR(20),		
	productSub		VARCHAR(20),		
	cookieEnabled	VARCHAR(5),			
	vendor			VARCHAR(20),		
	platform		VARCHAR(20),		
	language		VARCHAR(6),		
	languages		VARCHAR(50),		
	javaEnabled		VARCHAR(5),			
	appName			VARCHAR(200),	
	appCodeName		VARCHAR(200),	
	appVersion		VARCHAR(200),	
	oscpu			VARCHAR(50),		
	maxTouchPoints	VARCHAR(10),				
	colorDepth		VARCHAR(10),				
	pixelDepth		VARCHAR(10),				
	width			VARCHAR(10),			
	height			VARCHAR(10),
    plugins			TEXT,
    mimeTypes		TEXT,
    device			VARCHAR(10),
	ckey 			VARCHAR(200)
);

SELECT *
FROM dup_clients AS dc 
WHERE dc.ckey = '6684efbfd5976b1467f695dd3aba1538';

/*INSERT INTO clients (userAgent,product,productSub,cookieEnabled,
					 vendor,platform,language,languages,
					 javaEnabled, appName, appCodeName,appVersion,
					 oscpu,maxTouchPoints,colorDepth,pixelDepth,
					 width,height,id) VALUES  
                     ("google chrome linux","gecko", "20150345", true,
					  "Google Inc.","Linux x86_64","pt_BR", "pt_BR,en_US",
					  true,"chrome geko","Mozilla","39",
					  "x64",0,54,54,1923,730,"x2c34r32dser3bf4");
*/