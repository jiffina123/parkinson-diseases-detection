<!DOCTYPE html>
<html lang="en">
<head>
    <?php

            include_once("database.php");
            $data =DataBase::SelectData("SELECT * FROM data ORDER by id desc LIMIT 0, 1;");

            
            $count=0;
            $bm=0;
            $bp=0;
            $ox=0;
            $bt=0;
            $fall=0;
            while($row = $data->fetch_assoc()){
                
                $bm=$row["bm"];
                $bp=$row["bp"];
                $ox=$row["ox"];
                $bt=$row["bt"];
                $fall=$row["fall"];
            }

    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Monitoring with Fall Detection</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            color: black; /* Black text color */
            font-family: "Times New Roman", Times, serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            overflow: hidden;
            padding: 0 20px;
        }
       
        header {
            background: #ffffff;
            padding: 1em 0;
            border-bottom: 1px solid #777575;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 90%;
            margin: 0 auto;
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
            color: #79512e;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 1em;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
            padding: 0.5em 1em;
            border-radius: 5px;
        }

        nav ul li a.active,
        nav ul li a:hover {
            background: #79512e;
            color: #fff;
        }
        .user-headsection{
            padding-top: 10px;
            padding-left: 5px;
            font-size: 32px;
        }
        .main-content {
            display: flex;
            margin: 20px 0;
        }
        .user-list {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            padding: 20px;
            width: 50%;
            box-sizing: border-box;
        }
        .user-list h2 {
            color: black;
        }
        .user-list ul {
            list-style: none;
            padding: 0;
        }
        .user-list li {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #333;
        }
        .user-list li:hover {
            background: #fefefe;
        }
        .user-list li.active {
            background: #ffffff;
        }
        .details-section {
            background: white;
            border-radius: 12px;
            margin: 0 10px;
            width: 100%;
            color: black;
        }
        .card {
            border: 2px solid black;
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            margin-bottom: 20px;
            padding: 20px;
        }
        .alert {
            background: #f44336;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            display: none; /* Initially hidden */
        }
        .button {
            display: inline-block;
            background-color: #79512e;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        .button:hover {
            background-color: #767676;
        }
        .sensor-status {
            margin-top: 10px;
        }
        .sensor-status p {
            margin: 5px 0;
        }
        .chart-container {
            margin-top: 20px;
        }
        .chart-wrapper {
            margin-bottom: 40px;
        }
        .user-info {
            display: flex;
            justify-content: space-between;
        }
        .user-details {
            flex: 1;
        }
        .user-image {
            flex: 1;
            text-align: right;
        }
        .user-image img {
            width: 200px;
            height: auto;
            border-radius: 8px;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid black;
            width: 80%;
            max-width: 500px;
            text-align: center;
            border-radius: 8px;
        }

        .close-button {
            color: black;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-button:hover,
        .close-button:focus {
            color: red;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">Health Sync</div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php" >Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
<div class="container">
    <div class="user-headsection">
        Welcome

    </div>
    <div class="main-content">
        
        <div class="user-list">
            <h2>Users</h2>
            <ul id="userList">
                <li onclick="selectUser('Jiffina Rodrigues', 'female-avatar.png', 70, '50KG', 'B+', 'Hypertension', 'Female')">Jiffina Rodrigues</li>
                <li onclick="selectUser('John Doe', 'male-avatar.jpg', 65, '70KG', 'A+', 'Diabetes', 'Male')">John Doe</li>
                <li onclick="selectUser('Jane Smith', 'female-avatar.png', 60, '65KG', 'O+', 'None', 'Female')">Jane Smith</li>
                
            </ul>
            <button class="button" onclick="openAddUserModal()">Add New User</button>
        </div>
        <div class="details-section" id="detailsSection">
            <div class="card">
                <h2>User Information</h2>
                <div class="user-info">
                    <div class="user-details">
                        <p id="userName">Name: Jiffina Rodrigues</p>
                        <p id="userAge">Age: 70</p>
                        <p id="userWeight">Weight: 50KG</p>
                        <p id="userBloodGroup">Blood Group: B+</p>
                        <p id="userCondition">Medical Condition: Hypertension</p>
                        <p id="userGender">Gender: Female</p>
                        
                    </div>
                    <div class="user-image">
                        <img id="userAvatar" src="female-avatar.png" alt="User Photo">
                    </div>
                </div>
            </div>
            <div class="card">
                <h2>Health Metrics</h2>
                <p>Heart Rate: <span id="heartRate"><?php echo $bm; ?></span> BPM</p>
                <!-- <p>Blood Pressure: <span id="bloodPressure"><?php //echo $bp; ?></span> mmHg</p>
                <p>Oxygen Level: <span id="oxygenLevel"><?php// echo $ox; ?></span>%</p> -->
                <p>Body Temperature: <span id="temperature"><?php echo $bp; ?></span> °C</p>
                <div class="sensor-status">
                    <p>Sensor Status: <span id="sensorStatus">Connecting...</span></p>
                </div>
                <div class="button" onclick="refreshHealthMetrics()">Refresh Metrics</div>
            </div>
            <?php  if($fall==1){ ?>
            <div class="card" style="background-color: red;">
                <h2>Fall Detection <?php echo $fall; ?></h2>
                <p>Status: <span id="fallStatus">Fall Detected</span></p>
                <div class="button" onclick="simulateFall()">Simulate Fall</div>
            </div>

            <?php } else{ ?>
                <div class="card" >
                <h2>Fall Detection <?php echo $fall; ?></h2>
                <p>Status: <span id="fallStatus">No Fall Detected</span></p>
                <div class="button" onclick="simulateFall()">Simulate Fall</div>
            </div>
                <?php } ?>
            <div class="card chart-container">
                <h2>Temperature Chart</h2>
                <div class="chart-wrapper">
                    <canvas id="temperatureChart"></canvas>
                </div>
            </div>
            <div class="card chart-container">
                <h2>Heart Rate Chart</h2>
                <div class="chart-wrapper">
                    <canvas id="heartRateChart"></canvas>
                </div>
            </div>
            <div class="card chart-container">
                <h2>Oxygen Level Chart</h2>
                <div class="chart-wrapper">
                    <canvas id="oxygenLevelChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="alert" id="fallAlert">
        <h2>Fall Detected!</h2>
        <p>Emergency services have been notified.</p>
        <div class="button" onclick="resetFallAlert()">Dismiss</div>
    </div>
</div>

<div id="fallModal" class="modal">
    <div class="modal-content">
        <span class="close-button" onclick="closeModal()">&times;</span>
        <h2>Fall Detected!</h2>
        <p>Emergency services have been notified.</p>
        <div class="button" onclick="closeModal()">Dismiss</div>
    </div>
</div>
<!-- Modal for Add User -->
<div id="addUserModal" class="modal">
    <div class="modal-content">
        <span class="close-button" onclick="closeAddUserModal()">&times;</span>
        <h2>Add New User</h2>
        <form id="addUserForm">
            <label for="newUserName">Name:</label><br>
            <input type="text" id="newUserName" name="newUserName" required><br><br>

            <label for="newUserAge">Age:</label><br>
            <input type="number" id="newUserAge" name="newUserAge" required><br><br>

            <label for="newUserWeight">Weight:</label><br>
            <input type="text" id="newUserWeight" name="newUserWeight" required><br><br>

            <label for="newUserBloodGroup">Blood Group:</label><br>
            <input type="text" id="newUserBloodGroup" name="newUserBloodGroup" required><br><br>

            <label for="newUserCondition">Medical Condition:</label><br>
            <input type="text" id="newUserCondition" name="newUserCondition" required><br><br>

            <label for="newUserGender">Gender:</label><br>
            <input type="radio" id="maleGender" name="newUserGender" value="male" required>
            <label for="maleGender">Male</label><br>
            <input type="radio" id="femaleGender" name="newUserGender" value="female" required>
            <label for="femaleGender">Female</label><br><br>

            <div class="button" onclick="addNewUser()">Submit</div>
        </form>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>

$(document).ready(function() {
  setInterval(function() {
    cache_clear()
  }, 10000);
});

function cache_clear() {
  window.location.reload(true);
  // window.location.reload(); use this if you do not remove cache
}
    // Function to open the Add User modal
    function openAddUserModal() {
        document.getElementById('addUserModal').style.display = 'flex';
    }

    // Function to close the Add User modal
    function closeAddUserModal() {
        document.getElementById('addUserModal').style.display = 'none';
        document.getElementById('addUserForm').reset(); // Reset form fields
    }

    // Function to add a new user
    function addNewUser() {
    const name = document.getElementById('newUserName').value;
    const age = document.getElementById('newUserAge').value;
    const weight = document.getElementById('newUserWeight').value;
    const bloodGroup = document.getElementById('newUserBloodGroup').value;
    const condition = document.getElementById('newUserCondition').value;
    
    let gender;
    if (document.getElementById('maleGender').checked) {
        gender = 'Male';
    } else if (document.getElementById('femaleGender').checked) {
        gender = 'Female';
    } else {
        gender = 'Unknown'; // Handle default case if no gender is selected
    }

    let image;
    if (gender === 'Male') {
        image = 'male-avatar.jpg'; // Replace with actual male avatar URL
    } else if (gender === 'Female') {
        image = 'female-avatar.png'; // Replace with actual female avatar URL
    } else {
        image = 'default-avatar.png'; // Default avatar if gender is not specified or other values
    }

    // Append new user to user list
    const userList = document.getElementById('userList');
    const newUserItem = document.createElement('li');
    newUserItem.textContent = name;
    newUserItem.onclick = function() {
        selectUser(name, image, age, weight, bloodGroup, condition, gender);
    };
    userList.appendChild(newUserItem);

    // Close the modal after adding user
    closeAddUserModal();
}


    // Function to select a user
    function selectUser(name, image, age, weight, bloodGroup, condition, gender) {
        document.getElementById('userName').textContent = "Name: " + name;
        document.getElementById('userAge').textContent = "Age: " + age;
        document.getElementById('userWeight').textContent = "Weight: " + weight;
        document.getElementById('userBloodGroup').textContent = "Blood Group: " + bloodGroup;
        document.getElementById('userCondition').textContent = "Medical Condition: " + condition;
        document.getElementById('userGender').textContent = "Gender: " + gender;
        document.getElementById('userAvatar').src = image;

        // Example: Show details only if charts exist (not shown in example, adjust based on your logic)
        const hasCharts = false; // Adjust this based on your actual condition to show charts
        if (hasCharts) {
            updateCharts();
        }

        updateUserActive(name);
    }

    function refreshHealthMetrics() {
    //document.getElementById('heartRate').textContent = Math.floor(Math.random() * (120 - 60) + 60);
    const systolic = Math.floor(Math.random() * (140 - 110) + 110);
    const diastolic = Math.floor(Math.random() * (90 - 60) + 60);
    // document.getElementById('bloodPressure').textContent = `${systolic}/${diastolic}`;
    // document.getElementById('oxygenLevel').textContent = Math.floor(Math.random() * (100 - 95) + 95);
    // document.getElementById("temperature").innerHTML = (Math.random() * (38.0 - 36.0) + 36.0).toFixed(1) + " °C";
    updateSensorStatus();
    updateCharts();
}
function updateSensorStatus() {
        const statuses = ['Connecting...', 'Connected'];
        document.getElementById('sensorStatus').textContent = statuses[Math.floor(Math.random() * statuses.length)];
    }

    function simulateFall() {
    document.getElementById('fallStatus').textContent = 'Fall Detected!';
    document.getElementById('fallModal').style.display = 'flex';
}

    function closeModal() {
        document.getElementById('fallModal').style.display = 'none';
        document.getElementById('fallStatus').textContent = 'No Fall Detected';
    }
    function updateCharts() {
        const temperatureCtx = document.getElementById('temperatureChart').getContext('2d');
        const heartRateCtx = document.getElementById('heartRateChart').getContext('2d');
        const oxygenLevelCtx = document.getElementById('oxygenLevelChart').getContext('2d');

        new Chart(temperatureCtx, {
            type: 'line',
            data: {
                labels: Array.from({ length: 20 }, (_, i) => i + 1),
                datasets: [{
                    label: 'Temperature',
                    data: Array.from({ length: 20 }, () => (Math.random() * (38.0 - 36.0) + 36.0).toFixed(1)),
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false,
                        max: 40
                    }
                }
            }
        });

        new Chart(heartRateCtx, {
            type: 'line',
            data: {
                labels: Array.from({ length: 20 }, (_, i) => i + 1),
                datasets: [{
                    label: 'Heart Rate',
                    data: Array.from({ length: 20 }, () => Math.floor(Math.random() * (120 - 60) + 60)),
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false,
                        max: 130
                    }
                }
            }
        });

        new Chart(oxygenLevelCtx, {
            type: 'line',
            data: {
                labels: Array.from({ length: 20 }, (_, i) => i + 1),
                datasets: [{
                    label: 'Oxygen Level',
                    data: Array.from({ length: 20 }, () => Math.floor(Math.random() * (100 - 95) + 95)),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false,
                        max: 100
                    }
                }
            }
        });
    }

    setInterval(refreshHealthMetrics, 5000);
    updateSensorStatus();
</script>

</body>
</html>
