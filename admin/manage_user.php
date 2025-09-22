<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Database Connection
include '../include/db_conn.php';

// Handle Delete User
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $delete_sql = "DELETE FROM users WHERE user_id = '$delete_id'";
    mysqli_query($conn, $delete_sql);
}

// Search Logic
$searchQuery = "";
$sql = "SELECT * FROM users"; // Default query

if (!empty($_POST['search'])) {
    $searchQuery = $_POST['search'];


    $sql = "SELECT * FROM users WHERE 
            name LIKE '%$searchQuery%' OR 
            email LIKE '%$searchQuery%' OR 
            phone LIKE '%$searchQuery%' OR 
            address LIKE '%$searchQuery%'";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="ASSETS/css/admin_style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .search-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .search-bar input {
            width: 80%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .search-bar button {
            padding: 8px 15px;
            background: #2575fc;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .user-table {
            width: 100%;
            border-collapse: collapse;
        }
        .user-table th, .user-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .user-table th {
            background: #2575fc;
            color: white;
        }
        .actions a {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .edit-btn {
            background: #f0ad4e;
            color: white;
        }
        .delete-btn {
            background: #d9534f;
            color: white;
        }
        .message {
            text-align: center;
            font-weight: bold;
            color: green;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<?php include '../include/admin_navbar.php'; ?>
    <div class="container">
        <h2>Manage Users</h2>
        <form method="POST" class="search-bar">
            <input type="text" name="search" placeholder="Search users..." value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit">Search</button>
        </form>
        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                              
                                <td><?php echo $row['user_id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['password']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['address']; ?></td>
                                <td class='actions'>
                                    <a href="edit_user.php?id=<?php echo $row['user_id'];?>" class="edit-btn">Edit</a>
                                    <a href="manage_user.php?delete_id=<?php echo $row['user_id']; ?>" class="delete-btn"
                                    onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                </td>
                              </tr>
                   <?php }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
