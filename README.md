
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

Please note that to make an authenticated request, you need to use a valid token provided after loading the fixtures:
```sh
docker-compose exec app php bin/console doctrine:fixture:load --no-interaction
```

To view all valid tokens for each user, run the following command:
```sh
docker-compose exec app php bin/console app:tokens:available
```

once of these tokens should be included in the request header under the name `X-AUTH-TOKEN`.

For example, a request might look like this:

```sh
curl -X 'GET' \
  'http://localhost:19999/api/players/3' \
  -H 'accept: application/json' \
  -H 'X-AUTH-TOKEN: tcp_b388ed1136cccd906d578702608aa178ee0e6de24b340c8bb6376cbe40f367c4'
```

3\. What I Did
--------------

I developed this application by meeting the main requirements of the task, making sure all the specified functionalities were included. But I didn’t stop there; I also added some extra services and features to boost the functionality and maintainability of the project.

I also made sure the application could validate dynamic data, which is crucial for keeping data integrity and preventing errors. Plus, I followed industry-standard practices in file organization and code structure, making the project not only scalable but also easy to maintain and extend in the future.

To meet the REST API requirement, we decided to use a popular library like API Platform due to its strong background and collaborative community. This choice is great for implementing standard conventions and, in this project, it helps reduce the effort needed to implement new endpoints and ensures the code is clear and maintainable.

In summary, while the project meets the task's minimum requirements, I designed it with scalability, efficiency, and long-term maintainability in mind. This ensures that the application is not only functional today but also ready to evolve and adapt to future needs.

4\. Helper
----------

I have created a small script to simplify the initialization of the application. By running this script, you can automate all the necessary setup steps. The script executes the required commands and, upon completion, provides a list of available tokens for testing the endpoints.

```bash
sh initProject.sh
```

Here’s an improved version of the text:

Inside the script, the command to load data from the .csv file is executed automatically. If you prefer to initialize the project and run this command separately, simply comment out the following line:

```sh
#docker-compose exec app php bin/console app:load:csv data/data.csv
```
It's also important to highlight that if you perform tests and need to restore the database, you can do so by running:

```sh
docker-compose exec app php bin/console doctrine:schema:drop --force
```

After dropping the schema, you can re-run the script to reinitialize the project from the beginning.
* * *
