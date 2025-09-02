<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WanLanka - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            display: flex; /* 👈 Sidebar + Content side by side */
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .content {
            flex-grow: 1; /* 👈 Content takes remaining width */
            padding: 20px;
            background: #f4f6f9;
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    @include('admin.layouts.sidebar')

    {{-- Page Content --}}
    <div class="content">
        @yield('content')
    </div>

</body>
</html>
