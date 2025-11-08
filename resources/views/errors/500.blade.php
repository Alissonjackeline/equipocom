<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 500 - Error interno del servidor</title>
     <link href="{{ asset('bootstrap/css/bootstrap.css') }}" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .error-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="error-container">
            <img src="{{ asset('img/500.png') }}" alt="500" style="max-width: 100%; height: auto;">
    </div>

</div>
</body>
</html>
