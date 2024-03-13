<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('links.sidebar-links')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/img/favicon.png">
</head>


<body style="background-color: #fff;">
    @include('includes.sidebar')
    @include('script-js.sidebar-script')
</body>

</html>