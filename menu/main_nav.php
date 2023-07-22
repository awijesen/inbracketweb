<?php
if (isset($_GET['a2'])) {
  $newVar2 = 'Active';
  $newVar1 = '';
} else {
  $newVar1 = 'Active';
  $newVar2 = '';
}
$base = 'localhost/inbracket';

require('../../root.php');
?>

<nav class="navbar navbar-light navbar-vertical navbar-expand-xl mt-2">
  <script>
    var navbarStyle = localStorage.getItem("navbarStyle");
    if (navbarStyle && navbarStyle !== 'transparent') {
      document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
    }
  </script>
  <div class="d-flex align-items-center">
    <div class="toggle-icon-wrapper">

      <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>

    </div><a class="navbar-brand" href="../../">
      <div class="d-flex align-items-center py-3"><img class="me-2" src="../../assets/img/gallery/inbracket_colour.png" alt="" width="110" />
      </div>
    </a>
  </div>
  <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
    <div class="navbar-vertical-content scrollbar">
      <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
        <li class="nav-item">
          <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
            <div class="col-auto navbar-vertical-label">Outbound Tasks</div>
            <div class="col ps-0">
              <hr class="mb-0 navbar-vertical-divider">
            </div>
          </div>
          <!-- parent p--><a class="nav-link dropdown-indicator" href="#outbound" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="outbound">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-dolly"></span></span><span class="nav-link-text ps-1">Stock Pick</span>
            </div>
          </a>
          <ul class="nav collapse show" id="outbound">
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" id="menu_so" href="../order_manager" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Schedule Pick</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" id="menu_so" href="../schedule_history" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Schedule History</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" id="menu_so" href="../picks_in_progress" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Picks in Progress</span>
                </div>
              </a>
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" id="menu_pickreview" href="../pick_review" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Pick Review
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
                </div>
              </a>
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" id="menu_his" href="../pick_history" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Pick History</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" id="menu_his" href="../pack_list_label" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Packing</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" id="menu_his" href="../dispatch" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Dispatch</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>

          </ul>
        </li>

        <!-- Inbound start -->
        <li class="nav-item">
        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
            <div class="col-auto navbar-vertical-label">Inbound Tasks</div>
            <div class="col ps-0">
              <hr class="mb-0 navbar-vertical-divider">
            </div>
          </div>
          <!-- parent p--><a class="nav-link dropdown-indicator" href="#inbound" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="inbound">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-truck-loading"></span></span><span class="nav-link-text ps-1">Stock Receipts</span>
            </div>
          </a>
          <ul class="nav collapse show" id="inbound">
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" id="menu_so" href="../stockplates" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Stockplates</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" id="menu_so" href="../inbound_order_manager" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Schedule PO</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" id="menu_so" href="../scheduled_po_history" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Scheduled PO History</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" id="menu_so" href="../receipts_in_progress" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Receipts in Progress</span>
                </div>
              </a>
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" id="menu_so" href="../completed_po" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Completed PO Report</span>
                </div>
              </a>
            </li>

          </ul>
        </li>
        <!-- Inbound end -->

        <!-- inventory START -->
        <li class="nav-item">
        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
            <div class="col-auto navbar-vertical-label">Inventory</div>
            <div class="col ps-0">
              <hr class="mb-0 navbar-vertical-divider">
            </div>
          </div>
          <!-- parent p--><a class="nav-link dropdown-indicator" href="#stock" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="stock">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fab fa-buffer"></span></span><span class="nav-link-text ps-1">Inventory Manager</span>
            </div>
          </a>
          <ul class="nav collapse show" id="stock">
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../product_master" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Product Master</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../stock_control" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Stock Control</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../inventory_search" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Stock Enquiry</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../stock_trail" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Stock Trail Enquiry</span>
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
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../inventory_correction_history" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Adjustments History</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../stock_locations" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Stock Locations</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../putaway" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Putaway History</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
          </ul>
        </li>
        <!-- inventoty END -->

        <!-- reports START -->
        <li class="nav-item">
        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
            <div class="col-auto navbar-vertical-label">Warehouse Intelligence</div>
            <div class="col ps-0">
              <hr class="mb-0 navbar-vertical-divider">
            </div>
          </div>
          <!-- parent p--><a class="nav-link dropdown-indicator" href="#invoicing" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="invoicing">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-line"></span></span><span class="nav-link-text ps-1">Reports</span>
            </div>
          </a>
          <ul class="nav collapse show" id="invoicing">
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../invoice_ready" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Orders to Invoice

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
                </div>
              </a>
              <!-- more inner p-->
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../invoice_history" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Invoice History</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../fetch_orders" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Fetch Orders</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../non_putaway" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Non Putaway Report
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
                </span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../negative_stock" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Negative SOH Report
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
                </span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../replenishment" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Replenishment Trail</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
          </ul>
        </li>

        <!-- reports END -->
        <!-- settings START -->
        <li class="nav-item">
          <!-- parent p--><a class="nav-link dropdown-indicator collapsed" href="#settings" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="settings">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-cog"></span></span><span class="nav-link-text ps-1">Settings</span>
            </div>
          </a>
          <ul class="nav collapse" id="settings">
            <li id="a1" class="nav-item"><a class="nav-link <?php echo $newVar1; ?>" href="../users" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Users</span>
                </div>
              </a>
              <!-- more inner p-->
            </li>
          </ul>
        </li>
        <!-- settings -->
      </ul>
    </div>
  </div>
</nav>