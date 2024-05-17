
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

$xml = simplexml_load_file('attendance.xml');
$attendances = $xml->attendance;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $rollNumberToDelete = $_POST['rollNumber'];
    // Find and remove the attendance entry
    foreach ($xml->attendance as $att) {
        if ($att->rollNumber == $rollNumberToDelete) {
            $dom = dom_import_simplexml($att);
            $dom->parentNode->removeChild($dom);
            $xml->asXML('attendance.xml');
            break;
        }
    }
    header("Location: manage-attendance.php"); // Refresh the page
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Attendance</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dashboard.css">
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
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
            <p>Manage Attendance</p>
        </div>

<div class="containertable mt-5">

    <button onclick="window.location.href='add-attendance.php';" style="margin-bottom: 20px;" class="btn btn-primary">
        <i class="fa fa-plus"></i> Add Attendance
    </button>

    <table id="attendanceTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Roll Number</th>
                <th>Name</th>
                <th>Class</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($attendances as $attendance): ?>
            <tr>
                <td><?= htmlspecialchars($attendance->rollNumber) ?></td>
                <td><?= htmlspecialchars($attendance->name) ?></td>
                <td><?= htmlspecialchars($attendance->class) ?></td>
                <td><?= htmlspecialchars($attendance->status) ?></td>
                <td><?= htmlspecialchars($attendance->date) ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="rollNumber" value="<?= $attendance->rollNumber ?>">
                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


</div>
</section>





<script>
$(document).ready(function() {
    $('#attendanceTable').DataTable({
        "pageLength": 5
    });
});
</script>
</body>
</html>
