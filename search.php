<?php include('config.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Blood - BloodFlow</title>
    <link rel="stylesheet" href="search.css"> <!-- Make sure search.css is in the folder -->
</head>
<body>
<?php include('navbar.php'); ?>

<div class="search-container">
    <h2>Search for a <span>Lifesaver</span></h2>
    
    <div class="search-form">
        <form action="" method="GET">
            <select name="blood_group" required>
                <option value="">Select Blood Group</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
            </select>
            <button type="submit" class="btn-box-red">Search Now</button>
        </form>
    </div>

    <div class="request-grid">
        <?php 
        if(isset($_GET['blood_group'])) {
            $blood = mysqli_real_escape_string($conn, $_GET['blood_group']);
            $query = "SELECT * FROM requests WHERE blood_group='$blood' AND status='pending'";
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
        ?>
                    <div class="request-card">
                        <h3><?php echo $row['blood_group']; ?> Required</h3>
                        <p><strong>Recipient:</strong> <?php echo $row['recipient_name']; ?></p>
                        <p><strong>Hospital:</strong> <?php echo $row['hospital']; ?></p>
                        <p><strong>Location:</strong> <?php echo $row['location']; ?></p>
                        <a href="login.php" class="btn-box-red">View Details</a>
                    </div>
        <?php 
                }
            } else {
                echo "<p>No pending requests found for this blood group.</p>";
            }
        }
        ?>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>