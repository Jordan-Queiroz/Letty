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
	javaEnabled		VARCHAR(100),			
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

	id				INT				NOT NULL	AUTO_INCREMENT,
	userAgent		VARCHAR(200),	
	product			VARCHAR(20),		
	productSub		VARCHAR(20),		
	cookieEnabled	VARCHAR(5),			
	vendor			VARCHAR(20),		
	platform		VARCHAR(20),		
	language		VARCHAR(6),		
	languages		VARCHAR(50),		
	javaEnabled		VARCHAR(100),			
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
    
    PRIMARY KEY(id)
);