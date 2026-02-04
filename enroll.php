<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll Student - AcademyPro</title>
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
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 102, 255, 0.3);
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
        <h2>📝 Enroll Student in Course</h2>

        <form method="post">
            <div class="form-group">
                <label for="student_id">Student</label>
                <select id="student_id" name="student_id" required>
                    <option value="">-- Select a Student --</option>
                    <?php
                    $students = mysqli_query($conn, "SELECT * FROM student");
                    while ($s = mysqli_fetch_assoc($students)) {
                        echo "<option value='{$s['student_id']}'>{$s['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="course_id">Course</label>
                <select id="course_id" name="course_id" required>
                    <option value="">-- Select a Course --</option>
                    <?php
                    $courses = mysqli_query($conn, "SELECT * FROM course");
                    while ($c = mysqli_fetch_assoc($courses)) {
                        echo "<option value='{$c['course_id']}'>{$c['course_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" name="submit" class="submit-btn">Enroll Student</button>
        </form>

        <?php
if (isset($_POST['submit'])) {

    $student_id = $_POST['student_id'];
    $course_id  = $_POST['course_id'];

    $sql = "INSERT INTO enrollment (student_id, course_id)
            VALUES ($student_id, $course_id)";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='message success'>✓ Student enrolled successfully</div>";
    } else {
        echo "<div class='message error'>✗ Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

    </div>
</body>
</html>
