<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sidebar with Dropdown</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background: #2c3e50;
            height: 100vh;
            color: white;
            padding: 20px;
        }
        .sidebar h2 {
            margin-bottom: 20px;
        }
        .sidebar a, .dropdown-btn {
            color: white;
            display: block;
            padding: 10px;
            text-decoration: none;
            border: none;
            background: none;
            text-align: left;
            width: 100%;
            cursor: pointer;
        }
        .sidebar a:hover, .dropdown-btn:hover {
            background: #34495e;
        }
        .dropdown-container {
            display: none;
            padding-left: 20px;
        }
        .dropdown-btn{
            background: #2c3e50;
            border: none;
            text-align: left;
            width: 100%;
            font-size: 22px;
            cursor: pointer;
            outline: none;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin</h2>

        <button class="dropdown-btn">About</button>
        <div class="dropdown-container">
            <a href="about.add">Add</a>
            <a href="about.list">List</a>
        </div>

        <button class="dropdown-btn">Services</button>
        <div class="dropdown-container">
            <a href="services.add">Add</a>
            <a href="services.list">List</a>
        </div>
        <button class="dropdown-btn">Team</button>
        <div class="dropdown-container">
            <a href="team.add">Add</a>
            <a href="team.list">List</a>
        </div>
        <button class="dropdown-btn">Testimonial</button>
        <div class="dropdown-container">
            <a href="testimonial.add">Add</a>
            <a href="testimonial.list">List</a>
        </div>


    </div>

    <script>
        document.querySelectorAll('.dropdown-btn').forEach(function(btn) {
            btn.addEventListener('click', function () {
                this.classList.toggle('active');
                const dropdown = this.nextElementSibling;
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            });
        });
    </script>
</body>
</html>
