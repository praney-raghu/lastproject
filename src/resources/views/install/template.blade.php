<!DOCTYPE html>
<html lang="en">
<head>
  <title>Neev Installation</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
  <style>
    body {
        background-color: #ece5dd;
    }
    .container {
        margin-top: 10px;
    }
    /* .panel-primary > .panel-heading {
        /* text-align: center; */
        /* font-weight: bold; */
        /* color: white;
    } */ 
    .panel-body{
        /* text-align: center; */
    }
    input[type="password"] {
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
  </style>
</head>
<body>

@yield('content')    

<!-- javascript for Installation  -->
<!-- <script src="{{ url('installer/js') }}/install.js" ></script>             -->

</body>
</html>