This repo contains all of my PHP work from my university class on web server programming. Including my Major project for said class.

You can find the Major Project at: PHP/Lab_Work/Major-Project

Description:
The task for my major work was to create a website for an EV charging company. Users on the site could register and login and then perform various functions including:
- check into a charging location
- check out of a charging location
- Search for a charging location by available, previously used or currently full
- Add, remove or Edit a charging location
- Search for users on the platform (Admin only)
- Manually check out a user (Admin only)

The PHP site uses Sqlite to store user information, charging locations and visits to charging locations

File Explanation:
- Index.php : the homepage and main hub for interacting with the website. Includes the pages for user and admin pages if logged in.
- login.php : a form that when submitted, checks credentials entered to find a match in the database. If one is found, then the user data is saved to the session and the user is logged in
- Register.php : a form that when submitted, checks if the credentials entered are valid. If they are, then a new user is added to the database and the user is logged in
- Stylesheet.css : creates css styling for the entire website
- functions/..
    …/accountFunctions.php : contains functions like register, login and searchLocations. Most pages interact with the sql database through these account functions.
    ../database.php : contains sql queries and database connections, these functions are not called between each other. These sql queries are also sanitised to prevent any unauthorised actions.
- Admin/..
    ../adminPage.php : contains all the functionality for a user logged in with admin privileges
    ../checkInOutPage.php : allows an admin to check a specific user in or out
    ../editLocation.php : form that edits an existing location in the DB
    ../newLocation : form that creates a new location
- User/..
    ../checkInOutPage.php : allows the user to check into or out of a specific location
    ../userPage.php : contains all the functionality a user logged in with user privileges

MindMap:
created a mindmap to track my progress and identify issues during development
The 2 tables that represent the Account and database files
Inside those tables are the functions and the pages that utilise those functions.
A black arrow identifies a function being called from within another function, a blue arrow identifies a function being called inside a webpage, this made it a lot easier to visually traceback errors.

![MindmapImg](mindmap.jpg "MindMap")

