# CUSTOMER TEST

## Description

A simple Symfony application that fetch users from randomuser.me and save it to DB

## Structure

```angular2html

- src
    - Shared // Shared between different domains
        - Application
            - Response
            - Traits
        - Domain
            - Gateway
                - RandomUserApiGatewayInterface.php
        - Infrastructure
            - Gateway
                - RandomUserApiGateway.php
    - User
        - Application
            - Query
                - Get
                    - GetUserQuery.php
                    - GetUserQueryHandler.php
                - GetAll
                    - GetUsersQuery.php
                    - GetUsersQueryHandler.php
        - Domain
            - Exceptions
            - Model
                - User.php
            - Repositories
                - UserRepositoryInterface.php
            - Response
                - UserApiResponse.php
            - Services
                - UserImporterServiceInterface.php
        - Infrastructure
            - Console
                - Command
                    - ImportUsersCommand.php
            - Controllers
                - UserController.php
            - Repositories
                - DoctrineUserRepository.php
    - // you can add more domain
```

## Installation

1. Clone the repository
2. RUN `docker-compose -p "customer-test" -f docker-compose.yaml up -d --build`

## Migration

`docker exec -it customer-api sh -c "php bin/console doctrine:migrations:migrate"`

## Run Tests

`docker exec -it customer-api sh -c "php bin/phpunit"`

## Run Lint

`docker exec -it customer-api sh -c "composer lint"`

## Importer

### Command
`docker exec -it customer-api sh -c "php bin/console import:users"`

### Service

To use the importer as a service, you can inject `UserImporterService` class anywhere in the application.

This will fetch from randomuser.me and save it to DB.

```php
public function getUsers(UserImporterServiceInterface $userImporterService)
{
    $userImporterService->handle();
}
```

### Gateway

If you want to fetch from randomuser.me without saving it to DB, you can use the `RandomUserApiGatewayInterface` class.

```php
public function getUsers(RandomUserApiGatewayInterface $randomUserApiGateway)
{
    $users = $randomUserApiGateway->fetchUsers();
    
    // Do something with the users
}
```

