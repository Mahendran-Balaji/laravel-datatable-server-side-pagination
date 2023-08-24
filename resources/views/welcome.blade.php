<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Server Side Pagination</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    </head>
    <body>
        <div class="container-fluid">
            <div class="table-responsive">
            <table class="display table table-striped table-bordered" id="scrapped-list">
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
</div>
        </div>
        <!-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script> -->
        <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                let url ='list-scraped-data';
                let searchdata = $('#search_data').val();
                $('#scrapped-list').DataTable({
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

        </script>
    </body>
</html>
