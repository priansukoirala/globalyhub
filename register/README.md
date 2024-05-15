# Client Registration API

This is a simple Laravel API for registering Users.

## Features

-   Register a new client
-   Retrieve a list of clients
-   Retrieve a single client by username

## Technologies Used

-   Laravel: A PHP web application framework for building APIs and web applications.
-   MySQL: A relational database management system used for storing user data.
-   Postman: A collaboration platform for API development, testing, and documentation.

## Installation

1. Clone the repository:
   git clone https://github.com/priansukoirala/globalyhub.git

2. Navigate to the project directory:
   cd register

3. Install dependencies:
   composer install

4. Copy the .env.example file to .env and configure your database connection:
   cp .env.example .env

5. Generate an application key:
   php artisan key:generate

6. Install Passort
   php artisan passport:install

7. Migrate the database:
   php artisan migrate

8. Usage
   Start the development server:
   php artisan serve

Below list are the packages used in this application

1. php: This specifies the PHP version required by the Laravel application. In this case, it requires PHP version 8.1 or higher.

2. guzzlehttp/guzzle: Guzzle is a PHP HTTP client library that makes it easy to send HTTP requests and integrate with web services. It is commonly used in Laravel applications for making HTTP requests to external APIs or services.

3. laravel/framework: Laravel is the core framework for building web applications in PHP. It provides a rich set of features and tools for handling routing, authentication, database interactions, and more.

4. laravel/passport: Laravel Passport is an official package for adding OAuth2 authentication to Laravel applications. It provides a full OAuth2 server implementation with support for token issuance, token revocation, and token scopes, making it easy to secure API endpoints and authenticate users using OAuth2.

5. marcin-orlowski/laravel-api-response-builder: Laravel API Response Builder is a package that helps standardize and streamline API responses in Laravel applications. It provides helper methods and classes for constructing consistent and well-structured API responses with proper status codes, headers, and JSON payloads.

###Repository Pattern

The Repository pattern is a design pattern commonly used to separate the logic that retrieves data from the underlying data source (such as a database) from the rest of the application. The following steps were taken to implement the same

a. Create a Repository Interface:
First, define an interface that outlines the methods for interacting with your data source. This interface will serve as a contract that concrete repository implementations must adhere to. In this case
EG - ClientInterface is an interface that defines all the methods used.

b. Implement the Repository:
Next, create concrete repository classes that implement the repository interface. These classes will contain the actual logic for
interacting with the data source, such as querying the database using Eloquent ORM or executing raw SQL queries.
EG - ClientRepository is an class that implements all the methods defined in ClientInterface.

c. Binding in the Service Provider:
Register your repository binding in the Laravel service container. You can do this in the register() method of a service provider, such as AppServiceProvider. However, There is a new service provider RegisterServiceProvider that is already
regsitered in the kernel.php file where the repositories are binded.

d. Using the Repository:
Now, you can use dependency injection to access your repository in your controllers, services, or other parts of your application.
sets up constructor injection for a dependency ($client) in the class. It ensures that an object implementing the ClientInterface interface is provided to the class upon instantiation, allowing the class to interact with the injected dependency without needing to create it internally. This promotes loose coupling and makes the class easier to test and maintain.
