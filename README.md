# Time4Type - PHP & mySQL
Application for typing results of football matches, created using PHP & mySQL DB

## Description
Application for typing results of football matches. It works for the current football event - which now is the Champions League 2018/2019. With just few steps it will be avalaible to work for any other football event, supported by the choosen football API.

## Functionality of the application

### MAIN MODULES:

* **_START PAGE_**
  - information panel; with:
    - current football event name
    - next matches' date
    - current ranking leader
  - links to the main modules

![start page](https://zapodaj.net/images/6b32868843681.jpg "start page")

* **_RANKING_**
  - showing actual ranking

* **_UPCOMING MATCHES_**
  - showing the list of matches within the next 3 days

* **_MATCHES HISTORY_**
  - showing the list of completed matches within the current football event
  with the following options:
  - data sorting - by the date
  - data filtering - by the team name

![matches history page](https://zapodaj.net/images/75f535a26f950.jpg "matches history")
![matches history filtered page](https://zapodaj.net/images/84e46b48b16ba.jpg "matches history filtered")

* **_RULES_**
  - showing the rules of the play in the application


### USER MODULES:

* **_LOG MODULE_**
  - allowing the user to log into the application
  - links directing the user to:
    - _Register_ module
    - _Recovery password_ module

* **_REGISTER MODULE_**
  - allowing the new user to register to the application

* **_PASSWORD RECOVERY_**
  - allowing the registered user to recover the access to the application, by:
    - changing the password to the new one containing random letters and numbers
    - sending e-mail with the new password to the user - for the entered e-mail address

* **_ADD NEW TYPES_**
  - allowing the user to enter new types to the application
  - showing list of the upcoming matches within the next 3 days with input fields for the home team and guest team score
  - all the entered scores can be easily sent to the application by pushing the _send entered types_ button

* **_TYPING HISTORY_** with:

  - **OPEN TYPES**
    - showing the list of types for the not started matches
    - allowing the user to delete the type of the selected match for reentering the type with the new score

  - **ClOSED TYPES**
    - showing the types list for the games in play and for the finished games, containing:
      - date, teams, user's type, result of the match, scored points for the type - for the finished games
      - date, teams, user's type, current result of the match, blinking green light - for the games in play
    - showing the sum of the user's points

![typing history page](https://zapodaj.net/images/eb6531253a4f0.jpg "typing history page")

* **_USER DATA CHANGE_**
  - allowing the user to change his e-mail address, or/and to change his password 


## How does the application work?

  - the code calculating the users' scores works in three modules - in the ones showing the users scores: _Main page_, _Ranking_, _User's types_, the procedure checks the users's types with _open_ status in the list of the games got from the API: 
    - if the API data shows that the game is in play, the type's status is being updated for the _in play_ status, and the game's score is being updated for the current result of the match - and the type is no longer available for any changes
    - if the API data shows that the game is finished, the type's status is being updated for the _finished_ status, and the points are being calculated, according to the rules (0, 1 or 3 points)


## Technologies

The application was created using PHP & mySQL DB.

Other technologies used by me for this project: HTML5, CSS, JavaScript, Bootstrap framework

The application uses Fetch to get data from free football API. 

The application uses Google reCAPTCHA Component for protecting the application against bots.

Connections to the mySQL database are established by creating instances of the PDO base class.

Users' passwords are hashed, and the database is protected against sql injection.

The application uses PHPMailer for sending e-mail - in the case of user's forgotten password.

## RWD

Page is fully responsive, there should be no troubles in accessing it on any device. Media queries in css change page layout accordingly to the device viewport size.

![mobile version](https://zapodaj.net/images/06dafc11d547f.jpg "mobile version")

![mobile version](https://zapodaj.net/images/5952dc214b9fc.jpg "mobile version")

![mobile version](https://zapodaj.net/images/d1a6cfcb5908c.jpg "mobile version")

## Installation

If you want to run/develop the code, you need to import types.sql file to your database, and copy all of the components.


