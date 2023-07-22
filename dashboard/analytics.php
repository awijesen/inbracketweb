<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Falcon | Dashboard &amp; Web App Template</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicons/favicon.ico">
    <link rel="manifest" href="../assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="../assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="../assets/js/config.js"></script>
    <script src="../vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="../vendors/leaflet/leaflet.css" rel="stylesheet">
    <link href="../vendors/leaflet.markercluster/MarkerCluster.css" rel="stylesheet">
    <link href="../vendors/leaflet.markercluster/MarkerCluster.Default.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <link href="../vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">
    <link href="../assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl">
    <link href="../assets/css/theme.min.css" rel="stylesheet" id="style-default">
    <link href="../assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl">
    <link href="../assets/css/user.min.css" rel="stylesheet" id="user-style-default">
    <script>
      var isRTL = JSON.parse(localStorage.getItem('isRTL'));
      if (isRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>
  </head>


  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <div class="container" data-layout="container">
        <script>
          var isFluid = JSON.parse(localStorage.getItem('isFluid'));
          if (isFluid) {
            var container = document.querySelector('[data-layout]');
            container.classList.remove('container');
            container.classList.add('container-fluid');
          }
        </script>
        <nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
          <script>
            var navbarStyle = localStorage.getItem("navbarStyle");
            if (navbarStyle && navbarStyle !== 'transparent') {
              document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
            }
          </script>
          <div class="d-flex align-items-center">
            <div class="toggle-icon-wrapper">

              <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>

            </div><a class="navbar-brand" href="../index.html">
              <div class="d-flex align-items-center py-3"><img class="me-2" src="../assets/img/icons/spot-illustrations/falcon.png" alt="" width="40" /><span class="font-sans-serif">falcon</span>
              </div>
            </a>
          </div>
          <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
            <?php require('../menu/main_nav.php'); ?> 
          </div>
        </nav>
        <div class="content">
          <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">

            <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
            <a class="navbar-brand me-1 me-sm-3" href="../index.html">
              <div class="d-flex align-items-center"><img class="me-2" src="../assets/img/icons/spot-illustrations/falcon.png" alt="" width="40" /><span class="font-sans-serif">falcon</span>
              </div>
            </a>
            <ul class="navbar-nav align-items-center d-none d-lg-block">
              <li class="nav-item">
                <div class="search-box" data-list='{"valueNames":["title"]}'>
                  <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                    <input class="form-control search-input fuzzy-search" type="search" placeholder="Search..." aria-label="Search" />
                    <span class="fas fa-search search-box-icon"></span>

                  </form>
                  <div class="btn-close-falcon-container position-absolute end-0 top-50 translate-middle shadow-none" data-bs-dismiss="search">
                    <div class="btn-close-falcon" aria-label="Close"></div>
                  </div>
                  <div class="dropdown-menu border font-base start-0 mt-2 py-0 overflow-hidden w-100">
                    <div class="scrollbar list py-3" style="max-height: 24rem;">
                      <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">Recently Browsed</h6><a class="dropdown-item fs--1 px-card py-1 hover-primary" href="../app/events/event-detail.html">
                        <div class="d-flex align-items-center">
                          <span class="fas fa-circle me-2 text-300 fs--2"></span>

                          <div class="fw-normal title">Pages <span class="fas fa-chevron-right mx-1 text-500 fs--2" data-fa-transform="shrink-2"></span> Events</div>
                        </div>
                      </a>
                      <a class="dropdown-item fs--1 px-card py-1 hover-primary" href="../app/e-commerce/customers.html">
                        <div class="d-flex align-items-center">
                          <span class="fas fa-circle me-2 text-300 fs--2"></span>

                          <div class="fw-normal title">E-commerce <span class="fas fa-chevron-right mx-1 text-500 fs--2" data-fa-transform="shrink-2"></span> Customers</div>
                        </div>
                      </a>

                      <hr class="bg-200 dark__bg-900" />
                      <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">Suggested Filter</h6><a class="dropdown-item px-card py-1 fs-0" href="../app/e-commerce/customers.html">
                        <div class="d-flex align-items-center"><span class="badge fw-medium text-decoration-none me-2 badge-soft-warning">customers:</span>
                          <div class="flex-1 fs--1 title">All customers list</div>
                        </div>
                      </a>
                      <a class="dropdown-item px-card py-1 fs-0" href="../app/events/event-detail.html">
                        <div class="d-flex align-items-center"><span class="badge fw-medium text-decoration-none me-2 badge-soft-success">events:</span>
                          <div class="flex-1 fs--1 title">Latest events in current month</div>
                        </div>
                      </a>
                      <a class="dropdown-item px-card py-1 fs-0" href="../app/e-commerce/product/product-grid.html">
                        <div class="d-flex align-items-center"><span class="badge fw-medium text-decoration-none me-2 badge-soft-info">products:</span>
                          <div class="flex-1 fs--1 title">Most popular products</div>
                        </div>
                      </a>

                      <hr class="bg-200 dark__bg-900" />
                      <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">Files</h6><a class="dropdown-item px-card py-2" href="#!">
                        <div class="d-flex align-items-center">
                          <div class="file-thumbnail me-2"><img class="border h-100 w-100 fit-cover rounded-3" src="../assets/img/products/3-thumb.png" alt="" /></div>
                          <div class="flex-1">
                            <h6 class="mb-0 title">iPhone</h6>
                            <p class="fs--2 mb-0 d-flex"><span class="fw-semi-bold">Antony</span><span class="fw-medium text-600 ms-2">27 Sep at 10:30 AM</span></p>
                          </div>
                        </div>
                      </a>
                      <a class="dropdown-item px-card py-2" href="#!">
                        <div class="d-flex align-items-center">
                          <div class="file-thumbnail me-2"><img class="img-fluid" src="../assets/img/icons/zip.png" alt="" /></div>
                          <div class="flex-1">
                            <h6 class="mb-0 title">Falcon v1.8.2</h6>
                            <p class="fs--2 mb-0 d-flex"><span class="fw-semi-bold">John</span><span class="fw-medium text-600 ms-2">30 Sep at 12:30 PM</span></p>
                          </div>
                        </div>
                      </a>

                      <hr class="bg-200 dark__bg-900" />
                      <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">Members</h6><a class="dropdown-item px-card py-2" href="../pages/user/profile.html">
                        <div class="d-flex align-items-center">
                          <div class="avatar avatar-l status-online me-2">
                            <img class="rounded-circle" src="../assets/img/team/1.jpg" alt="" />

                          </div>
                          <div class="flex-1">
                            <h6 class="mb-0 title">Anna Karinina</h6>
                            <p class="fs--2 mb-0 d-flex">Technext Limited</p>
                          </div>
                        </div>
                      </a>
                      <a class="dropdown-item px-card py-2" href="../pages/user/profile.html">
                        <div class="d-flex align-items-center">
                          <div class="avatar avatar-l me-2">
                            <img class="rounded-circle" src="../assets/img/team/2.jpg" alt="" />

                          </div>
                          <div class="flex-1">
                            <h6 class="mb-0 title">Antony Hopkins</h6>
                            <p class="fs--2 mb-0 d-flex">Brain Trust</p>
                          </div>
                        </div>
                      </a>
                      <a class="dropdown-item px-card py-2" href="../pages/user/profile.html">
                        <div class="d-flex align-items-center">
                          <div class="avatar avatar-l me-2">
                            <img class="rounded-circle" src="../assets/img/team/3.jpg" alt="" />

                          </div>
                          <div class="flex-1">
                            <h6 class="mb-0 title">Emma Watson</h6>
                            <p class="fs--2 mb-0 d-flex">Google</p>
                          </div>
                        </div>
                      </a>

                    </div>
                    <div class="text-center mt-n3">
                      <p class="fallback fw-bold fs-1 d-none">No Result Found.</p>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
            <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
              <li class="nav-item">
                <div class="theme-control-toggle fa-icon-wait px-2">
                  <input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle" type="checkbox" data-theme-control="theme" value="dark" />
                  <label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to light theme"><span class="fas fa-sun fs-0"></span></label>
                  <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to dark theme"><span class="fas fa-moon fs-0"></span></label>
                </div>
              </li>
              <li class="nav-item d-none d-sm-block">
                <a class="nav-link px-0 notification-indicator notification-indicator-warning notification-indicator-fill fa-icon-wait" href="../app/e-commerce/shopping-cart.html"><span class="fas fa-shopping-cart" data-fa-transform="shrink-7" style="font-size: 33px;"></span><span class="notification-indicator-number">1</span></a>

              </li>
              <li class="nav-item dropdown">
                <a class="nav-link notification-indicator notification-indicator-primary px-0 fa-icon-wait" id="navbarDropdownNotification" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-hide-on-body-scroll="data-hide-on-body-scroll"><span class="fas fa-bell" data-fa-transform="shrink-6" style="font-size: 33px;"></span></a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card dropdown-menu-notification" aria-labelledby="navbarDropdownNotification">
                  <div class="card card-notification shadow-none">
                    <div class="card-header">
                      <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                          <h6 class="card-header-title mb-0">Notifications</h6>
                        </div>
                        <div class="col-auto ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all as read</a></div>
                      </div>
                    </div>
                    <div class="scrollbar-overlay" style="max-height:19rem">
                      <div class="list-group list-group-flush fw-normal fs--1">
                        <div class="list-group-title border-bottom">NEW</div>
                        <div class="list-group-item">
                          <a class="notification notification-flush notification-unread" href="#!">
                            <div class="notification-avatar">
                              <div class="avatar avatar-2xl me-3">
                                <img class="rounded-circle" src="../assets/img/team/1-thumb.png" alt="" />

                              </div>
                            </div>
                            <div class="notification-body">
                              <p class="mb-1"><strong>Emma Watson</strong> replied to your comment : "Hello world 😍"</p>
                              <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji">💬</span>Just now</span>

                            </div>
                          </a>

                        </div>
                        <div class="list-group-item">
                          <a class="notification notification-flush notification-unread" href="#!">
                            <div class="notification-avatar">
                              <div class="avatar avatar-2xl me-3">
                                <div class="avatar-name rounded-circle"><span>AB</span></div>
                              </div>
                            </div>
                            <div class="notification-body">
                              <p class="mb-1"><strong>Albert Brooks</strong> reacted to <strong>Mia Khalifa's</strong> status</p>
                              <span class="notification-time"><span class="me-2 fab fa-gratipay text-danger"></span>9hr</span>

                            </div>
                          </a>

                        </div>
                        <div class="list-group-title border-bottom">EARLIER</div>
                        <div class="list-group-item">
                          <a class="notification notification-flush" href="#!">
                            <div class="notification-avatar">
                              <div class="avatar avatar-2xl me-3">
                                <img class="rounded-circle" src="../assets/img/icons/weather-sm.jpg" alt="" />

                              </div>
                            </div>
                            <div class="notification-body">
                              <p class="mb-1">The forecast today shows a low of 20&#8451; in California. See today's weather.</p>
                              <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji">🌤️</span>1d</span>

                            </div>
                          </a>

                        </div>
                        <div class="list-group-item">
                          <a class="border-bottom-0 notification-unread  notification notification-flush" href="#!">
                            <div class="notification-avatar">
                              <div class="avatar avatar-xl me-3">
                                <img class="rounded-circle" src="../assets/img/logos/oxford.png" alt="" />

                              </div>
                            </div>
                            <div class="notification-body">
                              <p class="mb-1"><strong>University of Oxford</strong> created an event : "Causal Inference Hilary 2019"</p>
                              <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji">✌️</span>1w</span>

                            </div>
                          </a>

                        </div>
                        <div class="list-group-item">
                          <a class="border-bottom-0 notification notification-flush" href="#!">
                            <div class="notification-avatar">
                              <div class="avatar avatar-xl me-3">
                                <img class="rounded-circle" src="../assets/img/team/10.jpg" alt="" />

                              </div>
                            </div>
                            <div class="notification-body">
                              <p class="mb-1"><strong>James Cameron</strong> invited to join the group: United Nations International Children's Fund</p>
                              <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji">🙋‍</span>2d</span>

                            </div>
                          </a>

                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-center border-top"><a class="card-link d-block" href="../app/social/notifications.html">View all</a></div>
                  </div>
                </div>

              </li>
              <li class="nav-item dropdown">
                <a class="nav-link fa-icon-wait" id="navbarDropdownMenu" role="button" data-hide-on-body-scroll="data-hide-on-body-scroll" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="nine-dots"></span></a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card" aria-labelledby="navbarDropdownMenu">
                  <div class="card shadow-none">
                    <div class="scrollbar-overlay navbar-dropdown-dots">
                      <div class="card-body px-3">
                        <div class="row text-center gx-0 gy-0">
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="../pages/user/profile.html" target="_blank">
                              <div class="avatar avatar-2xl"> <img class="rounded-circle" src="../assets/img/team/3.jpg" alt="" /></div>
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2">Account</p>
                            </a></div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="https://themewagon.com/" target="_blank"><img class="rounded" src="../assets/img/nav-icons/themewagon.png" alt="" width="40" height="40" />
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Themewagon</p>
                            </a></div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="https://mailbluster.com/" target="_blank"><img class="rounded" src="../assets/img/nav-icons/mailbluster.png" alt="" width="40" height="40" />
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Mailbluster</p>
                            </a></div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="../assets/img/nav-icons/google.png" alt="" width="40" height="40" />
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Google</p>
                            </a></div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="../assets/img/nav-icons/spotify.png" alt="" width="40" height="40" />
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Spotify</p>
                            </a></div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="../assets/img/nav-icons/steam.png" alt="" width="40" height="40" />
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Steam</p>
                            </a></div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="../assets/img/nav-icons/github-light.png" alt="" width="40" height="40" />
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Github</p>
                            </a></div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="../assets/img/nav-icons/discord.png" alt="" width="40" height="40" />
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Discord</p>
                            </a></div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="../assets/img/nav-icons/xbox.png" alt="" width="40" height="40" />
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">xbox</p>
                            </a></div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="../assets/img/nav-icons/trello.png" alt="" width="40" height="40" />
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Kanban</p>
                            </a></div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="../assets/img/nav-icons/hp.png" alt="" width="40" height="40" />
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Hp</p>
                            </a></div>
                          <div class="col-12">
                            <hr class="my-3 mx-n3 bg-200" />
                          </div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="../assets/img/nav-icons/linkedin.png" alt="" width="40" height="40" />
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Linkedin</p>
                            </a></div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="../assets/img/nav-icons/twitter.png" alt="" width="40" height="40" />
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Twitter</p>
                            </a></div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="../assets/img/nav-icons/facebook.png" alt="" width="40" height="40" />
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Facebook</p>
                            </a></div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="../assets/img/nav-icons/instagram.png" alt="" width="40" height="40" />
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Instagram</p>
                            </a></div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="../assets/img/nav-icons/pinterest.png" alt="" width="40" height="40" />
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Pinterest</p>
                            </a></div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="../assets/img/nav-icons/slack.png" alt="" width="40" height="40" />
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Slack</p>
                            </a></div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="#!" target="_blank"><img class="rounded" src="../assets/img/nav-icons/deviantart.png" alt="" width="40" height="40" />
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2 pt-1">Deviantart</p>
                            </a></div>
                          <div class="col-4"><a class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none" href="../app/events/event-detail.html" target="_blank">
                              <div class="avatar avatar-2xl">
                                <div class="avatar-name rounded-circle bg-soft-primary text-primary"><span class="fs-2">E</span></div>
                              </div>
                              <p class="mb-0 fw-medium text-800 text-truncate fs--2">Events</p>
                            </a></div>
                          <div class="col-12"><a class="btn btn-outline-primary btn-sm mt-4" href="#!">Show more</a></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </li>
              <li class="nav-item dropdown"><a class="nav-link pe-0" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="avatar avatar-xl">
                    <img class="rounded-circle" src="../assets/img/team/3-thumb.png" alt="" />

                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                  <div class="bg-white dark__bg-1000 rounded-2 py-2">
                    <a class="dropdown-item fw-bold text-warning" href="#!"><span class="fas fa-crown me-1"></span><span>Go Pro</span></a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#!">Set status</a>
                    <a class="dropdown-item" href="../pages/user/profile.html">Profile &amp; account</a>
                    <a class="dropdown-item" href="#!">Feedback</a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../pages/user/settings.html">Settings</a>
                    <a class="dropdown-item" href="../pages/authentication/card/logout.html">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </nav>
          <div class="row g-3 mb-3">
            <div class="col-xxl-8">
              <div class="card overflow-hidden mb-3">
                <div class="card-header audience-chart-header p-0 bg-light scrollbar-overlay">
                  <ul class="nav nav-tabs border-0 chart-tab flex-nowrap" id="audience-chart-tab" role="tablist">
                    <li class="nav-item" role="presentation"><a class="nav-link mb-0 active" id="users-tab" data-bs-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="true">
                        <div class="audience-tab-item p-2 pe-4">
                          <h6 class="text-800 fs--2 text-nowrap">Users</h6>
                          <h5 class="text-800">3.9K</h5>
                          <div class="d-flex align-items-center"><span class="fas fa-caret-up text-success"></span>
                            <h6 class="fs--2 mb-0 ms-2 text-success">62.0%</h6>
                          </div>
                        </div>
                      </a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link mb-0" id="sessions-tab" data-bs-toggle="tab" href="#sessions" role="tab" aria-controls="sessions" aria-selected="false">
                        <div class="audience-tab-item p-2 pe-4">
                          <h6 class="text-800 fs--2 text-nowrap">Sessions</h6>
                          <h5 class="text-800">6.3K</h5>
                          <div class="d-flex align-items-center"><span class="fas fa-caret-up text-success"></span>
                            <h6 class="fs--2 mb-0 ms-2 text-success">46.2%</h6>
                          </div>
                        </div>
                      </a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link mb-0" id="rate-tab" data-bs-toggle="tab" href="#rate" role="tab" aria-controls="rate" aria-selected="false">
                        <div class="audience-tab-item p-2 pe-4">
                          <h6 class="text-800 fs--2 text-nowrap">Bounce Rate</h6>
                          <h5 class="text-800">9.49%</h5>
                          <div class="d-flex align-items-center"><span class="fas fa-caret-down text-warning"></span>
                            <h6 class="fs--2 mb-0 ms-2 text-warning">56.1%</h6>
                          </div>
                        </div>
                      </a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link mb-0" id="duration-tab" data-bs-toggle="tab" href="#duration" role="tab" aria-controls="duration" aria-selected="false">
                        <div class="audience-tab-item p-2 pe-4">
                          <h6 class="text-800 fs--2 text-nowrap">Session Duration</h6>
                          <h5 class="text-800">4m 03s</h5>
                          <div class="d-flex align-items-center"><span class="fas fa-caret-down text-warning"></span>
                            <h6 class="fs--2 mb-0 ms-2 text-warning">32.2%</h6>
                          </div>
                        </div>
                      </a></li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="users" role="tabpanel" aria-labelledby="users-tab">
                      <!-- Find the JS file for the following chart at: src/js/charts/echarts/audience.js-->
                      <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                      <div class="echart-audience" data-echart-responsive="true" style="height:320px;"></div>
                    </div>
                    <div class="tab-pane" id="sessions" role="tabpanel" aria-labelledby="sessions-tab">
                      <div class="echart-audience" data-echart-responsive="true" style="height:320px;"></div>
                    </div>
                    <div class="tab-pane" id="rate" role="tabpanel" aria-labelledby="rate-tab">
                      <div class="echart-audience" data-echart-responsive="true" style="height:320px;"></div>
                    </div>
                    <div class="tab-pane" id="duration" role="tabpanel" aria-labelledby="duration-tab">
                      <div class="echart-audience" data-echart-responsive="true" style="height:320px;"></div>
                    </div>
                  </div>
                </div>
                <div class="card-footer bg-light py-2">
                  <div class="row flex-between-center g-0">
                    <div class="col-auto">
                      <select class="form-select form-select-sm audience-select-menu">
                        <option value="week" selected="selected">Last 7 days</option>
                        <option value="month">Last month</option>
                      </select>
                    </div>
                    <div class="col-auto"><a class="btn btn-link btn-sm px-0 fw-medium" href="#!">Visitors overview<span class="fas fa-chevron-right ms-1 fs--2"></span></a></div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-5.png);">
                </div>
                <!--/.bg-holder-->

                <div class="card-body position-relative">
                  <div class="row g-2 align-items-sm-center">
                    <div class="col-auto"><img src="../assets/img/icons/connect-circle.png" alt="" height="55" /></div>
                    <div class="col">
                      <div class="row align-items-center">
                        <div class="col col-lg-8">
                          <h5 class="fs-0 mb-3 mb-sm-0 text-primary">Connect your domain to your website and get things done faster with Falcon</h5>
                        </div>
                        <div class="col-12 col-sm-auto ms-auto">
                          <button class="btn btn-falcon-primary" type="button">Connect</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xxl-4">
              <div class="card h-100 bg-line-chart-gradient">
                <div class="card-header bg-transparent light">
                  <h5 class="text-white">Users online right now</h5>
                  <div class="real-time-user display-1 fw-normal text-white" data-countup='{"endValue":119}'>0</div>
                </div>
                <div class="card-body text-white fs--1 light pb-0">
                  <p class="border-bottom pb-2" style="border-color: rgba(255, 255, 255, 0.15) !important">Page views / second</p>
                  <!-- Find the JS file for the following chart at: src/js/charts/echarts/real-time-users.js-->
                  <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                  <div class="echart-real-time-users" style="height:150px" data-echart-responsive="true"></div>
                  <div class="list-group-flush mt-4">
                    <div class="rounded-2" style="border:1px solid rgba(255, 255, 255, 0.15)">
                      <div class="px-3 bg-transparent text-white d-flex justify-content-between px-0 py-1 fw-semi-bold border-top-0" style="border-bottom:1px solid rgba(255, 255, 255, 0.15)">
                        <p class="mb-0">Most Active Pages</p>
                        <p class="mb-0">User Count</p>
                      </div>
                      <div class="px-3 bg-transparent text-white d-flex justify-content-between px-0 py-1" style="border-bottom:1px solid rgba(255, 255, 255, 0.05)">
                        <p class="mb-0">/bootstrap-themes/</p>
                        <p class="mb-0">3</p>
                      </div>
                      <div class="px-3 bg-transparent text-white d-flex justify-content-between px-0 py-1" style="border-bottom:1px solid rgba(255, 255, 255, 0.05)">
                        <p class="mb-0">/tags/html5/</p>
                        <p class="mb-0">3</p>
                      </div>
                      <div class="px-3 bg-transparent text-white d-xxl-flex justify-content-between px-0 py-1 d-none" style="border-bottom:1px solid rgba(255, 255, 255, 0.05)">
                        <p class="mb-0">/</p>
                        <p class="mb-0">2</p>
                      </div>
                      <div class="px-3 bg-transparent text-white d-xxl-flex justify-content-between px-0 py-1 d-none" style="border-bottom:1px solid rgba(255, 255, 255, 0.05)">
                        <p class="mb-0">/preview/falcon/dashboard/</p>
                        <p class="mb-0">2</p>
                      </div>
                      <div class="px-3 bg-transparent text-white d-flex justify-content-between px-0 py-1" style="border-bottom:1px solid rgba(255, 255, 255, 0.05)">
                        <p class="mb-0">/100-best-themes...all-time/</p>
                        <p class="mb-0">1</p>
                      </div>
                      <div class="px-3 bg-transparent text-white d-flex justify-content-between px-0 py-1" style="border-bottom:1px solid rgba(255, 255, 255, 0.05)">
                        <p class="mb-0">/product/falcon-admin-dashboard/</p>
                        <p class="mb-0">1</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-end bg-transparent light"><a class="text-white" href="#!">Real-time data<span class="fa fa-chevron-right ms-1 fs--1"></span></a></div>
              </div>
            </div>
            <div class="col-md-6 col-xxl-4">
              <div class="card echart-session-by-browser-card h-100">
                <div class="card-header d-flex flex-between-center bg-light py-2">
                  <h6 class="mb-0">Session By Browser</h6>
                  <div class="dropdown font-sans-serif btn-reveal-trigger">
                    <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-session-by-browser" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
                    <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-session-by-browser"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                      <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                    </div>
                  </div>
                </div>
                <div class="card-body d-flex flex-column justify-content-between py-0">
                  <div class="my-auto py-5 py-md-0">
                    <!-- Find the JS file for the following chart at: src/js/charts/echarts/session-by-browser.js-->
                    <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                    <div class="echart-session-by-browser h-100" data-echart-responsive="true"></div>
                  </div>
                  <div class="border-top">
                    <table class="table table-sm mb-0">
                      <tbody>
                        <tr>
                          <td class="py-3">
                            <div class="d-flex align-items-center"><img src="../assets/img/icons/chrome-logo.png" alt="" width="16" />
                              <h6 class="text-600 mb-0 ms-2">Chrome</h6>
                            </div>
                          </td>
                          <td class="py-3">
                            <div class="d-flex align-items-center"><span class="fas fa-circle fs--2 me-2 text-primary"></span>
                              <h6 class="fw-normal text-700 mb-0">50.3%</h6>
                            </div>
                          </td>
                          <td class="py-3">
                            <div class="d-flex align-items-center justify-content-end"><span class="fas fa-caret-down text-danger"></span>
                              <h6 class="fs--2 mb-0 ms-2 text-700">2.9%</h6>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="py-3">
                            <div class="d-flex align-items-center"><img src="../assets/img/icons/safari-logo.png" alt="" width="16" />
                              <h6 class="text-600 mb-0 ms-2">Safari</h6>
                            </div>
                          </td>
                          <td class="py-3">
                            <div class="d-flex align-items-center"><span class="fas fa-circle fs--2 me-2 text-success"></span>
                              <h6 class="fw-normal text-700 mb-0">30.1%</h6>
                            </div>
                          </td>
                          <td class="py-3">
                            <div class="d-flex align-items-center justify-content-end"><span class="fas fa-caret-up text-success"></span>
                              <h6 class="fs--2 mb-0 ms-2 text-700">29.4%</h6>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="py-3">
                            <div class="d-flex align-items-center"><img src="../assets/img/icons/firefox-logo.png" alt="" width="16" />
                              <h6 class="text-600 mb-0 ms-2">Mozilla</h6>
                            </div>
                          </td>
                          <td class="py-3">
                            <div class="d-flex align-items-center"><span class="fas fa-circle fs--2 me-2 text-info"></span>
                              <h6 class="fw-normal text-700 mb-0">20.6%</h6>
                            </div>
                          </td>
                          <td class="py-3">
                            <div class="d-flex align-items-center justify-content-end"><span class="fas fa-caret-up text-success"></span>
                              <h6 class="fs--2 mb-0 ms-2 text-700">220.7%</h6>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer bg-light py-2">
                  <div class="row flex-between-center g-0">
                    <div class="col-auto">
                      <select class="form-select form-select-sm" data-target=".echart-session-by-browser">
                        <option value="week" selected="selected">Last 7 days</option>
                        <option value="month">Last month</option>
                        <option value="year">Last Year</option>
                      </select>
                    </div>
                    <div class="col-auto"><a class="btn btn-link btn-sm px-0 fw-medium" href="#!">Browser overview<span class="fas fa-chevron-right ms-1 fs--2"></span></a></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xxl-4">
              <div class="card">
                <div class="card-header d-flex align-items-center bg-light py-2">
                  <h6 class="mb-0 flex-1">Users By Country</h6>
                  <div class="btn-reveal-trigger">
                    <button class="btn btn-link btn-reveal btn-sm session-by-country-map-reset" type="button"><span class="fas fa-sync-alt fs--1"></span></button>
                  </div>
                  <div class="dropdown font-sans-serif btn-reveal-trigger">
                    <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-session-by-country" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
                    <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-session-by-country"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                      <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <!-- Find the JS file for the following chart at: src/js/charts/echarts/session-by-country-map.js-->
                  <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                  <div class="echart-session-by-country-map w-100 h-100" data-echart-responsive="true"></div>
                  <!-- Find the JS file for the following chart at: src/js/charts/echarts/session-by-country.js-->
                  <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                  <div class="echart-session-by-country h-100" data-echart-responsive="true"></div>
                </div>
                <div class="card-footer bg-light py-2">
                  <div class="row flex-between-center g-0">
                    <div class="col-auto">
                      <select class="form-select form-select-sm audience-select-menu">
                        <option value="week" selected="selected">Last 7 days</option>
                        <option value="month">Last month</option>
                        <option value="year">Last Year</option>
                      </select>
                    </div>
                    <div class="col-auto"><a class="btn btn-link btn-sm px-0 fw-medium" href="#!">Country overview<span class="fas fa-chevron-right ms-1 fs--2"></span></a></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xxl-4">
              <div class="card h-100">
                <div class="card-header">
                  <div class="d-flex align-items-center"><img class="me-2" src="../assets/img/icons/signal.png" alt="" height="35" />
                    <h5 class="fs-0 fw-normal text-800 mb-0">Ask Falcon Intelligence</h5>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="scrollbar-overlay pt-0 px-card ask-analytics">
                    <div class="border border-1 border-300 rounded-2 p-3 ask-analytics-item position-relative mb-3">
                      <div class="d-flex align-items-center mb-3"><span class="fas fa-code-branch text-primary"></span><a class="stretched-link text-decoration-none" href="#!">
                          <h5 class="fs--1 text-600 mb-0 ps-3">Content Analysis</h5>
                        </a></div>
                      <h5 class="fs--1 text-800">Which landing pages with over 10 sessions have the worst bounce rates?</h5>
                    </div>
                    <div class="border border-1 border-300 rounded-2 p-3 ask-analytics-item position-relative mb-3">
                      <div class="d-flex align-items-center mb-3"><span class="fas fa-bug text-primary"></span><a class="stretched-link text-decoration-none" href="#!">
                          <h5 class="fs--1 text-600 mb-0 ps-3">Technical performance</h5>
                        </a></div>
                      <h5 class="fs--1 text-800">Show me a trend of my average page load time over the last 3 months</h5>
                    </div>
                    <div class="border border-1 border-300 rounded-2 p-3 ask-analytics-item position-relative mb-3">
                      <div class="d-flex align-items-center mb-3"><span class="fas fa-project-diagram text-primary"></span><a class="stretched-link text-decoration-none" href="#!">
                          <h5 class="fs--1 text-600 mb-0 ps-3">Technical performance</h5>
                        </a></div>
                      <h5 class="fs--1 text-800">What are my top default channel groupings by user?</h5>
                    </div>
                    <div class="border border-1 border-300 rounded-2 p-3 ask-analytics-item position-relative mb-3">
                      <div class="d-flex align-items-center mb-3"><span class="fas fa-map-marker-alt text-primary"></span><a class="stretched-link text-decoration-none" href="#!">
                          <h5 class="fs--1 text-600 mb-0 ps-3">Geographic Analysis</h5>
                        </a></div>
                      <h5 class="fs--1 text-800">What pages do people from California go to the most?</h5>
                    </div>
                  </div>
                </div>
                <div class="card-footer bg-light text-end me-1 py-2"><a class="btn btn-link btn-sm px-0 fw-medium" href="#!">More Insights<span class="fas fa-chevron-right ms-1 fs--2"></span></a></div>
              </div>
            </div>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-lg-7">
              <div class="card mb-3">
                <div class="card-header d-flex flex-between-center bg-light py-2">
                  <h6 class="mb-0">Active Users</h6>
                  <div class="dropdown font-sans-serif btn-reveal-trigger">
                    <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-active-user-report" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
                    <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-active-user-report"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                      <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-auto mt-md-0">
                      <div class="row flex-md-column justify-content-between h-md-100 ms-0">
                        <div class="col border-end border-md-end-0 border-md-bottom pt-3">
                          <h6 class="fs--2 text-700"><span class="fas fa-circle text-primary me-2"></span>Mobile</h6>
                          <h5 class="text-700 fs-0">10,325</h5>
                        </div>
                        <div class="col border-end border-md-end-0 border-md-bottom pt-3 pt-md-4">
                          <h6 class="fs--2 text-700"><span class="fas fa-circle text-success me-2"></span>Desktop</h6>
                          <h5 class="text-700 fs-0">4,235</h5>
                        </div>
                        <div class="col pt-3 pt-md-4">
                          <h6 class="fs--2 text-700"><span class="fas fa-circle text-info me-2"></span>Tablet</h6>
                          <h5 class="text-700 fs-0">3,575</h5>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-auto echart-active-users-report-container">
                      <!-- Find the JS file for the following chart at: src/js/charts/echarts/active-users-report.js-->
                      <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                      <div class="echart-active-users-report h-100" data-echart-responsive="true"></div>
                    </div>
                  </div>
                </div>
                <div class="card-footer bg-light py-2">
                  <div class="row flex-between-center g-0">
                    <div class="col-auto">
                      <select class="form-select form-select-sm audience-select-menu">
                        <option value="week" selected="selected">Last 7 days</option>
                        <option value="month">Last month</option>
                        <option value="year">Last Year</option>
                      </select>
                    </div>
                    <div class="col-auto">
                      <h6 class="mb-0"><a class="py-2" href="#!">Active users report<span class="fas fa-chevron-right ms-1 fs--2"></span></a></h6>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body py-5 py-sm-3">
                  <div class="row g-5 g-sm-0">
                    <div class="col-sm-4">
                      <div class="border-sm-end border-300">
                        <div class="text-center">
                          <h6 class="text-700">Completed Goals</h6>
                          <h3 class="fw-normal text-700">1727</h3>
                        </div>
                        <div class="echart-goal-charts" data-echart-responsive="true" data-echarts='{"tooltip":{"show":false},"series":[{"type":"bar","data":[172,129,123,158,196,106,187,198,152,175,178,165,188,139,115,131,143,140,112,167,180,156,121,190,100],"symbol":"none","itemStyle":{"barBorderRadius":[5,5,0,0]}}],"grid":{"right":"16px","left":"0","bottom":"0","top":"0"}}'></div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="border-sm-end border-300">
                        <div class="text-center">
                          <h6 class="text-700">Value</h6>
                          <h3 class="fw-normal text-700">$34.2M</h3>
                        </div>
                        <div class="echart-goal-charts" data-echart-responsive="true" data-echarts='{"tooltip":{"show":false},"series":[{"type":"bar","data":[170,156,171,193,108,178,163,175,117,123,174,199,122,111,113,140,192,167,186,172,131,187,135,115,118],"symbol":"none","itemStyle":{"barBorderRadius":[5,5,0,0]}}],"grid":{"right":"16px","left":"16px","bottom":"0","top":"0"}}'></div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div>
                        <div class="text-center">
                          <h6 class="text-700">Conversion Rate</h6>
                          <h3 class="fw-normal text-700">19.67%</h3>
                        </div>
                        <div class="echart-goal-charts" data-echart-responsive="true" data-echarts='{"tooltip":{"show":false},"series":[{"type":"bar","data":[199,181,155,164,108,158,117,148,121,152,189,116,111,130,113,171,193,104,110,153,190,162,180,114,183],"symbol":"none","itemStyle":{"barBorderRadius":[5,5,0,0]}}],"grid":{"right":"0","left":"16px","bottom":"0","top":"0"}}'></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="card h-100">
                <div class="card-header d-flex flex-between-center bg-light py-2">
                  <h6 class="mb-0">Ad campaigns perfomance</h6>
                  <div class="dropdown font-sans-serif btn-reveal-trigger">
                    <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-campaign-perfomance" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
                    <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-campaign-perfomance"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                      <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                    </div>
                  </div>
                </div>
                <div class="card-body pb-0">
                  <div class="row">
                    <div class="col-6">
                      <div>
                        <h6 class="text-700">Revenue</h6>
                        <h3 class="fw-normal text-700">$10.87k</h3>
                      </div>
                      <div class="w-100" style="min-height:50px;" data-echart-responsive="true" data-echarts='{"series":[{"type":"line","data":[101,165,140,162,121,190,139],"symbol":"none","color":"#f5803e","areaStyle":{"color":{"type":"linear","x":0,"y":0,"x2":0,"y2":1,"colorStops":[{"offset":0,"color":"rgba(245, 128, 62, .25)"},{"offset":1,"color":"rgba(245, 128, 62, 0)"}]}}}],"xAxis":{"boundaryGap":false},"grid":{"right":"20px","left":"0","bottom":"0","top":"20px"}}'></div>
                    </div>
                    <div class="col-6">
                      <div>
                        <h6 class="text-700">Clicks</h6>
                        <h3 class="fw-normal text-700">3.8k</h3>
                      </div>
                      <div class="w-100" style="min-height:50px;" data-echart-responsive="true" data-echarts='{"series":[{"type":"line","data":[119,199,195,101,155,131,180],"symbol":"none"}],"xAxis":{"boundaryGap":false},"grid":{"right":"20px","left":"0","bottom":"0","top":"20px"}}'></div>
                    </div>
                  </div>
                  <div class="mx-ncard">
                    <div class="table-responsive scrollbar">
                      <table class="table fs--1 mb-0 overflow-hidden">
                        <thead class="bg-100 text-800">
                          <tr>
                            <th class="text-nowrap">Top Campaigns</th>
                            <th class="text-nowrap text-end">Cost</th>
                            <th class="text-nowrap text-end">Revenue from Ads</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="text-truncate">Black Friday Sale</td>
                            <td class="text-truncate text-end">$1304.28</td>
                            <td class="text-truncate text-end">$543217.65</td>
                          </tr>
                          <tr>
                            <td class="text-truncate">Christmas Bundle</td>
                            <td class="text-truncate text-end">$9876.56</td>
                            <td class="text-truncate text-end">$3904</td>
                          </tr>
                          <tr>
                            <td class="text-truncate">Halloween Party Started 🎃 👻</td>
                            <td class="text-truncate text-end">$3267.84</td>
                            <td class="text-truncate text-end">$7654.8</td>
                          </tr>
                          <tr>
                            <td class="text-truncate">Grab your reward</td>
                            <td class="text-truncate text-end">$87545.28</td>
                            <td class="text-truncate text-end">$68654.35</td>
                          </tr>
                          <tr>
                            <td class="text-truncate">Black Friday Sale</td>
                            <td class="text-truncate text-end">$1304.28</td>
                            <td class="text-truncate text-end">$3904</td>
                          </tr>
                          <tr>
                            <td class="text-truncate">Boxing Day offer</td>
                            <td class="text-truncate text-end">$1200.5</td>
                            <td class="text-truncate text-end">$5004.87</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="card-footer bg-light py-2">
                  <div class="row flex-between-center">
                    <div class="col-auto">
                      <select class="form-select form-select-sm audience-select-menu">
                        <option value="week" selected="selected">Last 7 days</option>
                        <option value="month">Last month</option>
                        <option value="year">Last Year</option>
                      </select>
                    </div>
                    <div class="col-auto"><a class="btn btn-link btn-sm px-0 fw-medium" href="#!">Ad campaigns<span class="fas fa-chevron-right ms-1 fs--2"></span></a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-lg-5 col-xxl-4">
              <div class="card">
                <div class="card-header bg-light py-3">
                  <h6 class="mb-0">Users at a Time</h6>
                </div>
                <div class="card-body">
                  <!-- Find the JS file for the following chart at: src/js/charts/echarts/users-by-time.js-->
                  <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                  <div class="echart-users-by-time h-100" data-echart-responsive="true"></div>
                </div>
                <div class="card-footer bg-light py-2">
                  <div class="row flex-between-center">
                    <div class="col-auto">
                      <select class="form-select form-select-sm audience-select-menu">
                        <option value="week" selected="selected">Last 7 days</option>
                        <option value="month">Last month</option>
                        <option value="year">Last Year</option>
                      </select>
                    </div>
                    <div class="col-auto"><a class="btn btn-link btn-sm px-0 fw-medium" href="#!">Overview<span class="fas fa-chevron-right ms-1 fs--2"></span></a></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-7 col-xxl-8">
              <div class="card h-100" id="table" data-list='{"valueNames":["path","views","time","exitRate"],"page":8,"pagination":true,"fallback":"pages-table-fallback"}'>
                <div class="card-header">
                  <div class="row flex-between-center">
                    <div class="col-auto col-sm-6 col-lg-7">
                      <h6 class="mb-0 text-nowrap py-2 py-xl-0">What are my top pages today?</h6>
                    </div>
                    <div class="col-auto col-sm-6 col-lg-5">
                      <div class="h-100">
                        <form>
                          <div class="input-group">
                            <input class="form-control form-control-sm shadow-none search" type="search" placeholder="Search for a page" aria-label="search" />
                            <div class="input-group-text bg-transparent"><span class="fa fa-search fs--1 text-600"></span></div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body px-0 py-0">
                  <div class="table-responsive scrollbar">
                    <table class="table fs--1 mb-0 overflow-hidden">
                      <thead class="bg-200 text-900">
                        <tr>
                          <th class="sort pe-1 align-middle white-space-nowrap" data-sort="path">Page Path</th>
                          <th class="sort pe-1 align-middle white-space-nowrap text-end" data-sort="views">Page Views</th>
                          <th class="sort pe-1 align-middle white-space-nowrap text-end" data-sort="time">Avg Time on Page</th>
                          <th class="sort pe-card align-middle white-space-nowrap text-end" data-sort="exitRate">Exit Rate</th>
                        </tr>
                      </thead>
                      <tbody class="list">
                        <tr class="btn-reveal-trigger">
                          <td class="align-middle white-space-nowrap path"><a class="text-primary fw-semi-bold" href="#!">/sparrow/landing-page</a></td>
                          <td class="align-middle white-space-nowrap views text-end">1455</td>
                          <td class="align-middle white-space-nowrap time text-end">2m:25s</td>
                          <td class="align-middle text-end exitRate text-end pe-card">20.4%</td>
                        </tr>
                        <tr class="btn-reveal-trigger">
                          <td class="align-middle white-space-nowrap path"><a class="text-primary fw-semi-bold" href="#!">/falcon/pages/starter.html</a></td>
                          <td class="align-middle white-space-nowrap views text-end">1422</td>
                          <td class="align-middle white-space-nowrap time text-end">2m:14s</td>
                          <td class="align-middle text-end exitRate text-end pe-card">52.4%</td>
                        </tr>
                        <tr class="btn-reveal-trigger">
                          <td class="align-middle white-space-nowrap path"><a class="text-primary fw-semi-bold" href="#!">/pages/falcon-webapp-theme</a></td>
                          <td class="align-middle white-space-nowrap views text-end">1378</td>
                          <td class="align-middle white-space-nowrap time text-end">2m:23s</td>
                          <td class="align-middle text-end exitRate text-end pe-card">25.1%</td>
                        </tr>
                        <tr class="btn-reveal-trigger">
                          <td class="align-middle white-space-nowrap path"><a class="text-primary fw-semi-bold" href="#!">/product/sparrow-bootstrap-theme</a></td>
                          <td class="align-middle white-space-nowrap views text-end">1144</td>
                          <td class="align-middle white-space-nowrap time text-end">2m:2s</td>
                          <td class="align-middle text-end exitRate text-end pe-card">6.3%</td>
                        </tr>
                        <tr class="btn-reveal-trigger">
                          <td class="align-middle white-space-nowrap path"><a class="text-primary fw-semi-bold" href="#!">/themes/falcon/components</a></td>
                          <td class="align-middle white-space-nowrap views text-end">11047</td>
                          <td class="align-middle white-space-nowrap time text-end">1m:16s</td>
                          <td class="align-middle text-end exitRate text-end pe-card">49.3%</td>
                        </tr>
                        <tr class="btn-reveal-trigger">
                          <td class="align-middle white-space-nowrap path"><a class="text-primary fw-semi-bold" href="#!">/themewagon.com/themes/free-website-template</a></td>
                          <td class="align-middle white-space-nowrap views text-end">1007</td>
                          <td class="align-middle white-space-nowrap time text-end">0m:34s</td>
                          <td class="align-middle text-end exitRate text-end pe-card">35.9%</td>
                        </tr>
                        <tr class="btn-reveal-trigger">
                          <td class="align-middle white-space-nowrap path"><a class="text-primary fw-semi-bold" href="#!">/mailbluster.com/about</a></td>
                          <td class="align-middle white-space-nowrap views text-end">997</td>
                          <td class="align-middle white-space-nowrap time text-end">1m:5s</td>
                          <td class="align-middle text-end exitRate text-end pe-card">87.3%</td>
                        </tr>
                        <tr class="btn-reveal-trigger">
                          <td class="align-middle white-space-nowrap path"><a class="text-primary fw-semi-bold" href="#!">/technext.it/services</a></td>
                          <td class="align-middle white-space-nowrap views text-end">983</td>
                          <td class="align-middle white-space-nowrap time text-end">1m:16s</td>
                          <td class="align-middle text-end exitRate text-end pe-card">74.3%</td>
                        </tr>
                        <tr class="btn-reveal-trigger">
                          <td class="align-middle white-space-nowrap path"><a class="text-primary fw-semi-bold" href="#!">/themewagon.com/themes/free-website-template</a></td>
                          <td class="align-middle white-space-nowrap views text-end">971</td>
                          <td class="align-middle white-space-nowrap time text-end">1m:06s</td>
                          <td class="align-middle text-end exitRate text-end pe-card">49.3%</td>
                        </tr>
                        <tr class="btn-reveal-trigger">
                          <td class="align-middle white-space-nowrap path"><a class="text-primary fw-semi-bold" href="#!">/blog/mailbluster-vs-sendy</a></td>
                          <td class="align-middle white-space-nowrap views text-end">996</td>
                          <td class="align-middle white-space-nowrap time text-end">1m:26s</td>
                          <td class="align-middle text-end exitRate text-end pe-card">4.3%</td>
                        </tr>
                        <tr class="btn-reveal-trigger">
                          <td class="align-middle white-space-nowrap path"><a class="text-primary fw-semi-bold" href="#!">/blog/mailbluster-vs-emailoctopus</a></td>
                          <td class="align-middle white-space-nowrap views text-end">890</td>
                          <td class="align-middle white-space-nowrap time text-end">1m:19s</td>
                          <td class="align-middle text-end exitRate text-end pe-card">49.3%</td>
                        </tr>
                        <tr class="btn-reveal-trigger">
                          <td class="align-middle white-space-nowrap path"><a class="text-primary fw-semi-bold" href="#!">/themewagon.com/themes/bootstrap-template</a></td>
                          <td class="align-middle white-space-nowrap views text-end">11047</td>
                          <td class="align-middle white-space-nowrap time text-end">1m:16s</td>
                          <td class="align-middle text-end exitRate text-end pe-card">21.5%</td>
                        </tr>
                        <tr class="btn-reveal-trigger">
                          <td class="align-middle white-space-nowrap path"><a class="text-primary fw-semi-bold" href="#!">/themewagon.com/themes/free-website-template</a></td>
                          <td class="align-middle white-space-nowrap views text-end">11047</td>
                          <td class="align-middle white-space-nowrap time text-end">0m:54s</td>
                          <td class="align-middle text-end exitRate text-end pe-card">62.5%</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="text-center d-none" id="pages-table-fallback">
                    <p class="fw-bold fs-1 mt-3">No Page found</p>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="row align-items-center">
                    <div class="pagination d-none"></div>
                    <div class="col">
                      <p class="mb-0 fs--1"><span class="d-none d-sm-inline-block me-2" data-list-info="data-list-info"></span></p>
                    </div>
                    <div class="col-auto d-flex">
                      <button class="btn btn-sm btn-primary" type="button" data-list-pagination="prev"><span>Previous</span></button>
                      <button class="btn btn-sm btn-primary px-4 ms-2" type="button" data-list-pagination="next"><span>Next</span></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-lg-5 col-xxl-6">
              <div class="card">
                <div class="card-header">
                  <h5 class="text-900 fs-0 mb-2">Trend of Bounce Rate</h5>
                  <h6 class="mb-0 fs--2 text-500">Nov 1, 2020–Jan 31, 2021</h6>
                </div>
                <div class="card-body">
                  <!-- Find the JS file for the following chart at: src/js/charts/echarts/bounce-rate.js-->
                  <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                  <div class="echart-bounce-rate h-100" data-echart-responsive="true"></div>
                </div>
                <div class="card-footer bg-light py-2">
                  <div class="row flex-between-center g-0">
                    <div class="col-auto">
                      <select class="form-select form-select-sm" data-target=".echart-bounce-rate">
                        <option value="week">Last 7 days</option>
                        <option value="month" selected="selected">Last month</option>
                      </select>
                    </div>
                    <div class="col-auto"><a class="btn btn-link btn-sm px-0 fw-medium" href="#!">View full report<span class="fas fa-chevron-right ms-1 fs--2"></span></a></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-7 col-xxl-6">
              <div class="card">
                <div class="card-header d-flex flex-between-center bg-light py-2">
                  <h6 class="mb-0">Traffic source</h6>
                  <div class="dropdown font-sans-serif btn-reveal-trigger">
                    <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="dropdown-traffic-channel" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
                    <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-traffic-channel"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                      <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <!-- Find the JS file for the following chart at: src/js/charts/echarts/traffic-channels.js-->
                  <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                  <div class="echart-traffic-channels h-100" data-echart-responsive="true"></div>
                </div>
                <div class="card-footer bg-light py-2">
                  <div class="row flex-between-center g-0">
                    <div class="col-auto">
                      <select class="form-select form-select-sm audience-select-menu">
                        <option value="week" selected="selected">Last 7 days</option>
                        <option value="month">Last month</option>
                        <option value="year">Last Year</option>
                      </select>
                    </div>
                    <div class="col-auto"><a class="btn btn-link btn-sm px-0 fw-medium" href="#!">Acquisition overview<span class="fas fa-chevron-right ms-1 fs--2"></span></a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <footer class="footer">
            <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
              <div class="col-12 col-sm-auto text-center">
                <p class="mb-0 text-600">Thank you for creating with Falcon <span class="d-none d-sm-inline-block">| </span><br class="d-sm-none" /> 2021 &copy; <a href="https://themewagon.com">Themewagon</a></p>
              </div>
              <div class="col-12 col-sm-auto text-center">
                <p class="mb-0 text-600">v3.6.0</p>
              </div>
            </div>
          </footer>
        </div>
        <div class="modal fade" id="authentication-modal" tabindex="-1" role="dialog" aria-labelledby="authentication-modal-label" aria-hidden="true">
          <div class="modal-dialog mt-6" role="document">
            <div class="modal-content border-0">
              <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                <div class="position-relative z-index-1 light">
                  <h4 class="mb-0 text-white" id="authentication-modal-label">Register</h4>
                  <p class="fs--1 mb-0 text-white">Please create your free Falcon account</p>
                </div>
                <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body py-4 px-5">
                <form>
                  <div class="mb-3">
                    <label class="form-label" for="modal-auth-name">Name</label>
                    <input class="form-control" type="text" autocomplete="on" id="modal-auth-name" />
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="modal-auth-email">Email address</label>
                    <input class="form-control" type="email" autocomplete="on" id="modal-auth-email" />
                  </div>
                  <div class="row gx-2">
                    <div class="mb-3 col-sm-6">
                      <label class="form-label" for="modal-auth-password">Password</label>
                      <input class="form-control" type="password" autocomplete="on" id="modal-auth-password" />
                    </div>
                    <div class="mb-3 col-sm-6">
                      <label class="form-label" for="modal-auth-confirm-password">Confirm Password</label>
                      <input class="form-control" type="password" autocomplete="on" id="modal-auth-confirm-password" />
                    </div>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="modal-auth-register-checkbox" />
                    <label class="form-label" for="modal-auth-register-checkbox">I accept the <a href="#!">terms </a>and <a href="#!">privacy policy</a></label>
                  </div>
                  <div class="mb-3">
                    <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Register</button>
                  </div>
                </form>
                <div class="position-relative mt-5">
                  <hr class="bg-300" />
                  <div class="divider-content-center">or register with</div>
                </div>
                <div class="row g-2 mt-2">
                  <div class="col-sm-6"><a class="btn btn-outline-google-plus btn-sm d-block w-100" href="#"><span class="fab fa-google-plus-g me-2" data-fa-transform="grow-8"></span> google</a></div>
                  <div class="col-sm-6"><a class="btn btn-outline-facebook btn-sm d-block w-100" href="#"><span class="fab fa-facebook-square me-2" data-fa-transform="grow-8"></span> facebook</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->


    <div class="offcanvas offcanvas-end settings-panel border-0" id="settings-offcanvas" tabindex="-1" aria-labelledby="settings-offcanvas">
      <div class="offcanvas-header settings-panel-header bg-shape">
        <div class="z-index-1 py-1 light">
          <h5 class="text-white"> <span class="fas fa-palette me-2 fs-0"></span>Settings</h5>
          <p class="mb-0 fs--1 text-white opacity-75"> Set your own customized style</p>
        </div>
        <button class="btn-close btn-close-white z-index-1 mt-0" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body scrollbar-overlay px-card" id="themeController">
        <h5 class="fs-0">Color Scheme</h5>
        <p class="fs--1">Choose the perfect color mode for your app.</p>
        <div class="btn-group d-block w-100 btn-group-navbar-style">
          <div class="row gx-2">
            <div class="col-6">
              <input class="btn-check" id="themeSwitcherLight" name="theme-color" type="radio" value="light" data-theme-control="theme" />
              <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherLight"> <span class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0" src="../assets/img/generic/falcon-mode-default.jpg" alt=""/></span><span class="label-text">Light</span></label>
            </div>
            <div class="col-6">
              <input class="btn-check" id="themeSwitcherDark" name="theme-color" type="radio" value="dark" data-theme-control="theme" />
              <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherDark"> <span class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0" src="../assets/img/generic/falcon-mode-dark.jpg" alt=""/></span><span class="label-text"> Dark</span></label>
            </div>
          </div>
        </div>
        <hr />
        <div class="d-flex justify-content-between">
          <div class="d-flex align-items-start"><img class="me-2" src="../assets/img/icons/left-arrow-from-left.svg" width="20" alt="" />
            <div class="flex-1">
              <h5 class="fs-0">RTL Mode</h5>
              <p class="fs--1 mb-0">Switch your language direction </p><a class="fs--1" href="../documentation/customization/configuration.html">RTL Documentation</a>
            </div>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input ms-0" id="mode-rtl" type="checkbox" data-theme-control="isRTL" />
          </div>
        </div>
        <hr />
        <div class="d-flex justify-content-between">
          <div class="d-flex align-items-start"><img class="me-2" src="../assets/img/icons/arrows-h.svg" width="20" alt="" />
            <div class="flex-1">
              <h5 class="fs-0">Fluid Layout</h5>
              <p class="fs--1 mb-0">Toggle container layout system </p><a class="fs--1" href="../documentation/customization/configuration.html">Fluid Documentation</a>
            </div>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input ms-0" id="mode-fluid" type="checkbox" data-theme-control="isFluid" />
          </div>
        </div>
        <hr />
        <div class="d-flex align-items-start"><img class="me-2" src="../assets/img/icons/paragraph.svg" width="20" alt="" />
          <div class="flex-1">
            <h5 class="fs-0 d-flex align-items-center">Navigation Position </h5>
            <p class="fs--1 mb-2">Select a suitable navigation system for your web application </p>
            <div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" id="option-navbar-vertical" type="radio" name="navbar" value="vertical" data-page-url="../modules/components/navs-and-tabs/vertical-navbar.html" data-theme-control="navbarPosition" />
                <label class="form-check-label" for="option-navbar-vertical">Vertical</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" id="option-navbar-top" type="radio" name="navbar" value="top" data-page-url="../modules/components/navs-and-tabs/top-navbar.html" data-theme-control="navbarPosition" />
                <label class="form-check-label" for="option-navbar-top">Top</label>
              </div>
              <div class="form-check form-check-inline me-0">
                <input class="form-check-input" id="option-navbar-combo" type="radio" name="navbar" value="combo" data-page-url="../modules/components/navs-and-tabs/combo-navbar.html" data-theme-control="navbarPosition" />
                <label class="form-check-label" for="option-navbar-combo">Combo</label>
              </div>
            </div>
          </div>
        </div>
        <hr />
        <h5 class="fs-0 d-flex align-items-center">Vertical Navbar Style</h5>
        <p class="fs--1 mb-0">Switch between styles for your vertical navbar </p>
        <p> <a class="fs--1" href="../modules/components/navs-and-tabs/vertical-navbar.html#navbar-styles">See Documentation</a></p>
        <div class="btn-group d-block w-100 btn-group-navbar-style">
          <div class="row gx-2">
            <div class="col-6">
              <input class="btn-check" id="navbar-style-transparent" type="radio" name="navbarStyle" value="transparent" data-theme-control="navbarStyle" />
              <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-transparent"> <img class="img-fluid img-prototype" src="../assets/img/generic/default.png" alt="" /><span class="label-text"> Transparent</span></label>
            </div>
            <div class="col-6">
              <input class="btn-check" id="navbar-style-inverted" type="radio" name="navbarStyle" value="inverted" data-theme-control="navbarStyle" />
              <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-inverted"> <img class="img-fluid img-prototype" src="../assets/img/generic/inverted.png" alt="" /><span class="label-text"> Inverted</span></label>
            </div>
            <div class="col-6">
              <input class="btn-check" id="navbar-style-card" type="radio" name="navbarStyle" value="card" data-theme-control="navbarStyle" />
              <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-card"> <img class="img-fluid img-prototype" src="../assets/img/generic/card.png" alt="" /><span class="label-text"> Card</span></label>
            </div>
            <div class="col-6">
              <input class="btn-check" id="navbar-style-vibrant" type="radio" name="navbarStyle" value="vibrant" data-theme-control="navbarStyle" />
              <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-vibrant"> <img class="img-fluid img-prototype" src="../assets/img/generic/vibrant.png" alt="" /><span class="label-text"> Vibrant</span></label>
            </div>
          </div>
        </div>
        <div class="text-center mt-5"><img class="mb-4" src="../assets/img/icons/spot-illustrations/47.png" alt="" width="120" />
          <h5>Like What You See?</h5>
          <p class="fs--1">Get Falcon now and create beautiful dashboards with hundreds of widgets.</p><a class="mb-3 btn btn-primary" href="https://themes.getbootstrap.com/product/falcon-admin-dashboard-webapp-template/" target="_blank">Purchase</a>
        </div>
      </div>
    </div><a class="card setting-toggle" href="#settings-offcanvas" data-bs-toggle="offcanvas">
      <div class="card-body d-flex align-items-center py-md-2 px-2 py-1">
        <div class="bg-soft-primary position-relative rounded-start" style="height:34px;width:28px">
          <div class="settings-popover"><span class="ripple"><span class="fa-spin position-absolute all-0 d-flex flex-center"><span class="icon-spin position-absolute all-0 d-flex flex-center">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.7369 12.3941L19.1989 12.1065C18.4459 11.7041 18.0843 10.8487 18.0843 9.99495C18.0843 9.14118 18.4459 8.28582 19.1989 7.88336L19.7369 7.59581C19.9474 7.47484 20.0316 7.23291 19.9474 7.03131C19.4842 5.57973 18.6843 4.28943 17.6738 3.20075C17.5053 3.03946 17.2527 2.99914 17.0422 3.12011L16.393 3.46714C15.6883 3.84379 14.8377 3.74529 14.1476 3.3427C14.0988 3.31422 14.0496 3.28621 14.0002 3.25868C13.2568 2.84453 12.7055 2.10629 12.7055 1.25525V0.70081C12.7055 0.499202 12.5371 0.297594 12.2845 0.257272C10.7266 -0.105622 9.16879 -0.0653007 7.69516 0.257272C7.44254 0.297594 7.31623 0.499202 7.31623 0.70081V1.23474C7.31623 2.09575 6.74999 2.8362 5.99824 3.25599C5.95774 3.27861 5.91747 3.30159 5.87744 3.32493C5.15643 3.74527 4.26453 3.85902 3.53534 3.45302L2.93743 3.12011C2.72691 2.99914 2.47429 3.03946 2.30587 3.20075C1.29538 4.28943 0.495411 5.57973 0.0322686 7.03131C-0.051939 7.23291 0.0322686 7.47484 0.242788 7.59581L0.784376 7.8853C1.54166 8.29007 1.92694 9.13627 1.92694 9.99495C1.92694 10.8536 1.54166 11.6998 0.784375 12.1046L0.242788 12.3941C0.0322686 12.515 -0.051939 12.757 0.0322686 12.9586C0.495411 14.4102 1.29538 15.7005 2.30587 16.7891C2.47429 16.9504 2.72691 16.9907 2.93743 16.8698L3.58669 16.5227C4.29133 16.1461 5.14131 16.2457 5.8331 16.6455C5.88713 16.6767 5.94159 16.7074 5.99648 16.7375C6.75162 17.1511 7.31623 17.8941 7.31623 18.7552V19.2891C7.31623 19.4425 7.41373 19.5959 7.55309 19.696C7.64066 19.7589 7.74815 19.7843 7.85406 19.8046C9.35884 20.0925 10.8609 20.0456 12.2845 19.7729C12.5371 19.6923 12.7055 19.4907 12.7055 19.2891V18.7346C12.7055 17.8836 13.2568 17.1454 14.0002 16.7312C14.0496 16.7037 14.0988 16.6757 14.1476 16.6472C14.8377 16.2446 15.6883 16.1461 16.393 16.5227L17.0422 16.8698C17.2527 16.9907 17.5053 16.9504 17.6738 16.7891C18.7264 15.7005 19.4842 14.4102 19.9895 12.9586C20.0316 12.757 19.9474 12.515 19.7369 12.3941ZM10.0109 13.2005C8.1162 13.2005 6.64257 11.7893 6.64257 9.97478C6.64257 8.20063 8.1162 6.74905 10.0109 6.74905C11.8634 6.74905 13.3792 8.20063 13.3792 9.97478C13.3792 11.7893 11.8634 13.2005 10.0109 13.2005Z" fill="#2A7BE4"></path>
                  </svg></span></span></span></div>
        </div><small class="text-uppercase text-primary fw-bold bg-soft-primary py-2 pe-2 ps-1 rounded-end">customize</small>
      </div>
    </a>


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="../vendors/popper/popper.min.js"></script>
    <script src="../vendors/bootstrap/bootstrap.min.js"></script>
    <script src="../vendors/anchorjs/anchor.min.js"></script>
    <script src="../vendors/is/is.min.js"></script>
    <script src="../vendors/echarts/echarts.min.js"></script>
    <script src="../assets/data/world.js"></script>
    <script src="../vendors/chart/chart.min.js"></script>
    <script src="../vendors/dayjs/dayjs.min.js"></script>
    <script src="../vendors/fontawesome/all.min.js"></script>
    <script src="../vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="../vendors/list.js/list.min.js"></script>
    <script src="../assets/js/theme.js"></script>

  </body>

</html>