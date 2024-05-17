<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>School Attendance System - Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="dashboard.css">
</head>
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rollNumber = $_POST['rollNumber'];
    $name = $_POST['name'];
    $class = $_POST['class'];
    $status = $_POST['status'];
    $date = $_POST['date'];  

    $xml = simplexml_load_file('attendance.xml');
    $attendance = $xml->addChild('attendance');
    $attendance->addChild('rollNumber', $rollNumber);
    $attendance->addChild('name', $name);
    $attendance->addChild('class', $class);
    $attendance->addChild('status', $status);
    $attendance->addChild('date', $date);
    $xml->asXML('attendance.xml');

    header("Location: manage-attendance.php"); // Refresh the page
}

$attendances = simplexml_load_file('attendance.xml');

?>

<body>
<section id="sidebar">

<div id="sidebar-nav">
<ul>
<li class="active"><a href="manage-attendance.php"><i class="fa fa-school"></i> Attendance</a></li>
<li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>


</form>
</ul>
</div>
</section>


<section id="content">

    <div class="content">
        <div class="content-header">
            <h1>School Attendance System</h1>
            <p>Add Attendance</p>
        </div>

    <div class="container">

        <form method="post" class="attendance-form">
            <div class="form-field">
                <label>Roll Number:</label>
                <input type="number" name="rollNumber" required>
            </div>
            <div class="form-field">
                <label>Name:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-field">
                <label>Class:</label>
                <select name="class">
                    <option value="10A">10A</option>
                    <option value="10B">10B</option>
                </select>
            </div>
            <div class="form-field">
                <label>Status:</label>
                <select name="status">
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>
            </div>
          <div class="form-field">
                <label>Date:</label>
                <input type="date" name="date" required>
            </div>
            <button type="submit" class="submit-button">Add Attendance</button>
        </form>
           <?php if ($attendance): ?>
        <div class="alert-success">
            Attendance added successfully!
        </div>
    <?php endif; ?>

    </div>
    </div>
    <script>
    window.onload = function() {
        // Check if the success message element exists
        var successMessage = document.querySelector('.alert-success');
        if (successMessage) {
            // Set a timeout to hide the message after 2000 milliseconds (2 seconds)
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 2000);
        }
    };
</script>

</section>
</body>
</html>