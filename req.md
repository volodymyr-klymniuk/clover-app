Hey

    Here is a test task for you.
    If you succeed and you will complete it, we are glad to see you at the next stage of interviewing.

Good luck!

Stack:
    Lumen
    PostgreSQL


Task:
Create RESTFull API.

Description:
Create the API to share the company's information for the logged users.
Please use the Repository-Service pattern in your task.


Details:
Create DB migrations for the tables: users, companies, etc.
Suggest the DB structure. Fill the DB with the test data.


User   ---------------<> UserActivity
User   ----------------  Company
                    0.*

Companies -------------  UserCompany
                    \1

Endpoints:

https://domain.com/api/user/register
  — method POST
  — fields: first_name [string], last_name [string], email [string], password [string], phone [string]

https://domain.com/api/user/sign-in
  — method POST
  — fields: email [string], password [string]

Two actions request, update on action
https://domain.com/api/user/recover-password
  — method POST/PATCH 
  — fields: email [string] // allow to update the password via email token
  (todo: disable active account, change state and lock )

Must be available only for authorised users
https://domain.com/api/user/companies
  — method GET
  — fields: title [string], phone [string], description [string]
  — show the companies, associated with the user (by the relation)

Must be available only for authorised users
https://domain.com/api/user/companies
  — method POST
  — fields: title [string], phone [string], description [string]
  — add the companies, associated with the user (by the relation)