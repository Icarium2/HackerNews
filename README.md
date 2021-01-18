# HackerNews

<img src="https://media3.giphy.com/media/TF765cKb5lMTl72bSu/giphy.gif?cid=ecf05e47lgug9u7115jjrx5lmiuudz3eh3bjza8tlq2dq42m&rid=giphy.gif>" width="60%">

School Project in PHP/SQL/HTML/CSS/JS for YRGO Web Developers 2020/2021

Required features:

- As a user I should be able to create an account. [X]
- As a user I should be able to login. [X]
- As a user I should be able to logout. [X]
- As a user I should be able to edit my account email, password and biography. [X]
- As a user I should be able to upload a profile avatar image. [X]
- As a user I should be able to create new posts with title, link and description. [X]
- As a user I should be able to edit my posts. [X]
- As a user I should be able to delete my posts. [X]
- As a user I'm able to view most upvoted posts. [X]
- As a user I'm able to view new posts. [X]
- As a user I should be able to upvote posts. [X]
- As a user I should be able to remove upvote from posts. [X]
- As a user I'm able to comment on a post. [X]
- As a user I'm able to edit my comments. [-]
- As a user I'm able to delete my comments. [X]

General requirements:

- The application should be written in HTML, CSS, JavaScript, SQL and PHP.
- The application should be built using a SQLite database with at least four different tables.
- The application should be pushed to a public repository on GitHub.
- The application should be responsive and be built using the method mobile-first.
- The application should be implement secure hashed passwords when signing up.
- The project should contain the files and directories in the resources folder in the root of your repository.
- The project should implement an accessible graphical user interface.
- The project should declare strict types in files containing only PHP code.
- The project should not include any coding errors, warning or notices.
- The project must be tested on at least two of your classmates computers. Add the testers name to the README.md file.
- The project must receive a code review by another student. Add at least 10 comments to the student's README.md file through a pull request. Give feedback to the student below your name. The last student gives feedback to the first student in the list. Add your feedback one day before the presentation.

To access this project:

Clone the repository through the terminal
`$ git clone https://github.com/Icarium2/HackerNews/ `
or through Github Desktop.

Use the command-line to navigate to the repository, fire up your local server with
`$ php -S localhost:8000` (or whatever you like to use)
and get to using the project by navigating to localhost:8000/index.php.

# Review

:star: When not logged in on the home page two warnings appear - "Warning: Undefined array key "user" & "Warning: Trying to access array offset on value of type null". <br>
:star: Pressing Upvote brings up an error - "Fatal error: Uncaught PDOException: SQLSTATE[HY000]: General error: 1 no such column: upvote". <br>
:star: There is a var_dump on line 8 in the posts/update.php file that is active. <br>
:star: The title Hacker News is clickable but does not perform a function. <br>
:star: The code is written clean and readable. <br>
:star: The folder "scripts" in assests containes a .js file which is not included in the project. <br>
:star: All features work as they should! <br>
:star: The about page including the about.php is indeed amazing!
