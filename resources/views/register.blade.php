<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

    input,
    select {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }

    button {
        padding: 10px 20px;
        background-color: #28a745;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #218838;
    }

    #response {
        margin-top: 15px;
        color: #333;
    }
    </style>
</head>

<body>
    <h2>Register</h2>
    <form id="registerForm">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="customer">Customer</option>
                <option value="warehouse_manager">Warehouse Manager</option>
                <option value="staff">Staff</option>
            </select>
        </div>
        <button type="submit">Register</button>
    </form>
    <div id="response"></div>

    <script>
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Get form data
        const formData = {
            username: document.getElementById('username').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            role: document.getElementById('role').value,
        };

        try {
            // Send POST request to Laravel API
            const response = await fetch('http://127.0.0.1:8000/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(formData),
            });

            const result = await response.json();
            const responseDiv = document.getElementById('response');

            if (response.ok) {
                responseDiv.style.color = 'green';
                responseDiv.textContent = result.message || 'Registration successful! User created.';
            } else {
                responseDiv.style.color = 'red';
                if (result.errors) {

                    const errorMessages = Object.values(result.errors).flat().join(' ');
                    responseDiv.textContent = errorMessages;
                } else {

                    responseDiv.textContent = result.message || 'Registration failed.';
                }
            }
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('response').style.color = 'red';
            document.getElementById('response').textContent = 'An error occurred. Please try again.';
        }
    });
    </script>
</body>

</html>