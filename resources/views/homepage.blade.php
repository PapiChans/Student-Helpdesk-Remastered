<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Help Desk</title>


    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/homepage/favicon.ico')}}">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ asset('css/homepage/bootstrap.min.css')}}" type="text/css">

    <!-- Material Icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/homepage/materialdesignicons.min.css')}}" />


    <!-- Custom  CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/homepage/style.css')}}" />

</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="58">

    <!--Navbar Start-->
    <nav class="navbar navbar-expand-lg fixed-top sticky" id="navbar">
        <div class="container">
            <a class="navbar-brand logo" href="{{'/'}}">
                <img src="{{ asset('images/homepage/logo-light.png')}}" alt="" class="logo-light" height="40" />
                <img src="{{ asset('images/homepage/logo-dark.png')}}" alt="" class="logo-dark" height="40" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0" id="navbar-navlist">
                    <li class="nav-item">
                        <a href="#home" class="nav-link" id="scrollElement">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#services" class="nav-link">Services</a>
                    </li>
                </ul>
                <a href="{{'/login'}}" class="btn btn-info btn-sm navbar-btn my-lg-0 my-2">Log In</a>

            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Hero section Start -->
    <section class="hero-3 position-relative align-items-center justify-content-center d-flex overflow-hidden" style="background-image: url(images/homepage/hero-3-bg.jpg);" id="home">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="row position-relative align-items-center justify-content-center">
                <div class="col-lg-8">
                    <div class="hero-3-content text-center py-5 px-4 mt-4">
                        <span class="con-border-top"></span>
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('images/homepage/favicon.ico')}}" alt="Logo" class="img-fluid" style="height: 100px;">
                        </div>
                        <h1 class="hero-3-title text-white mb-lg-3 mb-2">Student Help Desk</h1>
                        <p class="mb-4 text-white-50"> Welcome to the Student Help Desk. We offer round-the-clock support for all your campus services.</p>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- Hero section End -->

    <!-- Start About -->
    <section class="section" id="services">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="text-center mb-5">
                        <h3 class="mb-3">What are the services we offer?</h3>
                        <p class="text-muted">
                        We offer the following services to support students, clients, and alumni.
                        </p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="text-center p-4">
                        <div class="icons-xl mb-3">
                            <i class="uim uim-bookmark"></i>
                        </div>

                        <h5>Knowledge Base</h5>
                        <p class="text-muted">Access our comprehensive knowledge base for quick answers to common questions and academic resources.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="text-center p-4">
                        <div class="icons-xl mb-3">
                            <i class="uim uim-user-md"></i>
                        </div>

                        <h5>Ticket Support</h5>
                        <p class="text-muted">Submit a ticket for document requests, academic concerns, and other campus-related transactions—all in one place.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="text-center p-4">
                        <div class="icons-xl mb-3">
                            <i class="uim uim-clock"></i>
                        </div>

                        <h5>24/7 Availability</h5>
                        <p class="text-muted">We're always here for you. Access support and services at any time, day or night, all year round.</p>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- end About -->

    <!-- start footer -->
    <footer class="footer bg-dark text-white-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <a href="{{'/'}}" class="d-block mb-3">
                        <img src="{{ asset('images/homepage/favicon.ico')}}" alt="" height="60" />
                    </a>
                    <p>Student Helpdesk Remastered</p>
                </div>

                <div class="col-lg-2 col-sm-6">
                    <div class="mt-4 mt-lg-0">
                        <h5 class="mb-4 font-18 text-white">Links</h5>
                        <ul class="list-unstyled footer-list-menu">
                            <li><a href="#">Official Campus Website</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="mt-4 mt-lg-0">
                        <h5 class="mb-4 font-18 text-white">Resources</h5>
                        <ul class="list-unstyled footer-list-menu">
                            <li><a href="#">Help Center</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="mt-4 mt-lg-0">
                        <h5 class="mb-4 font-18 text-white">Social</h5>
                        <ul class="list-inline social-icons-list">
                            <li class="list-inline-item">
                                <a href="#"><i class="mdi mdi-facebook"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#"><i class="mdi mdi-twitter"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#"><i class="mdi mdi-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </footer>
    <!-- end footer -->

    <!-- Start footer-alt -->
    <section class="footer-alt py-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center text-white-50">
                        <p class="mb-0">
                            <script>document.write(new Date().getFullYear())</script> Student HelpDesk Remastered 
                        </p>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- end footer-alt -->


    <!-- Javascript -->
    <script src="{{ asset('js/homepage/bootstrap.bundle.min.js')}}"></script>

    <!-- unicons -->
    <script src="{{ asset('js/homepage/bundle.js')}}"></script>

    <!-- app js -->
    <script src="{{ asset('js/homepage/app.js')}}"></script>
</body>

</html>