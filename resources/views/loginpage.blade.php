<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #74ebd5, #9face6);
            color: #333;
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
            color: white;
            font-size: 1.5em;
            margin: 0;
        }

        .form-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.8s ease-in-out;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .form-label {
            font-size: 0.9em;
            margin-bottom: 5px;
            display: block;
            color: #555;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            font-size: 0.95em;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1em;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-home {
            width: 100%;
            padding: 12px;
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1em;
            font-weight: 500;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .btn-home:hover {
            background-color: #565e64;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <nav>
        <h1>Keymon Gullak</h1>
    </nav>

    <div class="form-container">
        <h2>Login</h2>
        <form action="{{ url('login') }}" method="POST">
            @csrf
            <label class="form-label">Enter Email:</label>
            <input type="text" name="email" class="form-control" placeholder="Email Address" required>
            <label class="form-label">Enter Password:</label>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <button type="submit" class="btn-primary">Login</button>
        </form>
        <button class="btn-home" onclick="window.location.href='{{ url('/') }}';">Home</button>
    </div>
</body>

</html>