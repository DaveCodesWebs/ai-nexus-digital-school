<?php
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.htm");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Nexus | Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #6e48aa;
            --secondary: #9d50bb;
            --dark: #333;
            --light: #f5f7fa;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: var(--light);
            color: var(--dark);
        }
        
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, var(--primary), var(--secondary));
            color: white;
            padding: 2rem 1rem;
        }
        
        .main-content {
            flex: 1;
            padding: 2rem;
        }
        
        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .logo i {
            margin-right: 0.5rem;
        }
        
        .nav-menu {
            list-style: none;
        }
        
        .nav-item {
            margin-bottom: 0.5rem;
        }
        
        .nav-link {
            display: block;
            padding: 0.75rem 1rem;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s;
        }
        
        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .nav-link i {
            margin-right: 0.5rem;
            width: 20px;
            text-align: center;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 0.75rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .stat-card h3 {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }
        
        .stat-card p {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--primary);
        }
        
        .charts-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .chart-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .chart-card h2 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
        
        .chart-container {
            height: 300px;
            position: relative;
        }
        
        .recent-comments {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .recent-comments h2 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
        
        .comment {
            display: flex;
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
        }
        
        .comment:last-child {
            border-bottom: none;
        }
        
        .comment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-weight: 600;
        }
        
        .comment-content {
            flex: 1;
        }
        
        .comment-author {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .comment-text {
            color: #666;
            margin-bottom: 0.5rem;
        }
        
        .comment-date {
            font-size: 0.8rem;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <div class="logo">
                <i class="fas fa-robot"></i>
                <span>AI Nexus</span>
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users"></i>
                        Users
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-comments"></i>
                        Comments
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-chart-line"></i>
                        Analytics
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cog"></i>
                        Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="main-content">
            <div class="header">
                <h1>Dashboard</h1>
                <div class="user-info">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=6e48aa&color=fff" alt="Admin">
                    <span>Admin</span>
                </div>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Visitors</h3>
                    <p>1,248</p>
                </div>
                <div class="stat-card">
                    <h3>New Users</h3>
                    <p>56</p>
                </div>
                <div class="stat-card">
                    <h3>Comments</h3>
                    <p>128</p>
                </div>
                <div class="stat-card">
                    <h3>Engagement</h3>
                    <p>78%</p>
                </div>
            </div>
            
            <div class="charts-container">
                <div class="chart-card">
                    <h2>Site Visits</h2>
                    <div class="chart-container">
                        <canvas id="visitsChart"></canvas>
                    </div>
                </div>
                <div class="chart-card">
                    <h2>Traffic Sources</h2>
                    <div class="chart-container">
                        <canvas id="trafficChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="recent-comments">
                <h2>Recent Comments</h2>
                <div class="comment">
                    <div class="comment-avatar">JD</div>
                    <div class="comment-content">
                        <div class="comment-author">John Doe</div>
                        <div class="comment-text">This AI tool is amazing! It helped me solve my problem in minutes.</div>
                        <div class="comment-date">2 hours ago</div>
                    </div>
                </div>
                <div class="comment">
                    <div class="comment-avatar">AS</div>
                    <div class="comment-content">
                        <div class="comment-author">Alice Smith</div>
                        <div class="comment-text">The interface could be more intuitive, but the functionality is great.</div>
                        <div class="comment-date">5 hours ago</div>
                    </div>
                </div>
                <div class="comment">
                    <div class="comment-avatar">RJ</div>
                    <div class="comment-content">
                        <div class="comment-author">Robert Johnson</div>
                        <div class="comment-text">I've been using this for a week now and it's transformed my workflow.</div>
                        <div class="comment-date">1 day ago</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Visits Chart
        const visitsCtx = document.getElementById('visitsChart').getContext('2d');
        const visitsChart = new Chart(visitsCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Unique Visitors',
                    data: [650, 590, 800, 810, 1050, 1248],
                    borderColor: '#6e48aa',
                    backgroundColor: 'rgba(110, 72, 170, 0.1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
        
        // Traffic Chart
        const trafficCtx = document.getElementById('trafficChart').getContext('2d');
        const trafficChart = new Chart(trafficCtx, {
            type: 'doughnut',
            data: {
                labels: ['Direct', 'Social', 'Referral', 'Organic'],
                datasets: [{
                    data: [35, 25, 20, 20],
                    backgroundColor: [
                        '#6e48aa',
                        '#9d50bb',
                        '#4776E6',
                        '#53A0FD'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>