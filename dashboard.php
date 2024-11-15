<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Plan</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <style>
      
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      }
      body {
        display: flex;
        height: 100vh;
        background-color: #f5f6fa;
      }

      .dashboard {
        display: grid;
        grid-template-columns: 250px 1fr;
        width: 100%;
      }

      .sidebar {
        background-color: #2c3e50;
        color: #fff;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
      }

      .admin-info {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
      }

      .admin-avatar {
        width: 50px;
        height: 50px;
        background-color: #3498db;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 15px;
      }

      .admin-details h3 {
        font-size: 16px;
        margin-bottom: 5px;
      }

      .admin-details p {
        font-size: 14px;
        opacity: 0.7;
      }

      .nav-items {
        list-style-type: none;
      }

      .nav-items li {
        padding: 15px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
        display: flex;
        align-items: center;
      }

      .nav-items li i {
        margin-right: 10px;
        width: 20px;
      }

      .nav-items li:hover {
        background-color: #34495e;
      }

      .nav-items li.active {
        background-color: #3498db;
      }

      .logout-btn {
        background-color: #e74c3c;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        font-size: 14px;
        transition: background-color 0.3s;
        text-decoration: none;
        margin-top: auto;
      }

      .logout-btn i {
        margin-right: 10px;
      }

      .logout-btn:hover {
        background-color: #c0392b;
      }

     
      .main-content {
        padding: 30px;
      }

      .dashboard-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
      }

      .dashboard-card {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      }

      .dashboard-card h3 {
        margin-bottom: 15px;
      }

      .dashboard-card p {
        font-size: 14px;
        color: #666;
      }

      .view-link {
        color: #3498db;
        text-decoration: none;
        font-weight: 500;
      }
    </style>
  </head>
  <body>
    <div class="dashboard">
      <div class="sidebar">
        <div class="sidebar-top">
          <div class="admin-info">
            <div class="admin-avatar">
              <i class="fas fa-user"></i>
            </div>
            <div class="admin-details">
              <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
            </div>
          </div>
          <ul class="nav-items">
            <li class="active">
              <i class="fas fa-tachometer-alt"></i>
              Dashboard
            </li>
          </ul>
        </div>
        <a href="logout.php" class="logout-btn">
          <i class="fas fa-sign-out-alt"></i>
          Logout
        </a>
      </div>
      <div class="main-content">
        <div class="dashboard-content">
          <div class="dashboard-card">
            <h3>Total Users</h3>
            <p><?php 
              $count = 0;
              $conn = mysqli_connect("localhost", "root", "", "example");
              // to find the number of users in db
              if ($conn) {
                  $query = "SELECT COUNT(*) as total FROM users";
                  $result = mysqli_query($conn, $query);
                  
                  if ($result) {
                      $row = mysqli_fetch_assoc($result);
                      $count = $row['total'];
                  }
                  
                  mysqli_close($conn);
              }

              echo $count;
            ?></p>
          </div>
          <div class="dashboard-card">
            <h3>View users</h3>
            <a href="disp.php" class="view-link">
              View Users
            </a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>