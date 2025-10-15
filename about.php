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
    <title>About Us</title>
</head>
<body>
    <?php include 'header.inc'; ?>
    
    <div class="about-page">
        <div class="group-info">

            <dl class="stats-list">
                <div class="stat-item">
                    <dt class="stat-number orange" id="hide-on-mobile">Group Name</dt>
                    <dd class="stat-text" id="hide-on-mobile">Kien Loc</dd>
                </div>
                <div class="stat-item">
                    <dt class="stat-number blue" id="st1">Mr. Vu Ngoc Binh</dt>
                </div>
                <div class="stat-item">
                    <dt class="stat-number green" id="hide-on-mobile">Group ID</dt>
                    <dd class="stat-text" id="hide-on-mobile">10</dd>
                </div>
            </dl>

            <div class="image-item">
                <img src="images/Kien_face.png" alt="Central Image">
                <img src="images/vungocbinh.jpg" alt="Central Image">
                <img src="images/Loc_face.png" alt="Central Image">
            </div>

            <dl class="stats-list">
                <div class="stat-item">
                    <dt class="stat-number orange" id="st2">Kien's contributions</dt>
                    <dd class="stat-text" id="st2_1">Create Header, Footer, Apply, About, and Enhancements pages</dd>
                </div>
                <div class="stat-item">
                    <dd class="stat-text" id="st4">Tutor</dd>
                </div>
                <div class="stat-item">
                    <dt class="stat-number green" id="st3">Loc's contributions</dt>
                    <dd class="stat-text" id="st3_1">Create Home, Jobs, Manage, Login, and Sign-up pages</dd>
                </div>
            </dl>
        </div>

        <br id="group-photo"><br><br><br>
        <h2 class="title-group">Group Activities</h2>
        <section class="group-photo">    
            <div class="card">
                <img src="images/1.png" alt="Client Values">
                <h3>Client Values</h3>
                <p>We are obsessed and driven by the values to our customers’ success.</p>
            </div>
            <div class="card">
                <img src="images/2.png" alt="Learn & Grow">
                <h3>Learn & Grow</h3>
                <p>We continuously invest in technologies and people to serve our customers.</p>
            </div>
            <div class="card">
                <img src="images/8.png" alt="Challenging Mission">
                <h3>Challenging Mission</h3>
                <p>We thrive on challenging missions and are passionate about the innovations.</p>
            </div>
            <div class="card" id="hide-on-mobile">
                <img src="images/4.png" alt="Happy Workforce">
                <h3>Happy Workforce</h3>
                <p>We evolve and relentlessly build an inclusive, future-ready and happy workforce.</p>
            </div>
            <div class="card" id="hide-on-mobile">
                <img src="images/7.png" alt="System & Integrity">
                <h3>System & Integrity</h3>
                <p>We take pride in a systematic and integrity-driven approach to all stakeholders.</p>
            </div>
            <div class="card" id="hide-on-mobile">
                <img src="images/6.png" alt="System & Integrity">
                <h3>Innovation & Creativity</h3>
                <p>We encourage constant creativity and innovation, helping our teams develop ideas.</p>
            </div>
        </section>

        <br><br><br>
        <section class="timetable">
            <h2>Our Timetable</h2>
            <div>
                <table>
                    <tr>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Subject</th>
                        <th>Location</th>
                    </tr>
                    <tr>
                        <td>Monday</td>
                        <td>9:00 AM - 11:00 AM</td>
                        <td>Cybersecurity Analyst</td>
                        <td>Room A101</td>
                    </tr>
                    <tr>
                        <td>Wednesday</td>
                        <td>2:00 PM - 4:00 PM</td>
                        <td>Web Development</td>
                        <td>Room B202</td>
                    </tr>
                    <tr>
                        <td>Friday</td>
                        <td>10:00 AM - 12:00 PM</td>
                        <td>Software Engineering</td>
                        <td>Room C303</td>
                    </tr>
                </table>
            </div>
        </section>

        <br><br>
        <section class="extra-info">
            <h3>Our Interests</h3>
            <div>
                <ul>
                    <li><strong>Programming Skills:</strong> HTML, CSS, JavaScript, Python, SQL</li>
                    <li><strong>Hometown:</strong> Various cities across the country</li>
                    <li><strong>Favorite Books:</strong> "Clean Code", "Introduction to Algorithms"</li>
                    <li><strong>Favorite Movies:</strong> "The Social Network", "Interstellar", "Inception"</li>
                </ul>
            </div>
        </section>

        <section class="contact">
            <p>Contact us: <a href="mailto:Group10@gmail.com">Group10@gmail.com</a></p>
        </section>
    </div>
    
    <?php include 'footer.inc'; ?>
</body>
</html>
