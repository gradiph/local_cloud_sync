<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                     <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
            </div>
        </nav>

        <main>
            <div class="container">
                <h1>Books</h1>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Author</th>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $book->name }}</td>
                                    <td>{{ $book->author }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="{{ url('random') }}" class="btn btn-primary btn-lg">Random</a>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        cloud_check();
        local_check();
        function cloud_check() {
            var url = "{{ env('CLOUD_URL') }}/query/get?rand="+Math.random(),
                data = {
                    type: "cloud",
                    option: "not executed"
                };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function (response) {
                    if(response != "") {
                        response.forEach(cloud_execute);
                    }
                    else {
                        console.log("cf");
                    }
                    setTimeout(cloud_check, 4000);
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                    setTimeout(cloud_check, 4000);
                }
            });
        }

        function cloud_execute(item, index) {
            var url_execute = "{{ env('APP_URL') }}/query/execute?rand="+Math.random(),
                data_execute = {
                    query: item.query
                },
                url_set = "{{ env('CLOUD_URL') }}/query/set/executed?rand="+Math.random(),
                data_set = {
                    cloud_query_id: item.id
                };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: url_execute,
                data: data_execute,
                success: function (response_execute) {
                    if(response_execute == "success") {
                        $.ajax({
                            type: "POST",
                            url: url_set,
                            data: data_set,
                            success: function (response_set) {
                                if(response_set == "success") {
                                    console.log("ct");
                                }
                                else {
                                    console.log("cf3");
                                }
                            },
                            error: function (xhr_set, status_set, error_set) {
                                console.log(xhr_set.responseText);
                            }
                        });
                    }
                    else {
                        console.log("cf2");
                    }
                },
                error: function (xhr_execute, status_execute, error_execute) {
                    console.log(xhr_execute.responseText);
                }
            });
        }
        function local_check() {
            var url = "{{ env('APP_URL') }}/query/get?rand="+Math.random(),
                data = {
                    type: "local",
                    option: "not uploaded"
                };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function (response) {
                    if(response != "") {
                        response.forEach(local_upload);
                    }
                    else {
                        console.log("lf");
                    }
                    setTimeout(local_check, 4000);
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                    setTimeout(local_check, 4000);
                }
            });
        }

        function local_upload(item, index) {
            var url_execute = "{{ env('CLOUD_URL') }}/query/execute?rand="+Math.random(),
                data_execute = {
                    query: item.query
                },
                url_set = "{{ env('APP_URL') }}/query/set/uploaded?rand="+Math.random(),
                data_set = {
                    local_query_id: item.id
                };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: url_execute,
                data: data_execute,
                success: function (response_execute) {
                    if(response_execute == "success") {
                        $.ajax({
                            type: "POST",
                            url: url_set,
                            data: data_set,
                            success: function (response_set) {
                                if(response_set == "success") {
                                    console.log("lt");
                                }
                                else {
                                    console.log("lf3");
                                }
                            },
                            error: function (xhr_set, status_set, error_set) {
                                console.log(xhr_set.responseText);
                            }
                        });
                    }
                    else {
                        console.log("lf2");
                    }
                },
                error: function (xhr_execute, status_execute, error_execute) {
                    console.log(xhr_execute.responseText);
                }
            });
        }
    </script>
</body>
</html>
