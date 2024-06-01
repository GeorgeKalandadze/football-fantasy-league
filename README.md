<div style="display:flex; align-items: center">
  <h1 style="position:relative; top: -6px" >Fantasy League Project</h1>
</div>

---

🔥 This project is a fantasy league application where users can create their own fantasy teams, participate in leagues, and compete with others. The project is built using Laravel, adhering to ****SOLID**** principles with a focus on a ****service + repository**** pattern. The application includes roles and permissions management, automated fixtures and games, Custom Exceptions, unit and feature testing, and more.

#

### Features

- **Authentication**: User Authentications system.
  - **API Token Authentication**: Securing API endpoints with Laravel Sanctum.
  - **Manage Auth Functionality**: Managed with Laravel Breeze.
- **Roles and Permissions**: Admin and Moderator roles with specific permissions using Spatie Permissions.
  - **Admin**: Can create, update, and delete teams, players, and divisions, also delete fantasy team.
  - **Moderator**: Can edit teams, players, and divisions.
- **Fantasy Team Management**: Users can create and manage their own fantasy teams.
- **Automated Fixtures and Games**: Randomized fixtures and games for league play.
  
- **Task Scheduling**: To randomize games results every week.
- **Testing**: Unit mock testing and feature testing.
- **Events and Listeners**: Used for decoupling complex processes. For instance, the PlayerStatisticsRecorded event is fired when player statistics are updated, and corresponding listeners handle the processing.
- **Form Request Validation**: Enhanced form request validation using prepareForValidation and withValidator. This allows for preprocessing data before validation and adding custom validation rules post-validation.
- **Handling Exceptions**: Make Custom Exceptions to improve the user experience and make debugging easier .
- **API Resources**: Used for transforming and formatting API responses, providing a consistent structure for the API endpoints.
- **Seeders and Factories**:  Provide initial data for testing and development environments, Generate realistic fake data for models.
- **Code Formatting**: Using Laravel Pint for code formatting.
  
#

### Used Packages And Docs

- [Spatie Permissions](https://spatie.be/docs/laravel-permission): A powerful package for managing roles and permissions in Laravel applications.
- [Laravel Breeze](https://laravel.com/docs/breeze): A minimalistic authentication scaffolding for Laravel applications.
- [Sanctum](https://laravel.com/docs/11.x/sanctum): Securing API endpoints with Laravel Sanctum.
- [Laravel Pint](https://github.com/themsaid/laravel-pint): A package for formatting PHP, HTML, CSS, and JavaScript code in Laravel applications.
- [Service + Repository Pattern](https://joe-wadsworth.medium.com/laravel-repository-service-pattern-acf50f95726):  Learn about organizing your Laravel application using the service + repository pattern.
- [Testing in Laravel](https://laravel.com/docs/11.x/testing):  Explore the comprehensive testing capabilities in Laravel Such as Mock unit and Feature testing.
#

### Project setup
```bash
git clone https://github.com/GeorgeKalandadze/football-fantasy-league.git
```
```bash
cp .env.example .env
```
```bash
composer install
```
```bash
php artisan key:generate
```
```bash
php artisan migrate:fresh --seed
```
```bash
php artisan serve
```
#

### Running tests

```bash
php artisan test
```
#

### Custom Artisan Console Commands

#### Assign Role Command
```bash
php artisan user:assign-role {email} {role}
```
#### Remove Role Command
```bash
php artisan user:remove-role {email} {role}
```
#### Code formatting command, this command calls Laravel pint Code formatter command
```bash
php artisan code:format
```
