<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="images/logo.png">
    <meta name="description" content="Creating Web Application">
    <meta name="keywords" content="HTML, CSS">
    <meta name="author" content="Do Tien Loc">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Jobs</title>
</head>

<body >
    <?php 
        include 'header.inc';
        include 'settings.php';
    ?>

    <div class="jobs-page">
        <section id="Introduction" class="Introduction">
            <div class="image-section">
                <img src="images/descrip.jpg" alt="Image">
            </div>

            <div class="content">
                <h1 class="title1">About Technical Life</h1>
                <br>
                <br class="hide-on-mobile">
                <h2 class="hide-on-mobile" id="hide-on-mobile2">We Provide Essential Technologies For Your Future Life</h2>
                <p>TechNova Solutions is a leading IT company specializing in cutting-edge software development, and cloud computing.
                    <span class="hide-on-mobile">
                        We empower businesses with innovative digital solutions, ensuring efficiency, security, and scalability. With a team of expert developers and IT professionals.
                    </span>
                </p>
                <br>
                
                <div class="service">
                    <div class="Teamwork">
                        <img src="images/partnership.png" alt="Image">
                        <div class="service-content">
                            <h3>A team of talented engineers</h3>
                            <p>A team of talented and creative engineers is a powerful force. 
                                <span class="hide-on-mobile">
                                    They bring innovative ideas and technical expertise to solve complex problems and build groundbreaking solutions.
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="service">
                    <div class="performance">
                        <img src="images/math.png" alt="Image">
                        <div class="service-content">
                            <h3>High performance with integration</h3>
                            <p>High performance with seamless integration means a system
                                <span class="hide-on-mobile">
                                    or product operates powerfully and efficiently while also connecting and working smoothly with other systems or products.  This combination delivers a superior user experience and maximizes overall effectiveness.
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="service">
                    <div class="opportunity">
                        <img src="images/distributed.png" alt="Image">
                        <div class="service-content">
                            <h3>Exposure to new technologies</h3>
                            <p>Embracing new technology is key for growth.
                                <span class="hide-on-mobile">
                                    It empowers individuals, fuels business innovation, and opens opportunities. While challenges exist, engaging with new tech is essential for staying competitive.
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <ul class="features" id="hide-on-mobile">
                    <li>
                        <img src="images/check-symbol.png" alt="Check">
                        <div>
                            <strong class="jobs-first-strong">Career Growth:</strong> Access to cutting-edge technology, learning from talented colleagues worldwide, clear promotion paths, and involvement in impactful projects.
                        </div>
                    </li>
                    <li>
                        <img src="images/check-symbol.png" alt="Check">
                        <div>
                            <strong class="jobs-first-strong">Environment:</strong> Open culture, respect for diversity, encouragement of creativity and innovation, modern facilities, and often flexible work arrangements.
                        </div>
                    </li>
                </ul>
            </div>
        </section>

        <aside class="description" id="hide-on-mobile">
            <h1>We pioneer transformative changes in global technology</h1>
            <div class="steps">
                <div class="step">
                    <img src="images/interactive.png" alt="interactive">
                    <h2>Interactive</h2>
                    <p>We create opportunities to interact with the world's leading modern and advanced technologies</p>
                </div>
                <div class="step">
                    <img src="images/nanotechnology.png" alt="nanotechnology">
                    <h2>Nanotechnology</h2>
                    <p>NanoTech Innovations leads in nanotechnology, creating advanced solutions that drive innovation</p>
                </div>
                <div class="step">
                    <img src="images/project-management.png" alt="project-management">
                    <h2>Project-management</h2>
                    <p>Effective project management ensures seamless execution and successful outcomes for initiative</p>
                </div>
            </div>
        </aside>
    
        <div id="Job-positions">
            <h1>Available Job Positions</h1>
        </div>
        
        <section class="available-jobs">
            <?php
                $sql = "SELECT jobref, title, description, salary, reports_to, responsibilities, skills FROM jobs";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="job-container">';
                        echo '<div class="job-title">' . htmlspecialchars($row["title"]) . '</div>';
                        echo '<div class="job-ref">Job Reference: ' . htmlspecialchars($row["jobref"]) . '</div>';
                        
                        echo '<div class="section-title">Salary Range</div>';
                        echo '<p class="job-description">' . htmlspecialchars($row["salary"]) . '</p>';
                        
                        echo '<div class="section-title">Reports To</div>';
                        echo '<p class="job-description">' . htmlspecialchars($row["reports_to"]) . '</p>';
                        
                        echo '<div class="section-title">Description of the Position</div>';
                        echo '<p class="job-description">' . htmlspecialchars($row["description"]) . '</p>';
                        
                        echo '<div class="section-title">Responsibilities</div>';
                        echo '<ul>';
                        foreach (explode("\n", $row["responsibilities"]) as $res) {
                            echo '<li>' . htmlspecialchars($res) . '</li>';
                        }
                        echo '</ul>';
                        
                        echo '<div class="section-title">Required Skills</div>';
                        echo '<ul>';
                        foreach (explode("\n", $row["skills"]) as $skill) {
                            echo '<li>' . htmlspecialchars($skill) . '</li>';
                        }
                        echo '</ul>';
                        
                        echo '</div>';
                    }
                } else {
                    echo "<p>No job listings found.</p>";
                }
                
                $conn->close();
            ?>
        </section>
    </div>

    <?php include 'footer.inc'; ?>
</body>