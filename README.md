<div style="display:flex; align-items: center">
  <h1 style="position:relative; top: -6px" >Fantasy League Project</h1>
</div>

---

🔥 This project is a fantasy league application where users can create their own fantasy teams, participate in leagues, and compete with others. The project is built using Laravel, adhering to ****SOLID**** principles with a focus on a ****service + repository**** pattern. The application includes roles and permissions management, automated fixtures and games, unit and feature testing, and more.

#

### Features

- **Authentication**: Managed with Laravel Breeze.
- **Fantasy Team Management**: Users can create and manage their own fantasy teams.
- **Roles and Permissions**: Admin and Moderator roles with specific permissions using Spatie Permissions.
  - **Admin**: Can create, update, and delete teams, players, and divisions, also delete fantasy team.
  - **Moderator**: Can edit teams, players, and divisions.
- **Automated Fixtures and Games**: Randomized fixtures and games for league play.
  
- **Task Scheduling**: To randomize games results every week.
- **Testing**: Unit mock testing and feature testing.
- **Code Formatting**: Using Laravel Pint for code formatting.
  
#

### Used Packages And Docs

- [Spatie Permissions](https://spatie.be/docs/laravel-permission): A powerful package for managing roles and permissions in Laravel applications.
- [Laravel Breeze](https://laravel.com/docs/breeze): A minimalistic authentication scaffolding for Laravel applications.
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
#### Code formatting command, this is command calls Laravel pint
```bash
php artisan code:format
```
