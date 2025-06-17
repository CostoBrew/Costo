<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Costobrew</title>
    <!-- Load fonts first -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@160..700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/src/css/style.css" rel="stylesheet">
</head>
<body data-bs-theme="dark" class="text-white">

<?php include __DIR__ . '/includes/header.php'; ?>

<div class="min-vh-100 d-flex flex-wrap align-items-center overflow-hidden bg-kopi" id="home">
    <div class="container-fluid px-0">
        <div>
            <div class="row row-cols-1 row-cols-lg-3 p-3 px-lg-0 text-white">
                <div class="col-lg-3 ps-lg-5 mb-4 mb-lg-0 text-center text-lg-start">
                    <h1 class="font-garamond size-1 text-white">Your Coffee</h1>
                    <p class="px-3 px-lg-0 text-white">Craft your perfect cup from the comfort of your couch! Costobrew is the online coffee haven where your the barista.</p>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                </div>
                <div class="col-lg-3 text-center text-lg-start">
                    <h1 class="font-garamond size-1 text-white">Your Freedom.</h1>
                    <p class="px-3 px-lg-0 text-white">Share your creations, discover new favorites recommended by others, and be part of the online coffee movement.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid px-0 position-absolute bottom-0 pb-5 px-3 px-lg-5 d-flex justify-content-center">
        <div class="d-flex align-items-center flex-column flex-sm-row text-center">
            <a href="/studio/diy" class="btn btn-coffee rounded rounded-pill mb-2 mb-sm-0">Create Your Blend</a>
            <p class="mb-0 mx-2 d-none d-sm-block">- or -</p>
            <p class="mb-2 mb-sm-0 d-sm-none small">or</p>
            <a href="/studio" class="btn btn-outline-light rounded rounded-pill">Explore Coffee Studio</a>
        </div>
    </div>
</div>

<div class="vh-100 d-flex flex-wrap overflow-hidden aboutbg align-items-center" id="about">
    <div class="container-fluid px-0 pt-5 pt-md-5 mt-5 pb-5">
        <div class="">
            <div class="row row-cols-1 p-3">
                <div class="col-lg-8 col-xl-6 ps-lg-5 px-4 px-lg-5">
                    <h1 class="font-garamond size-1">The History of <br class="d-none d-md-block"> Costobrew</h1>
                    <br>
                    <p class="fs-6">Tired of the same old coffee choices? CostoBrew started with a simple idea: you're the barista of your own coffee break! <br><br>
                    We opened our online doors with tons of high-quality beans, from bright and citrusy to bold and roasty. You pick the beans, you pick the grind (strong or smooth?), you even pick the fun stuff like syrups and spices. Want a chocolate chip muffin with your bold brew? Go for it! <br><br>
                    But here's the coolest part: CostoBrew isn't just about you and your cup. We built a whole online spot for coffee lovers to share their favorite creations. We're talking classic combos, crazy inventions with flavored beans, the works! It's like a giant recipe book for coffee lovers. <br><br>
                    So CostoBrew's not just an online coffee shop, it's a place to discover new flavors, share your own creations, and connect with other coffee fanatics. It's your coffee adventure, with friends!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="vh-100 d-flex flex-wrap overflow-hidden mainbg align-items-center" id="contact">
    <div class="container-fluid px-3 px-lg-5 pt-5">
        <div>
            <div class="row row-cols-1 row-cols-lg-2 h-100 g-4">
                <div class="col pe-lg-5">
                    <p class="mb-0">Contact Us</p>
                    <h1 class="font-garamond size-1">Get in Touch With Us</h1>
                    <p class="fs-5">We believe in open communication and value your feedback. Whether you have a question, comment, or suggestion, we'd love to hear from you. Let's connect!</p>

                    <div class="row row-cols-1 mt-5">
                        <div class="col d-flex align-items-center mb-5 flex-column flex-sm-row text-center text-sm-start">
                            <img src="/src/assets/Location.svg" alt="Location" class="img-fluid me-sm-3 mb-3 mb-sm-0" style="width: 60px; height: 60px;">
                            <div class="ms-sm-3">
                            <h5 class="mb-1">Our Location</h5>
                            <p class="mb-0 small">Unit 123, Ground Floor, Mactan Marina Mall, Punta Engaño Road, Lapu-Lapu City, 6015, Mactan Island, Cebu, Philippines</p>
                            </div>
                        </div>
                        <div class="col d-flex align-items-center mb-5 flex-column flex-sm-row text-center text-sm-start">
                            <img src="/src/assets/Contact.svg" alt="Contact" class="img-fluid me-sm-3 mb-3 mb-sm-0" style="width: 60px; height: 60px;">
                            <div class="ms-sm-3">
                            <h5 class="mb-1">Phone Number</h5>
                            <p class="mb-0 small">+63 32 517 3355</p>
                            </div>
                        </div>
                        <div class="col d-flex align-items-center flex-column flex-sm-row text-center text-sm-start">
                            <img src="/src/assets/Email.svg" alt="Email" class="img-fluid me-sm-3 mb-3 mb-sm-0" style="width: 60px; height: 60px;">
                            <div class="ms-sm-3">
                            <h5 class="mb-1">Email Address</h5>
                            <p class="mb-0 small">support.Costobrew@cbcorp.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col d-flex">
                    <div class="p-4 p-lg-5 form-bg w-100 d-flex flex-column ms-lg-5">
                        <div class="mb-4 text-center">
                            <h3 class="font-garamond text-dark mb-2">Send us a message</h3>
                            <p class="text-dark small mb-0">We'll get back to you as soon as possible</p>
                        </div>
                        <form method="POST" id="contactForm" class="d-flex flex-column h-100">
                            <input type="hidden" name="access_key" value="{{ config('services.web3forms.token') }}">
                            <input type="checkbox" name="botcheck" class="hidden" style="display: none;">

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                                <label for="name">Name</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                <label for="email">Email</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone Number">
                                <label for="phone">Phone Number</label>
                            </div>

                            <div class="form-floating mb-3 flex-grow-1">
                                <textarea class="form-control h-100" id="message" name="message" placeholder="Message" required style="min-height: 120px;"></textarea>
                                <label for="message">Message</label>
                            </div>

                            <div id="result" class="mb-3" style="display: none;"></div>
                            <button type="submit" class="btn btn-custom-brown w-100 rounded rounded-pill mt-auto">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/src/js/app.js"></script>

</body>
</html>
