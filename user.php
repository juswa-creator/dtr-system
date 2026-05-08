<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$user_id = $user['id'];
$date = date("Y-m-d");
?>

<link rel="stylesheet" href="style.css">

<div class="container">
<div class="dashboard">

    <h2 class="welcome">Welcome <?= $user['name'] ?></h2>

    <!-- TIME CARD -->
    <div class="card">
        <h3>Time Tracking</h3>

        <form method="POST" class="time-actions">
            <button name="time_in">Time In</button>
            <button name="time_out">Time Out</button>
        </form>

        <div class="message">
        <?php
        if(isset($_POST['time_in'])){
            $time = date("H:i:s");
            $check = $conn->query("SELECT * FROM attendance WHERE user_id='$user_id' AND date='$date'");
            
            if($check->num_rows == 0){
                $conn->query("INSERT INTO attendance(user_id,date,time_in) VALUES('$user_id','$date','$time')");
                echo "Time In recorded!";
            } else {
                echo "Already timed in today!";
            }
        }

        if(isset($_POST['time_out'])){
            $time = date("H:i:s");
            $record = $conn->query("SELECT * FROM attendance WHERE user_id='$user_id' AND date='$date'")->fetch_assoc();

            if($record && $record['time_out'] == NULL){
                $time_in = strtotime($record['time_in']);
                $time_out = strtotime($time);
                $hours = ($time_out - $time_in) / 3600;

                $conn->query("UPDATE attendance 
                    SET time_out='$time', total_hours='$hours' 
                    WHERE id=".$record['id']);

                echo "Time Out recorded!";
            } else {
                echo "No time-in found or already timed out!";
            }
        }
        ?>
        </div>
    </div>
    <div class="card">
        <h3>Attendance Record</h3>

        <table class="attendance-table">
            <tr>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Total Hours</th>
            </tr>

            <?php
            $records = $conn->query("SELECT * FROM attendance WHERE user_id='$user_id' ORDER BY date DESC");

            while($row = $records->fetch_assoc()){
                echo "<tr>
                        <td>".$row['date']."</td>
                        <td>".($row['time_in'] ?? '-')."</td>
                        <td>".($row['time_out'] ?? '-')."</td>
                        <td>".($row['total_hours'] ? number_format($row['total_hours'],2) : '-')."</td>
                      </tr>";
            }
            ?>
        </table>
    </div>

    <!-- LEAVE -->
<div class="card">
    <h3>Leave Request</h3>

    <form method="POST">
        <input type="date" name="leave_date" required>
        <textarea name="reason" placeholder="Reason" required></textarea>
        <button name="leave">Submit</button>
    </form>

    <?php
    if(isset($_POST['leave'])){
        $leave_date = $_POST['leave_date'];
        $reason = $conn->real_escape_string($_POST['reason']);

        $conn->query("INSERT INTO leaves(user_id, leave_date, reason, status)
                      VALUES('$user_id','$leave_date','$reason','pending')");

        echo "<p>Leave submitted!</p>";
    }
    ?>
    <h4 style="margin-top:20px;">My Leave Requests</h4>

    <table class="attendance-table">
        <tr>
            <th>Date</th>
            <th>Reason</th>
            <th>Status</th>
        </tr>

        <?php
        $leaves = $conn->query("SELECT * FROM leaves WHERE user_id='$user_id' ORDER BY id DESC");

        while($row = $leaves->fetch_assoc()){
            echo "<tr>
                    <td>".$row['leave_date']."</td>
                    <td>".$row['reason']."</td>
                    <td>".$row['status']."</td>
                  </tr>";
        }
        ?>
    </table>
    <a href="logout.php" class="logout-btn">Logout</a>

</div>