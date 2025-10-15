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
    <title>Home</title>
</head>

<body>
    <?php include 'header.inc'; ?>

    <div class="home-page">
        <div id="banner">
            <div class="box-left">
                <br>
                <h2> Innovator <br> Developer <br> Fellows </h2>
                <p> We are at the forefront of technological development trends</p>
                <a href="https://youtu.be/rKTJNbSkboo?si=KSXL-D-s_303-r5r">Link Video</a>
            </div>
            <div class="box-right" id="hide-on-mobile">
                <img src="images/des.png" alt="Image">
            </div>
        </div>   

        <br>
        <div id="taskbar" class="taskbar">
            <section>
                <div class="stat">
                    <h2>100%</h2>
                    <p>Bachelor's degree</p>
                </div>
                <div class="stat">
                    <h2>450M+</h2>
                    <p>Talent</p>
                </div>
                <div class="stat">
                    <h2>30%</h2>
                    <p>foreign investment</p>
                </div>
                <div class="stat">
                    <h2>80%</h2>
                    <p>Modern equipment</p>
                </div>
            </section>
        </div>

        <nav id="list" class="list">
            <img class="home-last-image" src="images/robot-removebg-preview.png" alt="Image">
            <ul class="features">
                <li>
                    <img src="images/check-symbol.png" alt="Check">
                    <div>
                        <strong>Professional Development:</strong>
                        <p>Access to cutting-edge technology, learning from smart colleagues throughout the world</p>
                    </div>
                </li>
                <li>
                    <img src="images/check-symbol.png" alt="Check">
                    <div>
                        <strong>Communicate: </strong>
                        <p>An open opportunityopportunity, appreciation for diversity, promotion of creativity and innovation</p>
                    </div>
                </li>
                <li>
                    <img src="images/check-symbol.png" alt="Check">
                    <div>
                        <strong>Opportunities for self-development:</strong>
                        <p>Connecting with professionals and brilliant individuals from around the world and different cultures</p>
                    </div>
                </li>
            </ul>

            <div class="home-divL">
                <h3>A groundbreaking leap into the future of technology</h3>
                <p id="p-home-last">A groundbreaking leap into the future of technology is here.  This isn't just progress; it's a fundamental shift.  From AI to biotech, these innovations our world</p> 
            </div>
        </nav>
    </div>

    <?php include 'footer.inc'; ?>
</body>
</html>