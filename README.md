
* * *

1\. Getting Started
-------------------

Follow these detailed steps to set up the environment and prepare the database for the application:

### 1.1 Build the Image and Start the Containers

In the command line, navigate to the directory containing the `docker-compose.yml` file and run the following commands:

```bash
docker-compose up --build -d docker-compose exec app composer install
```

These commands will build the Docker image, start the necessary containers for the application and database, and install the required PHP dependencies.

### 1.2 Create the Database Schema

Once the containers are running, proceed to create the database schema:

*   Access the application container and execute the Doctrine command to create the database schema:

```bash
docker-compose exec app php bin/console doctrine:schema:create
```

### 1.3 Load Data from a CSV File

With the database set up, you can load data from a CSV file into the database:

*   **Locate the CSV File:** Ensure the CSV file containing the data is accessible from the container or copied inside it.
    
*   **Run the Data Import Command:** Inside the container, use the following command to import data from the CSV file. Make sure the CSV file has the following headers:
    

```
| competition | player.url | id  | slug | name | nickname | firstname | lastname | gender | date_of_birth | place_of_birth | weight | height | international | twitter | instagram | country | team | team.shortname | team.foundation | team.shield | shirt_number | position | photo | stadium | stadium.image |
|-------------|------------|-----|------|------|----------|-----------|----------|--------|---------------|----------------|--------|--------|---------------|---------|-----------|---------|------|----------------|-----------------|-------------|--------------|----------|-------|---------|---------------|
```

*   Each record from the file will be inserted into its corresponding table and fields in the database:

```bash
docker-compose exec app php bin/console app:load:csv data/data.csv
```

2\. API Docs
------------

This project is built on Symfony 7.1 and uses [Api Platform](https://api-platform.com/docs/distribution/) to create endpoints based on entities. By structuring the entities this way, we automatically gain access to OpenAPI (formerly known as Swagger) documentation. Once the Docker environment is running locally, you can access the following URL to explore the available endpoints and view the response objects provided by the project:

```bash
http://localhost:19999/api/docs
```
Within each endpoint, you can test requests using the "Try it out" feature. This allows you to simulate requests either as an anonymous user or as an authenticated user. To test as an authenticated user, ensure you set a valid token in the `access_token` authorization field.

3\. What I Did
--------------

I developed this application following the minimum requirements of the task. However, I leveraged various services to manage entities, streamline data handling, generate commands, and ensure data persistence. The application validates dynamic data, adheres to file organization standards, and is fully scalable.

4\. Helper
----------

I have created a small script to simplify the initialization of the application. By running this script, you can automate all the necessary setup steps. The script executes the required commands and, upon completion, provides a list of available tokens for testing the endpoints.

```bash
sh initProject.sh
```

* * *
