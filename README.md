# HouseAPI

This is a REST API developed for a fictitious online property company using PHP and json file database.

The API allows client app to consume house data by requesting for a particular house by id or get all
available houses when no id is provided.

## REST API CRUD
The API allows GET, POST, PUT and DELETE.

## url
1. http://server_base/index.php           - to get all properties
2. http://server_base/index.php?house=id  - to get a particular property

## Add, Edit and Delete
There is an admin page admin.html that allows for adding new record, edit record and delete record
using POST, PUT and DELETE HTTP request. Url -> http://server_base/admin.html