<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        max-width: 400px;
        margin: 50px auto;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }

    button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    #response {
        margin-top: 15px;
        color: #333;
    }
    </style>
</head>

<body>
    <h2>Login</h2>
    <form id="loginForm">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
    <div id="response"></div>

    <script>
    document.getElementById('loginForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = {
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
        };

        try {
            const response = await fetch('http://localhost:8000/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData),
            });

            const result = await response.json();
            const responseDiv = document.getElementById('response');

            if (response.ok) {
                responseDiv.style.color = 'green';
                responseDiv.textContent = 'Login successful! Token: ' + result.token;

            } else {
                responseDiv.style.color = 'red';
                responseDiv.textContent = 'Error: ' + result.message;
            }
        } catch (error) {
            document.getElementById('response').style.color = 'red';
            document.getElementById('response').textContent = 'Network error: ' + error.message;
        }
    });
    </script>
</body>

</html>