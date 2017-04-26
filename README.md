# Android-Registration-System

This project is developed to help bootstrap user login/registration system along with the support of Facebook API.
It could sometimes be a real pain in ass just to develop this system again n again for different projects specially when other APIs are to be incorporated. 

## Getting Started
First things first, we need to implement a server side api for our app.

###Server Side
Upload the contents of 'Foodie Doodie API' folder into your web host or local host.

*Make sure the scripts have a priviledge of '0775'*

####Create a database and Tables in Mysql 
```CREATE DATABASE my_db;```
```
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(23) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `image` mediumtext NOT NULL,
  `encrypted_password` varchar(80) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`unique_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;
```
```
CREATE TABLE IF NOT EXISTS `users_fb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `image` mediumtext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`unique_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;
```

####Modify include/Config.php
```
<?php
define("DB_HOST", "localhost");
define("DB_USER", "user");
define("DB_PASSWORD", "password");
define("DB_DATABASE", "db");
?>
```
Change localhost with your host, user with Database user , password with Databse user's password and db with Database name

###Client Side (Android)
Import the project in Android Studio and run gradle to sync libraries.
####Modify /app/src/main/res/values/strings.xml
```
<string name="facebook_app_id">YOUR FACEBOOK APP ID</string>
```
*Create a Facebook app and paste your APP ID here*
All the information regarding this process has been provided by [Facebook] (https://developers.facebook.com/docs/facebook-login/android)

###Modify /app/src/main/java/com/codelycan/foodiedoodie/Util/Config.java
```
package com.codelycan.foodiedoodie.Util;
/**
 * Created by trushain on 4/16/16.
 */
public class Config {

    public static String URL_LOGIN = "http://localhost/folder/register.php";

    // Server user register url
    public static String URL_REGISTER = "http://localhost/folder/register.php";
}
```
*Replace the URLS respectively to the uploaded files*

##That's it!
No need to say Thanks, just don't forget to have fun!
>"There is no time like present, I guess"

## Screenshots

![alt text](https://raw.githubusercontent.com/trushain/Android-Registration-System/master/Screenshots/Screenshot_2016-04-18-17-20-35.png "Login Activity")
![alt text](https://raw.githubusercontent.com/trushain/Android-Registration-System/master/Screenshots/Screenshot_2016-04-18-17-20-43.png "Register Activity")
![alt text](https://raw.githubusercontent.com/trushain/Android-Registration-System/master/Screenshots/Screenshot_2016-04-18-17-21-00.png "Main Activity")

