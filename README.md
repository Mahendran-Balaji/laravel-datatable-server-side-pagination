# laravel-datatabale-server-side-pagination
Implement Server Side Pagination to Laravel Application

Step 1: Create Laravel project with below command in the terminal

```bash
  composer create-project laravel/laravel laravel_server_side_pagination
```

Step 2: Now let's create database migration using below artisan command:

```bash
  php artisan make:migration create_blog_table
```

Step 3: Now add table fields in the migration class in the up() method.

```php
Schema::create('blog', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('slug', 200);
            $table->string('keywords', 255);
            $table->string('title', 255);
            $table->string('description', 255);
            $table->text('content');
            $table->timestamps();
        });
```

Step 4: Run the migrate command to generate table in the database:

```bash
  php artisan migrate
```

Step 5: create model using following command:

```bash
  php artisan make:model Blog
```

Step 6: Generating Factory class

```bash
  php artisan make:factory BlogFactory --model=Blog
```
It will generate factory class at database/factories/BlogFactory.php file.


Step 7: Open 'BlogFactory' file

```bash
  php artisan make:factory BlogFactory --model=Blog
```

Add Trait:

```php
use App\Models\Blog;
```

Add following code in the definition() method.

```php
    return [
            'title' => $this->faker->text,
            'user_id' => rand(1,200),
            'slug' => $this->faker->slug,
            'keywords' => $this->faker->text,
            'description' => $this->faker->text,
            'content' => $this->faker->paragraph,
        ];
```

Step 8: Generate dummy data in the database tables

Now open database/seeds/DatabaseSeeder.php file and add the bellow lines in the run() function.

```bash
  \App\Models\User::factory(50)->create();
  \App\Models\Blog::factory(200)->create();
```

Step 9: Clear the cache

```bash
php artisan optimize:clear
```

Step 10: Run the application

```bash
php artisan serve
```
