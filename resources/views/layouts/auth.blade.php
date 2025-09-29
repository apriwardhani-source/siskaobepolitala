<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel App') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
       body {
    margin: 0;
    padding: 0;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;

    background: url("{{ asset('images/background_login.png') }}") no-repeat center center;
    background-size: cover;
    background-attachment: fixed; /* biar efek parallax */
    font-family: 'Poppins', sans-serif;
}


        .auth-container {
            display: flex;
            min-height: 100vh;
        }

        .auth-left {
            flex: 1;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 40px;
            text-align: center;
        }

        .auth-left img {
            max-width: 120px;
            margin-bottom: 20px;
        }

        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url("{{ asset('images/bg-right.jpg') }}") no-repeat center center/cover;
            padding: 40px;
        }

        .auth-card {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .btn-google {
            background: white;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-google img {
            width: 20px;
            height: 20px;
        }

        .btn-google:hover {
            background: #f5f5f5;
            border-color: #ccc;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        @yield('content')
    </div>
</body>
</html>
