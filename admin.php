<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
?>

<link rel="stylesheet" href="style.css">

<div class="container">
<div class="dashboard">

    <h2 class="welcome">Admin Panel</h2>
    <div class="card">
        <h3>Attendance Records</h3>

        <table class="attendance-table">
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Hours</th>
            </tr>

            <?php
            $attendance = $conn->query("
                SELECT users.name, attendance.date, attendance.time_in, attendance.time_out, attendance.total_hours
                FROM attendance
                JOIN users ON users.id = attendance.user_id
                ORDER BY attendance.date DESC
            ");

            $no = 1;
            while($row = $attendance->fetch_assoc()):
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['date'] ?></td>
                <td><?= $row['time_in'] ?? '-' ?></td>
                <td><?= $row['time_out'] ?? '-' ?></td>
                <td><?= $row['total_hours'] ? number_format($row['total_hours'],2) : '-' ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <div class="card">
        <h3>Total Hours Summary</h3>

        <table class="attendance-table">
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Total Hours</th>
            </tr>

            <?php
            $summary = $conn->query("
                SELECT users.name, SUM(total_hours) as total
                FROM attendance
                JOIN users ON users.id = attendance.user_id
                GROUP BY user_id
            ");

            $no = 1;
            while($row = $summary->fetch_assoc()):
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= number_format($row['total'],2) ?> hrs</td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <div class="card">
        <h3>Leave Requests</h3>

        <?php
        if(isset($_GET['approve'])){
            $id = $_GET['approve'];
            $conn->query("UPDATE leaves SET status='approved' WHERE id=$id");
        }

        if(isset($_GET['reject'])){
            $id = $_GET['reject'];
            $conn->query("UPDATE leaves SET status='rejected' WHERE id=$id");
        }
        ?>

        <table class="attendance-table">
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php
            $leaves = $conn->query("
                SELECT leaves.*, users.name 
                FROM leaves 
                JOIN users ON users.id = leaves.user_id
                ORDER BY leaves.id DESC
            ");

            $no = 1;
            while($row = $leaves->fetch_assoc()):
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['leave_date'] ?></td>
                <td><?= $row['reason'] ?></td>
                <td><?= ucfirst($row['status']) ?></td>
                <td>
                    <?php if($row['status'] == 'pending'): ?>
                        <a href="?approve=<?= $row['id'] ?>">Approve</a> |
                        <a href="?reject=<?= $row['id'] ?>">Reject</a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <a href="logout.php" class="logout-btn">Logout</a>

</div>
</div>