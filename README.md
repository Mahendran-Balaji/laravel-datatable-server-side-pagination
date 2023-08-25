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

Step 11: Create Controller

```bash
php artisan make:controller HomeController
```

Step 12: Route

```bash
Route::get('/', [HomeController::class,'index']);
Route::get('/get-blog-details',[HomeController::class,'getBlogRecords']);
```

Step 13: Controller (For Homepage)

```bash
    public function index()
    {
        return view('welcome');
    }
```
Step 14: Controller (For Get Blog Records)

Trait:

```bash
    use App\Models\Blog;
```

Construct:

```bash
    public function __construct(Blog $blogDetails){
        $this->blogDetails = $blogDetails;
    }
```

Member Function:

```bash
     public function getBlogRecords(Request $request){
        $query = $this->blogDetails;
        //For Search
        if($request->sSearch!='')
        {
            $keyword = $request->sSearch;
            $query = $query->when($keyword!='', 
            function($q) use($keyword){
                return $q->where('user_id','like','%'.$keyword.'%')
                    ->orwhere('slug','like','%'.$keyword.'%')
                    ->orwhere('keywords','like','%'.$keyword.'%')
                    ->orwhere('title','like','%'.$keyword.'%')
                    ->orwhere('description','like','%'.$keyword.'%')
                    ->orwhere('content','like','%'.$keyword.'%');
            });
        }
      
        $results = $query->get();
        $totalCount = $this->blogDetails->get();
        
        //Sorting
        $columnIndex = $request['iSortCol_0'];
        $order = $request['sSortDir_0'];
        $columns = array(
            0 => 'user_id',
            1 => 'slug',
            2 => 'keywords',
            3 => 'title',
            4 => 'description',
            5 => 'content',
         );
        $columnName = $columns[$columnIndex];
        $limit = $request->iDisplayLength;
        $offset = $request->iDisplayStart;

        $query = $query->when(($limit != '-1' && isset($offset)),
            function ($q) use ($limit, $offset) {
                return $q->offset($offset)->limit($limit);
            });

        $results = $query->orderBy($columnName, $order)->get();
        $column = array();
        $data = array();
        foreach ($results as $list) {
            $col['user_id'] = isset($list->user_id) ? $list->user_id : "";
            $col['slug'] = isset($list->slug) ? $list->slug : "";
            $col['keywords'] = isset($list->keywords) ? $list->keywords : "";
            $col['title'] = isset($list->title) ? $list->title : "";
            $col['description'] = isset($list->description) ? $list->description : "";
            $col['content'] = isset($list->content) ? $list->content : "";
            array_push($column, $col);
        }
        $data['sEcho'] = $request->sEcho;
        $data['aaData'] = $column;
        $data['iTotalRecords'] = count($totalCount);
        $data['iTotalDisplayRecords'] = count($totalCount);
        $data['recordsFiltered'] = count($totalCount);
        return json_encode($data);
    }
```
Step 15: Add CSS and JS CDN 

```bash
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
```

Step 16: JS File

```bash
$(document).ready(function() {
       let url ='get-blog-details';
       let searchdata = $('#search_data').val();
       $('#blog-list').DataTable({
             "bProcessing": true,
             "bServerSide": true,
             "pagingType": 'full_numbers',
             "deferRender": true,
             "sAjaxSource": url,
             "lengthMenu": [
                  [10, 25, 50, -1],
                  [10, 25, 50, 'All']
              ],
              "columns": [
                  { data: 'user_id' },
                  { data: 'slug' },
                  { data: 'keywords' },
                  { data: 'title' },
                  { data: 'description' },
                  { data: 'content' },
             ]
       });
});

```


Step 17: welcome.blade.php File

```bash
 <table class="display table table-striped table-bordered" id="blog-list">
    <thead>
         <tr>
             <th>User ID</th>
             <th>Slug</th>
             <th>Keywords</th>
             <th>Title</th>
             <th>Description</th>
             <th>Content</th>
           </tr>
    </thead>
    <tbody>
    </tbody>
</table>
```


Step 17: Run the application

```bash
php artisan serve
```
