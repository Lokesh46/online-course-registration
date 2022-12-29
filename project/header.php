<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"/>
        <link href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css" rel="stylesheet" />
        <link rel="stylesheet" href="include/header_style.css" />
        <title>Home page</title>
    </head>
    <body><!-- Navbar -->
    
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 fixed-top">
            <div class="container">
                <a href="home.php" class="navbar-brand">Course Registration</a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <form class="form-search" method="get" action="register.php">
                    
                    

                    <div class="wrap">
                        <div class="search">
                            <input class="search-term" type="search" name="search" id="search" placeholder="Search" value="">
                            <button type="submit" class="searchButton">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="collapse navbar-collapse" id="navmenu">
                
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a href="register.php" class="nav-link">Register</a>
                        </li>
                        <li class="nav-item">
                            <a href="timetable.php" class="nav-link">Time table</a>
                        </li>
                        <li class="nav-item">
                            <a href="modify.php" class="nav-link">Modify</a>
                        </li>
                        <li class="nav-item">
                            <a href="acad.php" class="nav-link">Courses(completed)</a>
                        </li>
                        <li class="nav-item">
                            <a id="mydiv" class="nav-link">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
        
        function Confirm(title, msg, $true, $false, $link) { /*change*/
                var $content =  "<div class='dialog-ovelay'>" +
                                "<div class='dialog'><header>" +
                                " <h3> " + title + " </h3> " +
                                "<i class='fa fa-close'></i>" +
                            "</header>" +
                            "<div class='dialog-msg'>" +
                                " <p> " + msg + " </p> " +
                            "</div>" +
                            "<footer>" +
                                "<div class='controls'>" +
                                    " <button class='button button-danger doAction'>" + $true + "</button> " +
                                    " <button class='button button-default cancelAction'>" + $false + "</button> " +
                                "</div>" +
                            "</footer>" +
                        "</div>" +
                        "</div>";
                $('body').prepend($content);
                $('.doAction').click(function () {
                    window.open($link, "_blank"); /*new*/
                    window. close();
                    $(this).parents('.dialog-ovelay').fadeOut(500, function () {
                    $(this).remove();
                    });
                });
                $('.cancelAction, .fa-close').click(function () {
                    $(this).parents('.dialog-ovelay').fadeOut(500, function () {
                    $(this).remove();
                    });
                });
                    
                }
                $('#mydiv').click(function () {
                    Confirm('Logout', 'Are you sure you want to Logout', 'Yes', 'Cancel', "logout.php"); /*change*/
                });
        </script>
    </body>
</html>