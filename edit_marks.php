<?php
include 'db.php';

$mark_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$mark_id) {
    header('Location: report.php');
    exit;
}

// Fetch mark details
$sql = "SELECT m.mark_id, m.marks, e.enroll_id, s.name, c.course_name
        FROM marks m
        JOIN enrollment e ON m.enroll_id = e.enroll_id
        JOIN student s ON e.student_id = s.student_id
        JOIN course c ON e.course_id = c.course_id
        WHERE m.mark_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $mark_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$mark = mysqli_fetch_assoc($result);

if (!$mark) {
    header('Location: report.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Marks - AcademyPro</title>
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

        .info-box {
            background: #f0f4ff;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #0066ff;
            margin-bottom: 20px;
        }

        .info-box p {
            margin: 5px 0;
            color: #333;
        }

        .info-box strong {
            color: #0066ff;
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

        .button-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 30px;
        }

        .submit-btn,
        .delete-btn {
            padding: 14px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn {
            background: linear-gradient(135deg, #0066ff 0%, #00d4ff 100%);
            color: white;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 102, 255, 0.3);
        }

        .delete-btn {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8787 100%);
            color: white;
        }

        .delete-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 107, 107, 0.3);
        }

        .message {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
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
            <a href="report.php" class="back-link">← Back to Reports</a>
        </div>
    </header>

    <div class="container">
        <h2>✏️ Edit Student Marks</h2>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $marks = trim($_POST['marks']);

            // Validate input
            if (empty($marks)) {
                echo "<div class='message error'>✗ Marks field is required</div>";
            } else if ($marks < 0 || $marks > 100) {
                echo "<div class='message error'>✗ Marks must be between 0 and 100</div>";
            } else {
                $sql = "UPDATE marks SET marks = ? WHERE mark_id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ii", $marks, $mark_id);
                
                if (mysqli_stmt_execute($stmt)) {
                    echo "<div class='message success'>✓ Marks updated successfully!</div>";
                    $mark['marks'] = $marks;
                } else {
                    echo "<div class='message error'>✗ Error: " . mysqli_error($conn) . "</div>";
                }
                mysqli_stmt_close($stmt);
            }
        }

        // Handle delete
        if (isset($_POST['delete'])) {
            $sql = "DELETE FROM marks WHERE mark_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $mark_id);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Marks deleted successfully!'); window.location.href='report.php';</script>";
            } else {
                echo "<div class='message error'>✗ Error: " . mysqli_error($conn) . "</div>";
            }
            mysqli_stmt_close($stmt);
        }
        ?>

        <div class="info-box">
            <p><strong>Student:</strong> <?php echo htmlspecialchars($mark['name']); ?></p>
            <p><strong>Course:</strong> <?php echo htmlspecialchars($mark['course_name']); ?></p>
        </div>

        <form method="post">
            <div class="form-group">
                <label for="marks">Marks (0-100)</label>
                <input type="number" id="marks" name="marks" min="0" max="100" value="<?php echo $mark['marks']; ?>" required>
            </div>

            <div class="button-group">
                <button type="submit" name="update" class="submit-btn">✓ Update Marks</button>
                <button type="submit" name="delete" class="delete-btn" onclick="return confirm('Are you sure you want to delete these marks?');">🗑️ Delete Marks</button>
            </div>
        </form>
    </div>
</body>
</html>
