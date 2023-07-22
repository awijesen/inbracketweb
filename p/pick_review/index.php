<?php

session_start();
if (!isset($_SESSION['LOGGED'])) {
  header('Location: ../../');
}
?>

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<?php include('../common/header.html'); ?>


<body>

  <!-- ===============================================-->
  <!--    Main Content-->
  <!-- ===============================================-->
  <main class="main" id="top">
    <div class="container-fluid" data-layout="container">
      <script>
        var isFluid = JSON.parse(localStorage.getItem('isFluid'));
        if (isFluid) {
          var container = document.querySelector('[data-layout]');
          container.classList.remove('container');
          container.classList.add('container-fluid');
        }
      </script>

      <?php include('../../menu/main_nav.php'); ?>
      <div class="content">
        <?php include('../../menu/sub_nav.php'); ?>

        <div class="card mb-3">
          <!--/.bg-holder-->
          <div class="card-header bg-light">
            <div class="row justify-content-between align-items-center">
              <div class="col-10">
                <div class="row">
                  <div class="col-3">
                    <h5 class="card-header-title mb-0 col-12">Pick Review</h5>
                  </div>
                </div>
              </div>
              <!-- <div class="col-2 ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all as read</a></div> -->
            </div>
          </div>
          <div class="card-body position-relative">

            <div>
              <div class="table-responsive scrollbar">
                <?php
                require('../../dbconnect/db.php');

                $sql =  "SELECT
              pk.SalesOrderNumber,
              pk.PickedBy,
              pk.OrderCustomer,
              pk.Reference,
              (SELECT distinct(ord.ShipDay) FROM GRW_INB_SALES_ORDERS ord WHERE ord.SalesOrderNumber=pk.SalesOrderNumber) as 'ShipDay',
              (CASE 
                WHEN COUNT(pk.ReasonCode) > '0' THEN 'Review'
                ELSE ''
                  END) AS 'OOSstatus'
              FROM INB_COMPLETED_PICKS pk
              WHERE pk.PushedStatus IS NULL
              GROUP BY pk.SalesOrderNumber";

                // $sql = "SELECT distinct(OrderCustomer), OrderValue as 'Val', Reference as 'Ref' FROM GRW_INB_SALES_ORDERS WHERE SalesOrderNumber=? group by SalesOrderNumber";
                $stmt = $conn->prepare($sql);
                // $stmt->bind_param("s", $orderToFetch);
                $stmt->execute();
                $result = $stmt->get_result();
                ?> <table id="dataRef" class="table table-hover table-striped table-sm overflow-hidden font-sans-serif fs--2">
                  <thead>
                    <tr>
                      <th>Order&nbsp;Number</th>
                      <th>Picker</th>
                      <th>Customer</th>
                      <th>Reference</th>
                      <th>Ship&nbsp;Day</th>
                      <th>Status</th>
                      <th> . . .</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                      if ($row["OOSstatus"] === 'Review') {
                        $entry = "<span class='badge badge-soft-danger' style='min-width: 62px !important'>Review OOS</span>";
                      } else {
                        $entry = "<span class='badge badge-soft-success' style='min-width: 62px !important'>Fully Picked</span>";
                      }

                      $data = '<a href="../_detail/index.php?link=' . $row['SalesOrderNumber'] . '" class="orderRef_" id=' . $row['SalesOrderNumber'] . '>' . $row['SalesOrderNumber'] . '</a>';

                      echo "
                <tr class='align-middle hover-actions-trigger'><td class='text-nowrap'>" . $data . "</td>
                <td class='text-nowrap'>" . $row["PickedBy"] . "</td>
                <td class='text-nowrap'>" . $row["OrderCustomer"] . "</td>
                <td class='text-nowrap'>" . $row["Reference"] . "</td>
                <td class='text-nowrap'>" . $row["ShipDay"] . "</td>
                <td class='text-nowrap'>" . $entry . "</td>
                <td class='w-auto'>
                    <button id='" . $row["SalesOrderNumber"] . "' class='btn btn-light btn-sm clickforpush' type='button' data-bs-toggle='tooltip' data-bs-placement='top' title='Send " . $row["SalesOrderNumber"] . "'>
                      <span class='fa fa-check-square'></span>
                    </button>
                </td> 
                </tr>
                ";
                    }
                    ?>
                  </tbody>
                </table>

              </div>
            </div>
            <!-- close body -->
          </div>
        </div>
        <footer class="footer" style="font-family: 'Poppins'; font-size: 13px">
          <!-- footer -->
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


  <!-- ===============================================-->
  <!--    JavaScripts-->
  <!-- ===============================================-->
  <?php include('../common/footer.html'); ?>
</body>

</html>

<script>
$('.clickforpush').click(function(ee) {
    ee.preventDefault();
    var clickId = $(this).attr('id');

    $.ajax({
      url: "_make_invoice_ready.php", 
      type: "POST",
      data: {
        link: clickId,
      },
      success: function(result) {
        location.reload();
      }
    });
  });
</script>