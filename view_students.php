<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students - AcademyPro</title>
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
            max-width: 1000px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background: linear-gradient(135deg, #0066ff 0%, #00d4ff 100%);
            color: white;
        }

        th {
            padding: 16px;
            text-align: left;
            font-weight: 600;
            font-size: 0.95em;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        tbody tr {
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background: #f9fafb;
            box-shadow: 0 2px 8px rgba(0, 102, 255, 0.05);
        }

        .empty-message {
            text-align: center;
            padding: 30px;
            color: #666;
            font-size: 1.1em;
        }

        .student-id {
            background: #f0f4ff;
            color: #0066ff;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.9em;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .edit-btn,
        .delete-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            font-size: 0.85em;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .edit-btn {
            background: #0066ff;
            color: white;
        }

        .edit-btn:hover {
            background: #0052cc;
            transform: translateY(-2px);
        }

        .delete-btn {
            background: #ff6b6b;
            color: white;
        }

        .delete-btn:hover {
            background: #ff5252;
            transform: translateY(-2px);
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
        <h2>👥 Student List</h2>

        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
$sql = "SELECT * FROM student";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><span class='student-id'>#" . $row['student_id'] . "</span></td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . $row['age'] . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>";
        echo "<div class='action-buttons'>";
        echo "<a href='edit_student.php?id=" . $row['student_id'] . "' class='edit-btn'>✏️ Edit</a>";
        echo "<button class='delete-btn' onclick=\"if(confirm('Delete this student?')) { window.location.href='delete_student.php?id=" . $row['student_id'] . "'; }\">🗑️ Delete</button>";
        echo "</div>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5' class='empty-message'>No students found</td></tr>";
}
?>
            </tbody>
        </table>
    </div>
</body>
</html>
