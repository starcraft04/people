<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    
    <script src="{{ asset('/plugins/gentelella/vendors/jquery/dist/jquery.min.js') }}" type="text/javascript"></script>

    <title>Offer - ISCO</title>

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
            font-size: 3.5rem;
            }
        }

        .container {
            max-width: 1440px;
        }

        .pricing-header {
            max-width: 700px;
        }

        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
    </style>

  </head>
  <body>
    <header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-body border-bottom shadow-sm">
        <p class="h5 my-0 me-md-auto fw-normal">Offers</p>
        <nav class="my-2 my-md-0 me-md-3">
            <a class="p-2 text-dark" href="#">Teaser</a>
            <a class="p-2 text-dark" href="#">Internal presentation</a>
            <a class="p-2 text-dark" href="#">Customer presentation</a>
            <a class="p-2 text-dark" href="#">Service description</a>
        </nav>
    </header>

    <main class="container">
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">ISCO</h1>
        <p class="lead">Decision-makers understand the increased focus on cybersecurity and this topic is mostly addressed with
            higher up inside organisation with the CISO being viewed as a business partner and not just a focusing on
            operational tasks such as IT systems patching and anti-virus. Organisation recognise they can benefit from the
            CISO, constant upskilling, a greater focus on strategy, and greater executive cooperation. How your CISO can
            cruise through this complex environment?
        </p>
    </div>

    <!-- Selections for the calculation -->
    <div class="row mb-3">
        <div class="col">
            <label for="duration" class="control-label">Contract duration (years)</label>
            <select class="form-select" id="duration" name="duration" data-placeholder="Select a duration">
                <option value="3" selected>3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
            </select>
        </div>
        <div class="col">
            <label for="size" class="control-label">Organization size (employees)</label>
            <select class="form-select" id="size" name="size" data-placeholder="Select a size">
                <option value="3000" selected>3000</option>
                <option value="5000">5000</option>
                <option value="10000">10000</option>
                <option value="10000+">10000+</option>
            </select>
        </div>
    </div>
    <!-- Selections for the calculation -->

    <!-- Packs -->
    <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">

        <!-- Silver -->
        <div class="col">
        <div class="card mb-3 shadow-sm">
        <div class="card-header">
            <h4 class="my-0 fw-normal">Silver</h4>
        </div>
        <div class="card-body">
        <h1 class="card-title pricing-card-title">€<span id="price_silver">1800</span> <small class="text-muted">/ mo</small></h1>
            <h5 class="mb-1">Strategy & Transformation</h5>
            <ul class="list-styled">
                <li>Information Security Policies and Information Classification</li>
                <li>Monitoring, measurement, analysis and evaluation of the Security Strategy implementation</li>
            </ul>
            <hr>
            <h5 class="mb-1">Implementation & Operation</h5>
            <ul class="list-styled">
                <li>Inventory and Control of Hardware & Software Assets</li>
                <li>Continuous Vulnerability Management</li>
                <li>Controlled Use of Administrative Privileges</li>
                <li>Secure Configuration for Servers and End-Point</li>
                <li>Maintenance, Monitoring and Analysis of Audit Logs</li>
                <li>Secure Configuration for Network Devices, such as Firewalls, Routers and Switches</li>
                <li>Penetration test <button type="button" class="btn btn-danger btn-sm">option</button></li>
            </ul>
            <hr>
            <h5 class="mb-1">Security Incident and Crisis Management</h5>
            <ul class="list-styled">
                <li>Incident Response & Crisis management</li>
            </ul>
            <hr>
            <h5 class="mb-1">Monthly follow up</h5>
            <ul class="list-styled">
                <li>Our expert follow up <small>1 day per month</small></li>
            </ul>
            <hr>
            <button type="button" class="w-100 btn btn-lg btn-outline-primary">Get this offer</button>
        </div>
        </div>
        </div>
        <!-- Silver -->

        <!-- Gold -->
        <div class="col">
        <div class="card mb-3 shadow-sm">
        <div class="card-header">
            <h4 class="my-0 fw-normal">Gold</h4>
        </div>
        <div class="card-body">
            <h1 class="card-title pricing-card-title">€<span id="price_gold">3000</span> <small class="text-muted">/ mo</small></h1>
            <h5 class="mb-1">Strategy & Transformation</h5>
            <ul class="list-styled">
                <li>Information Security Policies and Information Classification</li>
                <li>Information Security Risk Management</li>
                <li>Information security objectives and planning</li>
                <li>Monitoring, measurement, analysis and evaluation of the Security Strategy implementation</li>
            </ul>
            <hr>
            <h5 class="mb-1">Implementation & Operation</h5>
            <ul class="list-styled">
                <li>Inventory and Control of Hardware & Software Assets</li>
                <li>Continuous Vulnerability Management</li>
                <li>Controlled Use of Administrative Privileges</li>
                <li>Secure Configuration for Servers and End-Point</li>
                <li>Maintenance, Monitoring and Analysis of Audit Logs</li>
                <li>Email and Web Browser Protections</li>
                <li>Malware Defenses</li>
                <li>Limitation and Control of Network Ports, Protocols and Services</li>
                <li>Data Recovery Capabilities</li>
                <li>Secure Configuration for Network Devices, such as Firewalls, Routers and Switches</li>
                <li>Boundary Defense</li>
                <li>Controlled Access Based on the Need to Know</li>
                <li>Penetration test <button type="button" class="btn btn-danger btn-sm">option</button></li>
            </ul>
            <hr>
            <h5 class="mb-1">Security Incident and Crisis Management</h5>
            <ul class="list-styled">
                <li>Incident Response & Crisis management</li>
            </ul>
            <hr>
            <h5 class="mb-1">Monthly follow up</h5>
            <ul class="list-styled">
                <li>Our expert follow up <small>2 days per month</small></li>
            </ul>
            <hr>
            <button type="button" class="w-100 btn btn-lg btn-outline-primary">Get this offer</button>
        </div>
        </div>
        </div>
        <!-- Gold -->

        <!-- Platinum -->
        <div class="col">
        <div class="card mb-3 shadow-sm">
        <div class="card-header">
            <h4 class="my-0 fw-normal">Platinum</h4>
        </div>
        <div class="card-body">
            <h1 class="card-title pricing-card-title">€<span id="price_platinum">6200</span> <small class="text-muted">/ mo</small></h1>
            <h5 class="mb-1">Strategy & Transformation</h5>
            <ul class="list-styled">
                <li>Strategy & operation evaluation</li>
                <li>Leadership and commitment evaluation</li>
                <li>Information Security Policies and Information Classification</li>
                <li>Organizational roles and responsibilities</li>
                <li>Information Security Risk Management</li>
                <li>Information security objectives and planning</li>
                <li>Managing Resources and Competences</li>
                <li>Security Awareness</li>
                <li>Monitoring, measurement, analysis and evaluation of the Security Strategy implementation</li>
                <li>Human Resources Security</li>
                <li>Supplier relationships</li>
                <li>Physical and environmental security</li>
                <li>Law and Regulations Compliance</li>
            </ul>
            <hr>
            <h5 class="mb-1">Implementation & Operation</h5>
            <ul class="list-styled">
                <li>Inventory and Control of Hardware & Software Assets</li>
                <li>Continuous Vulnerability Management</li>
                <li>Controlled Use of Administrative Privileges</li>
                <li>Secure Configuration for Servers and End-Point</li>
                <li>Maintenance, Monitoring and Analysis of Audit Logs</li>
                <li>Email and Web Browser Protections</li>
                <li>Malware Defenses</li>
                <li>Limitation and Control of Network Ports, Protocols and Services</li>
                <li>Data Recovery Capabilities</li>
                <li>Secure Configuration for Network Devices, such as Firewalls, Routers and Switches</li>
                <li>Boundary Defense</li>
                <li>Data Protection</li>
                <li>Controlled Access Based on the Need to Know</li>
                <li>Wireless Access Control</li>
                <li>Account Monitoring and Control</li>
                <li>Penetration test <button type="button" class="btn btn-danger btn-sm">option</button></li>
            </ul>
            <hr>
            <h5 class="mb-1">Security Incident and Crisis Management</h5>
            <ul class="list-styled">
                <li>Incident Response & Crisis management</li>
                <li>Incident Response Preparedness</li>
                <li>Incident Response Playbook </li>
                <li>Emergency Response <button type="button" class="btn btn-danger btn-sm">option</button></li>
                <li>Compromise assessment <button type="button" class="btn btn-danger btn-sm">option</button></li>
                <li>Forensics investigation <button type="button" class="btn btn-danger btn-sm">option</button></li>
                <li>Malware forensics <button type="button" class="btn btn-danger btn-sm">option</button></li>
                <li>Threat Intelligence <button type="button" class="btn btn-danger btn-sm">option</button></li>
                <li>Cyber Incident & Crisis simulation</li>
            </ul>
            <hr>
            <h5 class="mb-1">Monthly follow up</h5>
            <ul class="list-styled">
                <li>Our expert follow up <small>4 days per month</small></li>
            </ul>
            <hr>

            <button type="button" class="w-100 btn btn-lg btn-primary">Get this offer</button>
        </div>
        </div>
        </div>
        <!-- Platinum -->
    </div>
    <!-- Packs -->

    <!-- Footer -->
    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
        <div class="col-6 col-md">
            <h5>Other offers</h5>
            <ul class="list-unstyled text-small">
            <li><a class="link-secondary" href="#">ISCO for CBU</a></li>
            </ul>
        </div>

        <div class="col-6 col-md">
            <h5>About</h5>
            <ul class="list-unstyled text-small">
            <li><a class="link-secondary" href="#">Team</a></li>
            <li><a class="link-secondary" href="#">Contact us</a></li>
            </ul>
        </div>
        </div>
    </footer>
    <!-- Footer -->

    </main>
    <script>
    var price_silver = 1800;
    var price_gold = 3000;
    var price_platinum = 6200;
    $(document).ready(function() {
        $('#duration,#size').on('change', function() {
            duration = $('select#duration').children("option:selected").val();
            size = $('select#size').children("option:selected").val();
            if (duration == 3 && size == 3000) {
                $('#price_silver').text(price_silver);
                $('#price_gold').text(price_gold);
                $('#price_platinum').text(price_platinum);
            } else {
                switch (size) {
                    case '3000':
                        multiplier = 1;
                        break;
                    case '5000':
                        multiplier = 1.7;
                        break;
                    case '10000':
                        multiplier = 3;
                        break;
                    case '10000+':
                        multiplier = 3.5;
                        break;
                }
                multiplier = multiplier * 3 / duration;
                $('#price_silver').text(Math.round(price_silver*multiplier));
                $('#price_gold').text(Math.round(price_gold*multiplier));
                $('#price_platinum').text(Math.round(price_platinum*multiplier));
            }
        });
    });
    </script>
  </body>
</html>