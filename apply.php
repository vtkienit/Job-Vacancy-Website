<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="images/logo.png">
    <meta name="description" content="Creating Web Application">
    <meta name="keywords" content="HTML, CSS">
    <meta name="author" content="Vu Trung Kien">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <title>Job Application</title>
</head>
<body>
    <?php include 'header.inc'; ?>

    <div class="intro">
        <h1>JOIN US↓</h1>
    </div>

    <div class="apply-page">
        <div class="left-content">
            <h2>Benefits</h2>
            <p>Attractive salary based on ability and experience</p>
            <p>Project bonuses, 13th month salary and other benefits.</p>
            <p>Modern working environment, friendly colleagues support</p>
            <p>Full insurance, leave according to regulations</p>

            <h2>Application Method</h2>
            <p>Email: Swinburne@gmail.com</p>
            <p>Phone: 033443857</p>
            <p>Address: Duy Tan, Cau Giay, Hanoi</p>

            <h2>Contact Information</h2>
            <p>Email: Group10@gmail.com</p>
            <p>Phone: 038481609</p>
            <p>Address: Kieu Mai, Bac Tu Liem, Hanoi</p>
        </div>
    
        <div class="right-form">
            <form action="process_eoi.php" novalidate="novalidate" method="post">
                <label for="jobRef">Job Reference Number: </label>
                <input type="text" id="jobRef" name="Job reference number" pattern="[A-Za-z0-9]{5}" required title="Please enter 5 correct alphanumeric characters">
                <br>
                
                <label for="firstname">First Name: </label>
                <input type="text" id="firstName" name="First Name" maxlength="20" pattern="[A-Za-z]{1,20}" required title="Use only alpha characters and up to 20 characters">
                <br>
        
                <label for="lastname">Last Name: </label>
                <input type="text" id="lastName" name="Last Name" maxlength="20" pattern="[A-Za-z]{1,20}" required title="Use only alpha characters and up to 20 characters">
                <br>
        
                <label for="dob">Date of Birth: </label>
                <input type="text" id="dob" name="Date of birth" placeholder="dd/mm/yyyy" pattern="\d{2}/\d{2}/\d{4}" required title="Enter date of birth in dd/mm/yyyy format">
                <br>
        
                <label class="gender">
                    Gender:
                    <label class="male"><input type="radio" id="male" name="Gender" value="Male" required>Male</label>
                    <label class="female"><input type="radio" id="female" name="Gender" value="Female" required>Female</label>
                </label>
        
                <label for="address">Street Address: </label>
                <input type="text" id="address" name="Street Address" maxlength="40" required title="Enter address up to 40 characters">
                <br>
        
                <label for="suburb">Suburb/Town: </label>
                <input type="text" id="suburb" name="Suburb/town" maxlength="40" required title="Enter address up to 40 characters">
                <br>
        
                <label for="state">State:</label>
                <select id="state" name="State" required>
                    <option value="">Select a state</option>
                    <option value="VIC">VIC</option>
                    <option value="NSW">NSW</option>
                    <option value="QLD">QLD</option>
                    <option value="NT">NT</option>
                    <option value="WA">WA</option>
                    <option value="SA">SA</option>
                    <option value="TAS">TAS</option>
                    <option value="ACT">ACT</option>
                </select>

                <br>
        
                <label for="postcode">Postcode: </label>
                <input type="text" id="postcode" name="Postcode" pattern="\d{4}" required title="Enter 4 correct digits">
                
                <br>
        
                <label for="email">Email Address: </label>
                <input type="email" id="email" name="Email" required>
                
                <br>
        
                <label for="phone">Phone Number: </label>
                <input type="text" id="phone" name="Phone number" maxlength="12" pattern="[0-9 ]{8,12}" required title="Enter a phone number from 8 to 12 digits, can contain spaces">
                
                <br>
        
                <label>Skill List: 
                    <div class="skill">
                        <label class="skill1" for="skill1"><input type="checkbox" id="skill1" name="Skills[]" value="HTML" checked="checked">HTML</label>
                        <label class="skill2" for="skill2"><input type="checkbox" id="skill2" name="Skills[]" value="CSS">CSS</label>
                        <label class="skill3" for="skill3"><input type="checkbox" id="skill3" name="Skills[]" value="JavaScript">JavaScript</label>
                        <label class="skill4" for="skillOther"><input type="checkbox" id="skill4" name="Skills[]" value="Others">Others</label>
                    </div>
                </label>
        
                <label for="otherskills">Other Skills:</label>
                <textarea id="otherSkills" name="Other Skills" rows="4" cols="50"></textarea>
                <br>
                
                <div class="applybtn"><button type="submit">Apply</button></div>
            </form>
        </div>
    </div>

    <!-- Thông báo khi có kết quả -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="overlay">
            <div class="notification-box <?php echo $_SESSION['message_type']; ?>">
                <div class="icon">
                    <?php echo $_SESSION['message_type'] === 'success' ? '✅' : '❌'; ?>
                </div>
                <h2><?php echo $_SESSION['message']; ?></h2>
                <button class="close-btn" onclick="closeNotification()">OK</button>
            </div>
        </div>
        <script>
            function closeNotification() {
                document.querySelector('.overlay').style.display = 'none';
            }
        </script>
        <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
    <?php endif; ?>

    <?php include 'footer.inc'; ?>
</body>
</html>
