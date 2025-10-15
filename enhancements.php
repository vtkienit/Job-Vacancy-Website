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
    <title>Enhancements</title>
</head>
<body>
    <?php include 'header.inc'; ?>
    
    <div class="enhancements-container">
        <dl>
            <dt>
                Wave background effect
                <a href="about.php">[View Here]</a>
            </dt>
            <dd>
                <p>This effect creates dynamic waves of alternating colors, adding a mesmerizing touch to the background</p>
                <code class="css-code">
                    .card {
                        background: linear-gradient(-45deg, #AAAAAA, #777777, #AAAAAA);
                        background-size: 300% 300%;
                        animation: waveBackground 3s infinite ease-in-out;
                    }

                    @keyframes waveBackground {
                        0% {
                            background-position: 0% 0%;
                        }
                        50% {
                            background-position: 100% 100%;
                        }
                        100% {
                            background-position: 0% 0%;
                        }
                    }

                </code>
            </dd>
            <br>
            <dt>
                Effect of changing position and scale of components
                <a href="index.php">[View Here]</a>
            </dt>
            <dd>
                <p>This application allows you to adjust the position and scale of objects, enhancing their prominence and visual appeal on the website</p>
                <code class="css-code">
                    .box-left a {
                        animation: moveY 3s ease-in-out infinite, zoomText 1.75sease-in-out infinite;
                    }

                    @keyframes moveY{
                        0%{
                            transform: translateY(0px);
                        }
                        50%{
                            transform: translateY(-10px);
                        }
                        100%{
                            transform: translateY(0px);
                        }
                    }

                    @keyframes zoomText {
                        0% { 
                            transform: scale(1); 
                            text-shadow: 0px 0px 0px rgba(0, 0, 0, 0); 
                        } 
                        50% { 
                            transform: scale(1.07);
                            text-shadow: 4px 4px 10px rgba(0, 0, 0, 0.3);
                        } 
                        100% { 
                            transform: scale(1);
                            text-shadow: 0px 0px 0px rgba(0, 0, 0, 0);
                        }
                    }
                </code>
            </dd>
            <br>
            <dt>
                Hover effect with background transition
                <a href="jobs.php">[View Here]</a>
            </dt>
            <dd>
                <p>This effect makes the interface dynamic and smooth. You can observe this effect by hovering over the header menus above</p>
                <code class="css-code">
                    .navbar ul li a::before {
                        top: 0;
                        left: -101%;
                        background: linear-gradient(to right, #000000, #FF0000);
                        transition: left 0.3s ease-in-out;
                        z-index: -1;
                        position: absolute;
                        content: "";
                    }
                    
                    .navbar ul li a:hover {
                        color: #FFFFFF;
                    }
                    
                    .navbar ul li a:hover::before {
                        left: 0;
                    }
                </code>
            </dd>
            <br>
            <dt>
                Responsive to different screen sizes
                <a href="apply.php">[View Here]</a>
            </dt>
            <dd>
                <p>This ensures the website displays beautifully across various devices, including phones, tablets, and computers</p>
                <code class="css-code">
                    @media (max-width: 530px)

                    @media (max-width: 600px)

                    @media (max-width: 800px)

                    @media (max-width: 1230px)

                    @media (max-width: 1350px)
                    
                    @media (The remaining larger measurements)
                </code>
            </dd>
        </dl>
    </div>
    
    <?php include 'footer.inc'; ?>
</body>
</html>
