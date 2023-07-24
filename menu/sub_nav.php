<?php
session_start();
?>
<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand-lg" data-move-target="#navbarVerticalNav" data-navbar-top="combo">

<button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
<a class="navbar-brand me-1 me-sm-3" href="../../">
  <div class="d-flex align-items-center"><img class="me-2" src="../../assets/img/gallery/inbracket_colour.png" alt="" width="110" />
  </div>
</a>
<div class="collapse navbar-collapse scrollbar" id="navbarStandard">
  <ul class="navbar-nav" data-top-nav-dropdowns="data-top-nav-dropdowns">
  <li class="nav-item dropdown"><a style="color:var(--falcon-gray)" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="documentations">Reports</a>
      <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="documentations">
        <div class="bg-white dark__bg-1000 rounded-3 py-2">
          <a style="color:var(--falcon-gray)" class="dropdown-item link-600 fw-medium" href="../../p/invoice_ready">Orders to Invoice

          <?php
                    require(__DIR__ . '/../dbconnect/db.php');

                    $sql = "SELECT count(distinct(pk.SalesOrderNumber)) as 'count' FROM INB_COMPLETED_PICKS pk WHERE pk.PushedStatus = 'Pushed' AND pk.InvoiceState IS NULL";

                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if (mysqli_num_rows($result) > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<span class='badge' style='background-color: var(--falcon-btn-falcon-success-active-background); color: var(--falcon-list-group-item-color-success);'>" . $row['count'] . "</span>";
                      }
                    } else {
                      echo "<span class='badge' style='background-color: var(--falcon-btn-falcon-success-active-background); color: var(--falcon-list-group-item-color-success);'>0</span>";
                    }    ?>
                  </span>
          </a>
          <a style="color:var(--falcon-gray)" class="dropdown-item link-600 fw-medium" href="../../p/invoice_history">Invoice History</a>
          <a style="color:var(--falcon-gray)" class="dropdown-item link-600 fw-medium" href="../../p/pick_review">Pick Review
          <?php
                    require(__DIR__ . '/../dbconnect/db.php');

                    $sql = "SELECT
                    count(distinct(pk.SalesOrderNumber)) as 'count'
                    FROM INB_COMPLETED_PICKS pk
                    WHERE pk.PushedStatus IS NULL";

                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if (mysqli_num_rows($result) > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<span class='badge' style='background-color: var(--falcon-btn-falcon-success-active-background); color: var(--falcon-list-group-item-color-success);'>" . $row['count'] . "</span>";
                      }
                    } else {
                      echo "<span class='badge' style='background-color: var(--falcon-btn-falcon-success-active-background); color: var(--falcon-list-group-item-color-success);'>0</span>";
                    }    ?>
                  </span>
          </a>
          <a style="color:var(--falcon-gray)" class="dropdown-item link-600 fw-medium" href="../../p/pick_history">Pick History</a>
          <a style="color:var(--falcon-gray)" class="dropdown-item link-600 fw-medium" href="../../p/negative_stock">Negative SOH Report
          <?php
                    require(__DIR__ . '/../dbconnect/db.php');

                    $sql = "SELECT
                    count(pf.ProductCode) as 'count'
                    FROM INB_PICKFACE_STOCK pf 
                    WHERE PickfaceStock < 0";

                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if (mysqli_num_rows($result) > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<span class='badge' style='background-color: var(--falcon-btn-falcon-success-active-background); color: var(--falcon-list-group-item-color-success);'>" . $row['count'] . "</span>";
                      }
                    } else {
                      echo "<span class='badge' style='background-color: var(--falcon-btn-falcon-success-active-background); color: var(--falcon-list-group-item-color-success);'>0</span>";
                    }    ?>
                  </span>
        </a>
          <a style="color:var(--falcon-gray)" class="dropdown-item link-600 fw-medium" href="../../p/non_putaway">Non Putaway Report
          <?php
                    require(__DIR__ . '/../dbconnect/db.php');

                    $sql = "SELECT 
                    count(PlateNumber) as 'count'
                    from INB_PURCHASE_RECEIPTS
                    WHERE PutawayStatus = 'InProgress' OR PutawayStatus IS NULL and ReceivedQuantity > 0 and STR_TO_DATE(ReceivedTimeStamp, '%Y-%m-%d') > '2022-12-01'";

                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if (mysqli_num_rows($result) > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<span class='badge' style='background-color: var(--falcon-btn-falcon-success-active-background); color: var(--falcon-list-group-item-color-success);'>" . $row['count'] . "</span>";
                      }
                    } else {
                      echo "<span class='badge' style='background-color: var(--falcon-btn-falcon-success-active-background); color: var(--falcon-list-group-item-color-success);'>0</span>";
                    }    ?>
        </a>
        <a style="color:var(--falcon-gray)" class="dropdown-item link-600 fw-medium" href="../../p/replenishment">Replenishment Trail</a>
        </div>
      </div>
    </li>

    <li class="nav-item dropdown"><a style="color:var(--falcon-gray)" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dashboards">Administration</a>
      <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="dashboards">
        <div class="bg-white dark__bg-1000 rounded-3 py-2">
          <a style="color:var(--falcon-gray)" class="dropdown-item link-600 fw-medium" href="../../s/initiate_stocktake">Create Stocktake</a>
          <a style="color:var(--falcon-gray)" class="dropdown-item link-600 fw-medium" href="../../s/stocktake_progress">Stocktake Progress</a>
          <a style="color:var(--falcon-gray)" class="dropdown-item link-600 fw-medium" href="../../s/stocktake_line_data">Stocktake Line Data</a>
        </div>
      </div>
    </li>
    <!-- <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="apps">App</a>
      <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="apps">
        <div class="card navbar-card-app shadow-none dark__bg-1000">
          <div class="card-body scrollbar max-h-dropdown"><img class="img-dropdown" src="../assets/img/icons/spot-illustrations/authentication-corner.png" width="130" alt="" />
            <div class="row">
              <div class="col-6 col-md-5">
                <div class="nav flex-column"><a class="nav-link py-1 link-600 fw-medium" href="../app/calendar.html">Calendar</a><a class="nav-link py-1 link-600 fw-medium" href="../app/chat.html">Chat</a><a class="nav-link py-1 link-600 fw-medium" href="../app/kanban.html">Kanban</a>
                  <p class="nav-link text-700 mb-0 fw-bold">Email</p><a class="nav-link py-1 link-600 fw-medium" href="../app/email/inbox.html">Inbox</a><a class="nav-link py-1 link-600 fw-medium" href="../app/email/email-detail.html">Email detail</a><a class="nav-link py-1 link-600 fw-medium" href="../app/email/compose.html">Compose</a>
                  <p class="nav-link text-700 mb-0 fw-bold">Events</p><a class="nav-link py-1 link-600 fw-medium" href="../app/events/create-an-event.html">Create an event</a><a class="nav-link py-1 link-600 fw-medium" href="../app/events/event-detail.html">Event detail</a><a class="nav-link py-1 link-600 fw-medium" href="../app/events/event-list.html">Event list</a>
                  <p class="nav-link text-700 mb-0 fw-bold">Social</p><a class="nav-link py-1 link-600 fw-medium" href="../app/social/feed.html">Feed</a><a class="nav-link py-1 link-600 fw-medium" href="../app/social/activity-log.html">Activity log</a><a class="nav-link py-1 link-600 fw-medium" href="../app/social/notifications.html">Notifications</a><a class="nav-link py-1 link-600 fw-medium" href="../app/social/followers.html">Followers</a>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="nav flex-column">
                  <p class="nav-link text-700 mb-0 fw-bold">E-Commerce</p><a class="nav-link py-1 link-600 fw-medium" href="../app/e-commerce/product/product-list.html">Product list</a><a class="nav-link py-1 link-600 fw-medium" href="../app/e-commerce/product/product-grid.html">Product grid</a><a class="nav-link py-1 link-600 fw-medium" href="../app/e-commerce/product/product-details.html">Product details</a><a class="nav-link py-1 link-600 fw-medium" href="../app/e-commerce/orders/order-list.html">Order list</a><a class="nav-link py-1 link-600 fw-medium" href="../app/e-commerce/orders/order-details.html">Order details</a><a class="nav-link py-1 link-600 fw-medium" href="../app/e-commerce/customers.html">Customers</a><a class="nav-link py-1 link-600 fw-medium" href="../app/e-commerce/customer-details.html">Customer details</a><a class="nav-link py-1 link-600 fw-medium" href="../app/e-commerce/shopping-cart.html">Shopping cart</a><a class="nav-link py-1 link-600 fw-medium" href="../app/e-commerce/checkout.html">Checkout</a><a class="nav-link py-1 link-600 fw-medium" href="../app/e-commerce/billing.html">Billing</a><a class="nav-link py-1 link-600 fw-medium" href="../app/e-commerce/invoice.html">Invoice</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </li> -->
    <!-- <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="pagess">Pages</a>
      <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="pagess">
        <div class="card navbar-card-pages shadow-none dark__bg-1000">
          <div class="card-body scrollbar max-h-dropdown"><img class="img-dropdown" src="../assets/img/icons/spot-illustrations/authentication-corner.png" width="130" alt="" />
            <div class="row">
              <div class="col-6 col-xxl-3">
                <div class="nav flex-column">
                  <p class="nav-link text-700 mb-0 fw-bold">Simple Auth</p><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/simple/login.html">Login</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/simple/logout.html">Logout</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/simple/register.html">Register</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/simple/forgot-password.html">Forgot password</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/simple/confirm-mail.html">Confirm mail</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/simple/reset-password.html">Reset password</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/simple/lock-screen.html">Lock screen</a>
                </div>
              </div>
              <div class="col-6 col-xxl-3">
                <div class="nav flex-column">
                  <p class="nav-link text-700 mb-0 fw-bold">Card Auth</p><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/card/login.html">Login</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/card/logout.html">Logout</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/card/register.html">Register</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/card/forgot-password.html">Forgot password</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/card/confirm-mail.html">Confirm mail</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/card/reset-password.html">Reset password</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/card/lock-screen.html">Lock screen</a>
                </div>
              </div>
              <div class="col-6 col-xxl-3">
                <div class="nav flex-column">
                  <p class="nav-link text-700 mb-0 fw-bold">Split Auth</p><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/split/login.html">Login</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/split/logout.html">Logout</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/split/register.html">Register</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/split/forgot-password.html">Forgot password</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/split/confirm-mail.html">Confirm mail</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/split/reset-password.html">Reset password</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/split/lock-screen.html">Lock screen</a>
                </div>
              </div>
              <div class="col-6 col-xxl-3">
                <div class="nav flex-column">
                  <p class="nav-link text-700 mb-0 fw-bold">Other Auth</p><a class="nav-link py-1 link-600 fw-medium" href="../pages/authentication/wizard.html">Wizard</a><a class="nav-link py-1 link-600 fw-medium" href="../#authentication-modal" data-bs-toggle="modal">Modal</a>
                  <p class="nav-link text-700 mb-0 fw-bold">Miscellaneous</p><a class="nav-link py-1 link-600 fw-medium" href="../pages/miscellaneous/associations.html">Associations</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/miscellaneous/invite-people.html">Invite people</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/miscellaneous/privacy-policy.html">Privacy policy</a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6 col-xxl-3">
                <div class="nav flex-column">
                  <p class="nav-link text-700 mb-0 fw-bold">User</p><a class="nav-link py-1 link-600 fw-medium" href="../pages/user/profile.html">Profile</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/user/settings.html">Settings</a>
                </div>
              </div>
              <div class="col-6 col-xxl-3">
                <div class="nav flex-column">
                  <p class="nav-link text-700 mb-0 fw-bold">Pricing</p><a class="nav-link py-1 link-600 fw-medium" href="../pages/pricing/pricing-default.html">Pricing default</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/pricing/pricing-alt.html">Pricing alt</a>
                </div>
              </div>
              <div class="col-6 col-xxl-3">
                <div class="nav flex-column">
                  <p class="nav-link text-700 mb-0 fw-bold">Errors</p><a class="nav-link py-1 link-600 fw-medium" href="../pages/errors/404.html">404</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/errors/500.html">500</a>
                </div>
              </div>
              <div class="col-6 col-xxl-3">
                <div class="nav flex-column">
                  <p class="nav-link text-700 mb-0 fw-bold">Others</p><a class="nav-link py-1 link-600 fw-medium" href="../pages/starter.html">Starter</a><a class="nav-link py-1 link-600 fw-medium" href="../pages/landing.html">Landing</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </li> -->
    <!-- <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="moduless">Modules</a>
      <div class="dropdown-menu dropdown-caret dropdown-menu-card border-0 mt-0" aria-labelledby="moduless">
        <div class="card navbar-card-components shadow-none dark__bg-1000">
          <div class="card-body scrollbar max-h-dropdown"><img class="img-dropdown" src="../assets/img/icons/spot-illustrations/authentication-corner.png" width="130" alt="" />
            <div class="row">
              <div class="col-6 col-xxl-3">
                <div class="nav flex-column">
                  <p class="nav-link text-700 mb-0 fw-bold">Components</p><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/accordion.html">Accordion</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/alerts.html">Alerts</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/anchor.html">Anchor</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/animated-icons.html">Animated icons</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/background.html">Background</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/badges.html">Badges</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/breadcrumbs.html">Breadcrumbs</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/buttons.html">Buttons</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/calendar.html">Calendar</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/cards.html">Cards</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/carousel/bootstrap.html">Bootstrap carousel</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/carousel/swiper.html">Swiper</a>
                </div>
              </div>
              <div class="col-6 col-xxl-3">
                <div class="nav flex-column mt-md-4 pt-md-1"><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/collapse.html">Collapse</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/cookie-notice.html">Cookie notice</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/countup.html">Countup</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/draggable.html">Draggable</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/dropdowns.html">Dropdowns</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/list-group.html">List group</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/modals.html">Modals</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/navs-and-tabs/navs.html">Navs</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/navs-and-tabs/navbar.html">Navbar</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/navs-and-tabs/vertical-navbar.html">Vertical navbar</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/navs-and-tabs/top-navbar.html">Top navbar</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/navs-and-tabs/combo-navbar.html">Combo navbar</a>
                </div>
              </div>
              <div class="col-6 col-xxl-3">
                <div class="nav flex-column mt-xxl-4 pt-xxl-1"><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/navs-and-tabs/tabs.html">Tabs</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/offcanvas.html">Offcanvas</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/pictures/avatar.html">Avatar</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/pictures/images.html">Images</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/pictures/figures.html">Figures</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/pictures/hoverbox.html">Hoverbox</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/pictures/lightbox.html">Lightbox</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/progress-bar.html">Progress bar</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/placeholder.html">Placeholder</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/pagination.html">Pagination</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/popovers.html">Popovers</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/scrollspy.html">Scrollspy</a>
                </div>
              </div>
              <div class="col-6 col-xxl-3">
                <div class="nav flex-column mt-xxl-4 pt-xxl-1"><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/search.html">Search</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/spinners.html">Spinners</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/timeline.html">Timeline<span class="badge rounded-pill ms-2 badge-soft-success">New</span></a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/toasts.html">Toasts</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/tooltips.html">Tooltips</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/treeview.html">Treeview</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/typed-text.html">Typed text</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/videos/embed.html">Embed</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/components/videos/plyr.html">Plyr</a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6 col-xxl-3">
                <div class="nav flex-column">
                  <p class="nav-link text-700 mb-0 fw-bold">Forms</p><a class="nav-link py-1 link-600 fw-medium" href="../modules/forms/basic/form-control.html">Form control</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/forms/basic/input-group.html">Input group</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/forms/basic/select.html">Select</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/forms/basic/checks.html">Checks</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/forms/basic/range.html">Range</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/forms/basic/layout.html">Layout</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/forms/advance/advance-select.html">Advance select</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/forms/advance/date-picker.html">Date picker</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/forms/advance/editor.html">Editor</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/forms/advance/emoji-button.html">Emoji button</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/forms/advance/file-uploader.html">File uploader</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/forms/advance/rating.html">Rating</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/forms/floating-labels.html">Floating labels</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/forms/wizard.html">Wizard</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/forms/validation.html">Validation</a>
                </div>
              </div>
              <div class="col-6 col-xxl-3">
                <div class="nav flex-column">
                  <p class="nav-link text-700 mb-0 fw-bold">Tables</p><a class="nav-link py-1 link-600 fw-medium" href="../modules/tables/basic-tables.html">Basic tables</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/tables/advance-tables.html">Advance tables</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/tables/bulk-select.html">Bulk select</a>
                  <p class="nav-link text-700 mb-0 fw-bold">Charts</p><a class="nav-link py-1 link-600 fw-medium" href="../modules/charts/chartjs.html">Chartjs</a>
                  <p class="nav-link text-700 mb-0 fw-bold">ECharts</p><a class="nav-link py-1 link-600 fw-medium" href="../modules/charts/echarts/line-charts.html">Line charts</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/charts/echarts/bar-charts.html">Bar charts</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/charts/echarts/candlestick-charts.html">Candlestick charts</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/charts/echarts/geo-map.html">Geo map</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/charts/echarts/scatter-charts.html">Scatter charts</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/charts/echarts/pie-charts.html">Pie charts</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/charts/echarts/radar-charts.html">Radar charts</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/charts/echarts/heatmap-charts.html">Heatmap charts</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/charts/echarts/how-to-use.html">How to use</a>
                </div>
              </div>
              <div class="col-6 col-xxl-3">
                <div class="nav flex-column">
                  <p class="nav-link text-700 mb-0 fw-bold">Utilities</p><a class="nav-link py-1 link-600 fw-medium" href="../modules/utilities/borders.html">Borders</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/utilities/clearfix.html">Clearfix</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/utilities/colors.html">Colors</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/utilities/colored-links.html">Colored links</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/utilities/display.html">Display</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/utilities/flex.html">Flex</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/utilities/float.html">Float</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/utilities/grid.html">Grid</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/utilities/overlayscrollbars.html">Overlayscrollbars</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/utilities/position.html">Position</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/utilities/spacing.html">Spacing</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/utilities/sizing.html">Sizing</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/utilities/stretched-link.html">Stretched link</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/utilities/text-truncation.html">Text truncation</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/utilities/typography.html">Typography</a>
                </div>
              </div>
              <div class="col-6 col-xxl-3">
                <div class="nav flex-column pt-xxl-1">
                  <p class="nav-link text-700 mb-0 fw-bold">Icons</p><a class="nav-link py-1 link-600 fw-medium" href="../modules/icons/font-awesome.html">Font awesome</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/icons/bootstrap-icons.html">Bootstrap icons</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/icons/feather.html">Feather</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/icons/material-icons.html">Material icons</a>
                  <p class="nav-link text-700 mb-0 fw-bold">Maps</p><a class="nav-link py-1 link-600 fw-medium" href="../modules/maps/google-map.html">Google map</a><a class="nav-link py-1 link-600 fw-medium" href="../modules/maps/leaflet-map.html">Leaflet map</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </li> -->
    
  </ul>
</div>
<ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
  <li class="nav-item">
    <div class="theme-control-toggle fa-icon-wait px-2">
      <input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle" type="checkbox" data-theme-control="theme" value="dark" />
      <label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to light theme"><span class="fas fa-sun fs-0"></span></label>
      <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to dark theme"><span class="fas fa-moon fs-0"></span></label>
    </div>
  </li>
  <!-- <li class="nav-item d-none d-sm-block">
    <a class="nav-link px-0 notification-indicator notification-indicator-warning notification-indicator-fill fa-icon-wait" href="../app/e-commerce/shopping-cart.html"><span class="fas fa-shopping-cart" data-fa-transform="shrink-7" style="font-size: 33px;"></span><span class="notification-indicator-number">1</span></a>

  </li> -->
  <!-- <li class="nav-item dropdown">
    <a class="nav-link notification-indicator notification-indicator-primary px-0 fa-icon-wait" id="navbarDropdownNotification" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-hide-on-body-scroll="data-hide-on-body-scroll"><span class="fas fa-bell" data-fa-transform="shrink-6" style="font-size: 33px;"></span></a>
    <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end dropdown-menu-card dropdown-menu-notification dropdown-caret-bg" aria-labelledby="navbarDropdownNotification">
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

  </li> -->
  <!-- <li class="nav-item dropdown px-1">
    <a class="nav-link fa-icon-wait nine-dots p-1" id="navbarDropdownMenu" role="button" data-hide-on-body-scroll="data-hide-on-body-scroll" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="43" viewBox="0 0 16 16" fill="none">
        <circle cx="2" cy="2" r="2" fill="#6C6E71"></circle>
        <circle cx="2" cy="8" r="2" fill="#6C6E71"></circle>
        <circle cx="2" cy="14" r="2" fill="#6C6E71"></circle>
        <circle cx="8" cy="8" r="2" fill="#6C6E71"></circle>
        <circle cx="8" cy="14" r="2" fill="#6C6E71"></circle>
        <circle cx="14" cy="8" r="2" fill="#6C6E71"></circle>
        <circle cx="14" cy="14" r="2" fill="#6C6E71"></circle>
        <circle cx="8" cy="2" r="2" fill="#6C6E71"></circle>
        <circle cx="14" cy="2" r="2" fill="#6C6E71"></circle>
      </svg></a>
    <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end dropdown-menu-card dropdown-caret-bg" aria-labelledby="navbarDropdownMenu">
      <div class="card shadow-none">
        <div class="scrollbar-overlay nine-dots-dropdown">
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

  </li> -->
  <li>
      <div><?= $_SESSION["fname"] . " " . $_SESSION['LNAME']. " "?></div>
    </li>
  <li class="nav-item dropdown"><a class="nav-link pe-0" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div class="avatar avatar-xl" style="border-radius: 25px;
  background-color: var(--falcon-btn-falcon-primary-active-background); color: var(--falcon-list-group-item-color-primary);
  padding-top: 2px;
  width: 30px;
  height: 30px;
  display: flex;
justify-content: center; /* Align horizontal */
align-items: center;">
          <p style="font-size: 10px; margin-top:14px;">
            <?php echo strtoupper(substr($_SESSION['fname'], 0, 1)) . "" . strtoupper(substr($_SESSION['LNAME'], 0, 1)) ?>
          </p> 
          <!-- <img class="rounded-circle" src="../../assets/img/team/3-thumb.png" alt="" /> -->
          <!-- <i class="bi bi-gear"></i> -->
          <!-- <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
  <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
  <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
</svg> -->
        </div>
      </a>
    <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
      <div class="bg-white dark__bg-1000 rounded-2 py-2">
        <!-- <a class="dropdown-item fw-bold text-warning" href="#!"><span class="fas fa-crown me-1"></span><span>Go Pro</span></a>

        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#!">Set status</a>
        <a class="dropdown-item" href="../pages/user/profile.html">Profile &amp; account</a>
        <a class="dropdown-item" href="#!">Feedback</a>

        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="../pages/user/settings.html">Settings</a> -->
        <a class="dropdown-item" href="../../logout/index.php">Logout</a>
      </div>
    </div>
  </li>
</ul>
</nav>
<?php ?>