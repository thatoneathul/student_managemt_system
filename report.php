<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - AcademyPro</title>
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
            max-width: 1100px;
            margin: 50px auto;
            padding: 40px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        h2 {
            color: #0066ff;
            font-size: 2em;
            margin-bottom: 40px;
            font-weight: 800;
        }

        h3 {
            color: #333;
            font-size: 1.3em;
            margin: 30px 0 20px 0;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .report-section {
            margin-bottom: 40px;
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

        .divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #0066ff, transparent);
            margin: 40px 0;
        }

        .mark-badge {
            display: inline-block;
            background: linear-gradient(135deg, #0066ff, #00d4ff);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9em;
        }

        .avg-badge {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9em;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .edit-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            font-size: 0.85em;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            background: #0066ff;
            color: white;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .edit-btn:hover {
            background: #0052cc;
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
        <h2>📈 Student Performance Report</h2>

        <!-- VIEW BASED REPORT -->
        <div class="report-section">
            <h3>👥 Student Performance</h3>
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Course</th>
                        <th>Marks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$viewQuery = "SELECT m.mark_id, s.name, c.course_name, m.marks FROM marks m
              JOIN enrollment e ON m.enroll_id = e.enroll_id
              JOIN student s ON e.student_id = s.student_id
              JOIN course c ON e.course_id = c.course_id
              ORDER BY s.name";
$viewResult = mysqli_query($conn, $viewQuery);

if (mysqli_num_rows($viewResult) > 0) {
    while ($row = mysqli_fetch_assoc($viewResult)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['course_name']) . "</td>";
        echo "<td><span class='mark-badge'>{$row['marks']}</span></td>";
        echo "<td><a href='edit_marks.php?id=" . $row['mark_id'] . "' class='edit-btn'>✏️ Edit</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4' class='empty-message'>No performance data available</td></tr>";
}
?>
                </tbody>
            </table>
        </div>

        <div class="divider"></div>

        <!-- AGGREGATE FUNCTION REPORT -->
        <div class="report-section">
            <h3>📊 Average Marks Per Course</h3>
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Average Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$aggQuery = "
    SELECT c.course_name, AVG(m.marks) AS avg_marks
    FROM course c
    LEFT JOIN enrollment e ON c.course_id = e.course_id
    LEFT JOIN marks m ON e.enroll_id = m.enroll_id
    GROUP BY c.course_id, c.course_name
";
$aggResult = mysqli_query($conn, $aggQuery);

if (mysqli_num_rows($aggResult) > 0) {
    while ($row = mysqli_fetch_assoc($aggResult)) {
        $avgMarks = $row['avg_marks'] ? number_format($row['avg_marks'], 2) : 'N/A';
        echo "<tr>";
        echo "<td>{$row['course_name']}</td>";
        echo "<td><span class='avg-badge'>{$avgMarks}</span></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='2' class='empty-message'>No average marks data available</td></tr>";
}
?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
