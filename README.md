1) First of all create Laravel project with bellow command in the terminal:

composer create-project laravel/laravel laravel_server_side_pagination

2) Now let's create database migration using belllow artisan command:

php artisan make:migration create_blog_table

3) Now add table fields in the migration class in the up() method.

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

4) Run the migrate command to generate table in the database:

php artisan migrate

5) create model using following command:

php artisan make:model Blog

6) Generating Factory class

php artisan make:factory BlogFactory --model=Blog

It will generate factory class at database/factories/BlogFactory.php file.

7) Open 'BlogFactory' file

Add Trait: use App\Models\Blog;

Add following code in the definition() method.

return [
            'title' => $this->faker->text,
            'user_id' => rand(1,200),
            'slug' => $this->faker->slug,
            'keywords' => $this->faker->text,
            'description' => $this->faker->text,
            'content' => $this->faker->paragraph,
        ];

8) Generate dummy data in the database tables.

Now open database/seeds/DatabaseSeeder.php file and add the bellow lines in the run() function.

\App\Models\User::factory(50)->create();
\App\Models\Blog::factory(200)->create();

9) Clear the cache
php artisan optimize:clear

10) Run the application:
php artisan serve