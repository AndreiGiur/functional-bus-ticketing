<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Ticketing Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom, #4CAF50, #2E7D32);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }
        .login-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            color: #333;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #2E7D32;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        .form-group input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }
        .btn {
            background: #4CAF50;
            color: #fff;
            padding: 0.8rem;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }
        .btn:hover {
            background: #388E3C;
        }
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }
        .login-footer a {
            color: #4CAF50;
            text-decoration: none;
        }
        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Bus Ticketing Login</h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <div class="login-footer">
            <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
            <p><a href="{{ route('password.request') }}">Forgot password?</a></p>
        </div>
    </div>
</body>
</html>
