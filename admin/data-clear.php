<?php
// Process deletion when form is submitted
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {

    // Connect to the database
    $con = mysqli_connect("localhost", "root", "", "scrm_db");
    if (mysqli_connect_errno()) {
        die("Connection Fail: " . mysqli_connect_error());
    }

    // Tables to clear (REPLACE with your actual table names)
    $tables = ['prequest', 'ticket', 'user', 'usercheck'];

    foreach ($tables as $table) {
        $sql = "DELETE FROM $table";
        if (mysqli_query($con, $sql)) {
            $message .= "✅ Data deleted from <b>$table</b><br>";
        } else {
            $message .= "❌ Error deleting from <b>$table</b>: " . mysqli_error($con) . "<br>";
        }

        // Optional: Reset auto-increment
        mysqli_query($con, "ALTER TABLE $table AUTO_INCREMENT = 1");
    }

    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Clear Database Tables</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; background: #f4f4f4; }
        .container { background: #fff; padding: 20px; border-radius: 8px; max-width: 500px; margin: auto; }
        h2 { color: #333; }
        .msg { margin-top: 20px; padding: 10px; background: #e8f5e9; border: 1px solid #c8e6c9; color: #2e7d32; }
        button { padding: 10px 20px; background: #f44336; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #d32f2f; }
    </style>
</head>
<body>
<div class="home_key"><a href="../dashboard.php"> <i class="icon-custom-home text-black"></i> <span class="title text-black">Home</span> <span class="selected"></span>  </a> 
<div class="container">
    <h2>⚠️ Delete All Data (Keep Table Structure)</h2>
    <p>This will delete all rows from selected tables in <b>scrm_db</b> but will keep the table structures.</p>
    <form method="POST" onsubmit="return confirm('Are you sure you want to delete all data? This action cannot be undone!');">
        <button type="submit" name="delete">Delete Data</button>
    </form>

    <?php if ($message): ?>
        <div class="msg"><?= $message ?></div>
    <?php endif; ?>
</div>
</body>
</html>