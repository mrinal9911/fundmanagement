<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Keymon Gullak')</title>
    <style>
        /* Include all your CSS styles here */
        @import url('https://fonts.googleapis.com/css2?family=Arial:wght@400;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
            line-height: 1.6;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #333;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        nav h1 {
            color: #f4f4f4;
            font-size: 1.8em;
            font-weight: bold;
        }

        .nav-link {
            color: #f4f4f4;
            text-decoration: none;
            font-weight: 600;
            padding: 10px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
            background: linear-gradient(45deg, #007bff, #0056b3);
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.2);
        }

        .nav-link:hover {
            background: linear-gradient(45deg, #0056b3, #003d7a);
            transform: translateY(-2px);
        }

        .login-btn {
            background: linear-gradient(45deg, #ff6b6b, #ffcc00);
            color: #fff;
            font-weight: 700;
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
            animation: pulse 2s infinite;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            background: linear-gradient(45deg, #ff4757, #ffc107);
            transform: scale(1.1);
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
            }

            50% {
                box-shadow: 0 7px 15px rgba(0, 0, 0, 0.5);
            }
        }
    </style>
</head>

<body>
    @include('layouts.navbar')

    <div class="container">
        @yield('content')
    </div>
</body>

</html>