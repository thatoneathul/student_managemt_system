<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student - AcademyPro</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            color: #1a1a1a;
            line-height: 1.6;
        }

        header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 16px 40px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .header-nav {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5em;
            font-weight: 800;
            color: #0066ff;
        }

        .logo span {
            color: #00d4ff;
        }

        .back-link {
            background: #0066ff;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            background: #0052cc;
            transform: translateY(-2px);
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 40px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        h2 {
            color: #0066ff;
            font-size: 2em;
            margin-bottom: 30px;
            font-weight: 800;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 0.95em;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1em;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="email"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #0066ff;
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }

        .submit-btn {
            background: linear-gradient(135deg, #0066ff 0%, #00d4ff 100%);
            color: white;
            padding: 14px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 102, 255, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
            box-shadow: 0 5px 15px rgba(0, 102, 255, 0.2);
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .submit-btn:active::before {
            width: 300px;
            height: 300px;
        }

        .submit-btn:disabled {
            opacity: 0.8;
            cursor: not-allowed;
        }

        .message {
            padding: 15px 20px;
            border-radius: 8px;
            margin-top: 20px;
            font-weight: 500;
        }

        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-nav">
            <div class="logo">Academy<span>Pro</span></div>
            <a href="index.html" class="back-link">← Back to Home</a>
        </div>
    </header>

    <div class="container">
        <h2>➕ Add Student</h2>

        <?php
// Debug: Check if connection exists
if (!$conn) {
    echo "<div class='message error'>✗ Database connection failed</div>";
    die();
}

// Debug: Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<!-- DEBUG: Form submitted -->";
    
    if (!isset($_POST['name']) || !isset($_POST['age']) || !isset($_POST['email'])) {
        echo "<div class='message error'>✗ Missing form fields</div>";
    } else {
        $name  = trim($_POST['name']);
        $age   = trim($_POST['age']);
        $email = trim($_POST['email']);

        // Validate inputs
        if (empty($name) || empty($age) || empty($email)) {
            echo "<div class='message error'>✗ All fields are required</div>";
        } else if ($age < 16) {
            echo "<div class='message error'>✗ Age must be at least 16</div>";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<div class='message error'>✗ Invalid email format</div>";
        } else {
            // Check if table exists first
            $checkTable = mysqli_query($conn, "SHOW TABLES LIKE 'student'");
            
            if (mysqli_num_rows($checkTable) == 0) {
                echo "<div class='message error'>✗ Table 'student' does not exist in database</div>";
            } else {
                // Try simple insert first without prepared statement to debug
                $name_escaped = mysqli_real_escape_string($conn, $name);
                $email_escaped = mysqli_real_escape_string($conn, $email);
                
                $sql = "INSERT INTO student (name, age, email) VALUES ('$name_escaped', $age, '$email_escaped')";
                
                if (mysqli_query($conn, $sql)) {
                    $student_id = mysqli_insert_id($conn);
                    echo "<div class='message success'>✓ Student added successfully! ID: " . $student_id . "</div>";
                    echo "<script>setTimeout(function() { document.getElementById('studentForm').reset(); }, 1500);</script>";
                } else {
                    echo "<div class='message error'>✗ Database Error: " . mysqli_error($conn) . "</div>";
                }
            }
        }
    }
}
?>

        <form method="post" action="" id="studentForm">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter student name" required>
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" min="16" placeholder="Enter age" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter email" required>
            </div>

            <button type="submit" name="submit" class="submit-btn" id="submitBtn">✓ Add Student</button>
        </form>

        <script>
            document.querySelector('form').addEventListener('submit', function(e) {
                const btn = document.getElementById('submitBtn');
                const originalText = btn.textContent;
                btn.disabled = true;
                btn.textContent = '⏳ Processing...';
                
                setTimeout(() => {
                    btn.disabled = false;
                    btn.textContent = originalText;
                }, 2000);
            });
        </script>

    </div>
</body>
</html>
