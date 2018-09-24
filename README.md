# Time4Type - PHP & mySQL
Application for typing results of football matches, created using PHP & mySQL DB

## Description
Application for typing results of football matches. It works for the current football event - which now is the Champions League 2018/2019.

### Options available to an unlogged user:

- rules of the typing
- history of the games at the current event
- list of the incoming matches for the next 3 days
- ranking of the users
- registering a new user to the database
- login to the database

### Options available to a logged user:

- entering result types of the incoming matches
- overview of the user's typing history
- possibility to delete selected type and reenter the type once again - if the match hasn't started yet

## Technologies

The application was created using PHP & mySQL DB.

Other technologies used by me for this project: HTML5, CSS, JavaScript, Bootstrap framework

The application uses Fetch to get data from free football API. 

The application uses Google reCAPTCHA Component for protecting the application against bots.

Connections to the mySQL database are established by creating instances of the PDO base class.

Users' passwords are hashed, and the database is protected against sql injection.

## RWD

Page is fully responsive, there should be no troubles in accessing it on any device. Media queries in css changes page layout accordingly to the device viewport size.

## Installation

If you want to run/develop the code, you need to import types.sql file to your database, and copy all of the components.


