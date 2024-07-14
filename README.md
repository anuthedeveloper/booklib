## For Backend Developer

### Backend Requirements (Primary Focus):

-   API Endpoints:
    -   Books:  
        Create, retrieve, update, and delete operations.
    -   Authors:  
        Create, retrieve, update, and delete operations.
-   Authentication:
    -   Implement JWT-based authentication for secure API access.
-   Validation and Error Handling:
    -   Validate requests for books and authors.
    -   Provide clear error messages.
-   Database:
    -   Design MySQL database schema for books and authors.
    -   Use Laravel’s Eloquent ORM for database interactions.

5. Documentation:

    - Optionally document API endpoints.

    ### Frontend Requirements (Secondary Focus):

#### User Interface:

-   Home Page:  
     Display list of books with titles and authors.
-   Book Details Page:  
     Show detailed information about specific books.
-   Author Details Page:  
     Display detailed information about authors.

#### User Authentication:

-   mplement basic login functionality.

#### Form Handling:

-   Create simple forms for managing books and authors.

    #### Bonus Points:

    -   Implement search functionality for books and authors.
    -   Add unit and integration tests for API endpoints.
    -   Deploy API on AWS or Azure or any other cloud provider.

Steps to Use the project

Generate an Application Key:
Generate an application key, which is used for encryption:

```
php artisan key:generate
```

Configure the .env File:
Open the .env file and set up your database and other environment settings:

``
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
``

Run Migrations:
Laravel uses migrations to set up database tables. Run the migrations:

```
php artisan migrate
```

Start the Development Server:
Laravel provides a built-in development server:

```
php artisan serve
```

By default, it will be available at http://localhost:8000.

Run the Seeder:
Finally, run the seeder to populate the database with fake data:

```
php artisan db:seed
```

Additional Steps:

-   Version Control: Clone and follow the above steps
-   Environment Configuration: Update your .env file
-   Deployment: For production, configure a web server (like Nginx or Apache) settings.
