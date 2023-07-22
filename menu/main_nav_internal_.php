
<?php
if(isset($_GET['a2'])){
  $newVar2 = 'Active';
  $newVar1 = '';
} else {
  $newVar1 = 'Active';
  $newVar2 = '';
}
?>

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

            </div><a class="navbar-brand" href="index.html">
              <div class="d-flex align-items-center py-3"><img class="me-2" src="assets/img/icons/spot-illustrations/falcon.png" alt="" width="40" /><span class="font-sans-serif">falcon</span>
              </div>
            </a>
          </div>
          <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
            <div class="navbar-vertical-content scrollbar">
              <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
              <li class="nav-item">
                  <!-- parent p--><a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dashboard">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text ps-1">Outbound Tasks</span>
                    </div>
                  </a>
                  <ul class="nav collapse show" id="dashboard">
                    <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../p/assign_sales_orders/index.php" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Schedule Pick</span>
                        </div>
                      </a>
                      <!-- more inner p-->
                    </li>
                    <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>"  id="menu_so" href="../picks_in_progress" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Picks in Progress</span>
                        </div>
                      </a>
                    </li>
                    <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>"  id="menu_pickreview" href="../pick_review" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Pick Review</span>
                        </div>
                      </a>
                    </li>
                    <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>"  id="menu_history" href="../pick_history" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Pick History</span>
                        </div>
                      </a>
                    </li>
                  </ul>
                </li>

                <!-- INBOUND START -->
                <li class="nav-item">
                  <!-- parent p--><a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dashboard">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text ps-1">Inbound Tasks</span>
                    </div>
                  </a>
                  <ul class="nav collapse show" id="dashboard">
                    <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../p/assign_sales_orders/index.php" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Schedule Receipt</span>
                        </div>
                      </a>
                      <!-- more inner p-->
                    </li>
                    <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>"  id="menu_so" href="../picks_in_progress" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Receipts in Progress</span>
                        </div>
                      </a>
                    </li>
                    <li id="a2" class="nav-item"><a class="nav-link <?php echo $newVar2; ?>" href="dashboard/analytics.php" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Schedule ST Pick</span>
                        </div>
                      </a>
                      <!-- more inner p-->
                    </li>
                    <li class="nav-item"><a class="nav-link" href="dashboard/crm.html" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">CRM</span>
                        </div>
                      </a>
                      <!-- more inner p-->
                    </li>
                    <li class="nav-item"><a class="nav-link" href="dashboard/e-commerce.html" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">E commerce</span>
                        </div>
                      </a>
                      <!-- more inner p-->
                    </li>
                    <li class="nav-item"><a class="nav-link" href="dashboard/project-management.html" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Management</span>
                        </div>
                      </a>
                      <!-- more inner p-->
                    </li>
                    <li class="nav-item"><a class="nav-link" href="dashboard/saas.html" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">SaaS</span>
                        </div>
                      </a>
                      <!-- more inner p-->
                    </li>
                  </ul>
                </li>
                <!-- INBOUND END -->

                  <!-- inventory START -->
                  <li class="nav-item">
                  <!-- parent p--><a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dashboard">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text ps-1">Inventory</span>
                    </div>
                  </a>
                  <ul class="nav collapse show" id="dashboard">
                    <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../inventory_search" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Stock Enquiry</span>
                        </div>
                      </a>
                      <!-- more inner p-->
                    </li>
                    <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../inventory_correction" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Stock Adjustment</span>
                        </div>
                      </a>
                      <!-- more inner p-->
                    </li>
                  </ul>
                </li>
                <!-- inventoty END -->

                 <!-- reports START -->
                 <li class="nav-item">
                  <!-- parent p--><a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dashboard">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text ps-1">Reports</span>
                    </div>
                  </a>
                  <ul class="nav collapse show" id="dashboard">
                    <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../invoice_ready" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Orders to Invoice</span>
                        </div>
                      </a>
                      <!-- more inner p-->
                    </li>
                  </ul>
                </li>
                <!-- reports END -->
                <li class="nav-item">
                  <!-- parent p--><a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="../dashboard">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text ps-1">Dashboard</span>
                    </div>
                  </a>
                  <ul class="nav collapse show" id="dashboard">
                    <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../index.php" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Default</span>
                        </div>
                      </a>
                      <!-- more inner p-->
                    </li>
                    <li id="a2" class="nav-item"><a class="nav-link <?php echo $newVar2; ?>" href="../dashboard/analytics.php?pgd=433" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Analytics</span>
                        </div>
                      </a>
                      <!-- more inner p-->
                    </li>
                    <li class="nav-item"><a class="nav-link" href="../dashboard/crm.html" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">CRM</span>
                        </div>
                      </a>
                      <!-- more inner p-->
                    </li>
                    <li class="nav-item"><a class="nav-link" href="../dashboard/e-commerce.html" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">E commerce</span>
                        </div>
                      </a>
                      <!-- more inner p-->
                    </li>
                    <li class="nav-item"><a class="nav-link" href="../dashboard/project-management.html" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Management</span>
                        </div>
                      </a>
                      <!-- more inner p-->
                    </li>
                    <li class="nav-item"><a class="nav-link" href="../dashboard/saas.html" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">SaaS</span>
                        </div>
                      </a>
                      <!-- more inner p-->
                    </li>
                  </ul>
                </li>
              </ul>

              <!-- settings START -->
              <li class="nav-item">
                  <!-- parent p--><a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dashboard">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text ps-1">Settings</span>
                    </div>
                  </a>
                  <ul class="nav collapse show" id="dashboard">
                    <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../p/assign_sales_orders/index.php" data-bs-toggle="" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Users</span>
                        </div>
                      </a>
                      <!-- more inner p-->
                    </li>
                    
                  </ul>
                </li>
                <!-- settings -->
              <!-- <div class="settings mb-3">
                <div class="card alert p-0 shadow-none" role="alert">
                  <div class="btn-close-falcon-container">
                    <div class="btn-close-falcon" aria-label="Close" data-bs-dismiss="alert"></div>
                  </div>
                  <div class="card-body text-center"><img src="assets/img/icons/spot-illustrations/navbar-vertical.png" alt="" width="80" />
                    <p class="fs--2 mt-2">Loving what you see? <br />Get your copy of <a href="#!">Falcon</a></p>
                    <div class="d-grid"><a class="btn btn-sm btn-purchase" href="https://themes.getbootstrap.com/product/falcon-admin-dashboard-webapp-template/" target="_blank">Purchase</a></div>
                  </div>
                </div>
              </div> -->
            </div>
          </div>
        </nav>