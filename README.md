# Backend with Laravel
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

This project explores the features of Laravel - a framework for php - and docker environments as well as AWS(Amazon Web Services). 

Out of the box, Laravel features an extensive range of features including automated route collections, and a handful of middlewares used for validation and user authentication. 

Both front- and backend were implemented using laravel with a frontend library called `Blade`, that ships with Laravel. 

For the database, a mysql server was deployed as a docker container alongside the backend demo application. Overall, the application is structured as a multi-container docker service. 

📆 _Last Update: Oct 22, 2023_

## Processes

- Laravel utilizes a LOT of different frameworks and libraries such as `AlpineJS` or `npm`. These are all provided on a new project and bootstrapped to provide an integrated developing environment. 

- a CLI tool called `artisan` is provided to automate the creation of certain elements.

    For example, 
    ```
    php artisan make:controller RatingController
    ```
    will initiate a RatingController.php script that extends the `Controller` class.

### Users
Laravel provides a template for new projects, which is by itself already a complete webapp(so to speak). A user system with profile editing features is already implemented with a dashboard display that shows up when a user logs in.

### Rating
Building from this template, I only had to add a rating system and an appropriate front end interface. Once again, the `artisan` CLI facilitates the creation of `Model`s, which are objects that parse into database entries. 
```
php artisan make:Model Ratings
```
creates a [Rating.php](app/Models/Rating.php) under the `/Models/` directory. This file is simply a template, so it needs to filled out. 
By default, Laravel protects against CSRF(Cross Site Request Forgery). The user entry fields are added to `$fillable` to let laravel know that this is a field that can be entered to the database.
```PHP
# In Rating.php

protected $fillable = [
        'artist',
        'title',
        'stars',
    ];
```
Then, we add a relation to the Rating Model by writing
```PHP
# In Rating.php

public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
```
This maps the Rating Model to a User Model in way that a Rating can only belong to a single User.

Likewise, In the User Model, we add a HasMany relation that maps the User Model to multiple Rating Models 
```PHP
# In User.php

public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
```

### RatingController

Similar to how a Rating Model was initiated, a Controller is also initiated through the `artisan` CLI. 
```
php artisan make:Controller RatingController
```
creates a `RatingController.php` under `/Controllers/`

In [RatingController.php](/app/Http/Controllers/RatingController.php), certain functions can be declared such that laravel can automatically gather HTTP requests and expose adequate routes. These functions are namely `show`, `index`, `store`, etc. 

**Examples**

- The `show()` was implemented to handle individual `GET` requests to each rating. 
- The `store()` method handles `POST` requests to store new ratings to the database. 

This file is also where the frontend files are served. For example, in the `index()` method, which simply handles a `GET` request to the url `Rating`, sends the [index.blade.php](/resources/views/ratings/index.blade.php) under `/resources/views/ratings/index.blade.php`.

### Policies

Laravel also allows the implmentation of custom policies for which actions are allowed bby which users. In this case, policies for ratings were created (also through the `artisan` CLI) to only allow a user to delete or edit ratings that belong to them. This is done in [RatingPolicy.php](app/Policies/RatingPolicy.php)
```PHP
public function update(User $user, Rating $rating): bool
    {
        return $rating->user()->is($user);
    }
```
The above function declares the policy for which user is allowed to update which rating.

### Database migration

This was also a pretty convenient feature offered in laravel. It facilitates writing fields into a database such as this 
```PHP
public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('artist');
            $table->string('title')->unique();
            $table->integer('stars');
            $table->timestamps();
        });
    }
```
and by running
```
php artisan migrate
```
laravel will automatically run SQL statements to create appropriate tables.

### Frontend

`Blade` was also a somewhat intuive frontend library to use. Although it was very convenient that the new project template included components such as `<x-dropdown-link>` to expedite the creation of reactive frontend components.

## Deployment

<p align="center"><a href="https://www.docker.com" target="_blank"><img src="https://camo.githubusercontent.com/1ada9782cbf79d79a05ce076d897076ccb8a483837c05959b41f82a87c967a4f/68747470733a2f2f7261772e6769746875622e636f6d2f436972636c6543492d5075626c69632f63696d672d617a7572652f6d61696e2f696d672f636972636c652d646f636b65722e7376673f73616e6974697a653d74727565" width=400 alt="Docker Logo"></a></p>

The application was deployed using docker.

The application image was built using the [Dockerfile](/Dockerfile). A mysql-server image was pulled from the docker hub to handle database operations. A docker network was established between the two containers such that the laravel application and talk to the mysql database.

## Production

<p align="center"><a href="https://aws.amazon.com" target="_blank"><img src="https://avatars.githubusercontent.com/u/2232217?s=280&v=4" alt="AWS Logo"></a></p>

The application was deployed on an AWS EC2 instance with Route 53 to handle domain routing.

Currently the website is accessible at [comp333-backend-demo.net](comp333-backend-demo.net)

---
This project is part of an assignment for the course COMP333: Software engineering at Wesleyan University. 

Created using [Laravel](Laravel_info.md)
