<?php

session_start();
if (!isset($_SESSION['LOGGED'])) {
    header('Location: ../../');
}
?>

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<?php include('../common/header.html'); ?>

<style>
    img.barcode {
        border: 1px solid #ccc;
        padding: 20px 10px;
        border-radius: 5px;
    }
</style>

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
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 pe-1">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="row flex-between-center">
                                    <div style="height: 25px"><button type="buton" class="btn btn-link refresh_dropdown fs--1">Refresh</button>
                                        <img id="spinner_refresh" src="../../assets/img/spinner.gif" height="25" />
                                    </div>
                                    <div class="dropContainer mt-3 mb-3">
                                        <select name="_upkr" id="_upkr" class="form-select">
                                            <option value="selectpackinglist">Select Packing List</option>
                                            <?php
                                            require(__DIR__ . '../../../dbconnect/db.php');

                                            $sql = "SELECT det.packListId, det.CustomerName
                                            FROM INB_PACK_LIST_DETAIL det
                                            LEFT OUTER JOIN (select PKLStatus, packListId from INB_PACK_LIST) as t on t.packListId=det.packListId 
                                            WHERE DispatchStatus is null AND t.PKLStatus='Completed'
                                            GROUP BY packListId";

                                            $stmt = $conn->prepare($sql);
                                            // $stmt->bind_param("s", $search);
                                            // $search = $findOrder;
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value=' . $row["packListId"] . '>' . $row["packListId"] . ' - ' . $row["CustomerName"] . '</option>';
                                                }
                                            } else {
                                                echo "error";
                                            }    ?>

                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="courier">Courier</label>
                                        <select name="courier" id="courier" class="form-select">
                                            <option value="selectcourier">Select Courier</option>
                                            <option value="Bains Transport">Bains Transport</option>
                                            <option value="Sea Swift">Sea Swift</option>
                                            <option value="ABC Transport">ABC Transport</option>
                                            <option value="TLC Transport">TLC Transport</option>
                                            <option value="East Arm Transport">East Arm Transport</option>
                                            <option value="Dean Wilson Transport">Dean Wilson Transport</option>
                                            <option value="McLeans Transport">McLeans Transport</option>
                                            <option value="Nighthawk Transport">Nighthawk Transport</option>
                                            <option value="Show Barge">Show Barge</option>
                                            <option value="Northline Transport">Northline Transport</option>
                                            <option value="AJ Couriers">AJ Couriers</option>
                                            <option value="Direct Transport">Direct Transport</option>


                                            <!-- <?php
                                                    require(__DIR__ . '../../../dbconnect/db.php');

                                                    $sql = "SELECT packListId, CustomerName 
                                        FROM INB_PACK_LIST_DETAIL 
                                        WHERE DispatchStatus is null
                                        GROUP BY packListId";

                                                    $stmt = $conn->prepare($sql);
                                                    // $stmt->bind_param("s", $search);
                                                    // $search = $findOrder;
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();

                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo '<option value=' . $row["packListId"] . '>' . $row["packListId"] . ' - ' . $row["CustomerName"] . '</option>';
                                                        }
                                                    } else {
                                                        echo "error";
                                                    }    ?> -->

                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="connote">Consignment Note</label>
                                        <input type="text" class="form-control" id="connote">
                                    </div>
                                    <div class="mb-3">
                                        <label for="palcount">Pallet Count</label>
                                        <input type="text" class="form-control" id="palcount">
                                    </div>
                                    <div class="mb-3">
                                        <label for="boxcount">Box Count</label>
                                        <input type="text" class="form-control" id="boxcount">
                                    </div>
                                    <div class="mb-3">
                                        <label for="footnote">Foot Note</label>
                                        <input type="text" class="form-control" id="footnote">
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary" id="save-lbl-data">Save</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 d-none d-sm-block">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="row flex-between-center">
                                    <div class="col d-md-flex d-lg-block flex-between-center">
                                        <h6 class="mb-md-0 mb-lg-2">Print Shipping Label</h6>
                                        <div class="row">
                                            <table id="pack_list_table" class="table table-striped table-hover dt-responsive display compact font-sans-serif fs--1 custFontSize" style="width: 100% !important">
                                                <thead>
                                                    <tr>
                                                        <th>...</th>
                                                        <th>Pack&nbsp;List&nbsp;ID</th>
                                                        <th>Packer</th>
                                                        <th>Sales&nbsp;Order</th>
                                                        <th>Customer</th>
                                                        <th>Consignment&nbsp;Note</th>
                                                        <th>Label&nbsp;Count</th>
                                                        <th>Print</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Button trigger modal -->

                <div class="modal fade" id="print-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                        <div class="modal-content position-relative">
                            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0">
                                <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                    <h4 class="mb-1" id="modalExampleDemoLabel">Print Shipping Labels </h4>
                                </div>
                                <div class="p-4 pb-0">
                                    <form>
                                        <div class="mb-3" style="font-family: 'Poppins'; font-size: 16px">
                                            Confirm printing labels?
                                            <input class="form-control" id="pkl-id" type="hidden" />
                                        </div>
                                        <div class="mb-3">
                                            <input class="form-control" id="printcount" type="hidden" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary" type="button" id="confirm-print">Confirm </button>
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
    $(document).ready(function() {
        $('#printbc').hide();
        $('#spinner_refresh').hide();

        $('#pack_list_table').DataTable({
            // 'fixedHeader': true,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'pageLength': 20,
            'stateSave': true,
            'dom': '<<B>frt<ip>>',
            'buttons': [

            ],
            'lengthMenu': [
                [10, 25, 50, 100, 100000000000],
                [10, 25, 50, 100, 'All']
            ],
            'ajax': {
                'url': 'datatable.php'
            },
            'order': [
                [2, 'desc']
            ],
            'columns': [{
                    data: 'selector'
                },
                {
                    data: 'packListId'
                },
                {
                    data: 'PackedBy'
                },
                {
                    data: 'SalesOrderNumber'
                },
                {
                    data: 'CustomerName'
                },
                {
                    data: 'ConsignmentNote'
                },
                {
                    data: 'lCount'
                },
                {
                    data: 'printLabel'
                }
            ],
            'columnDefs': [{
                    orderable: false,
                    targets: [0]
                },
                {
                    "targets": [3, 6],
                    "className": "text-center"
                },
                {
                    "targets": [5, 7],
                    "className": "text-nowrap"
                }
            ],
            'responsive': 'true',
            'responsive': {
                details: {
                    type: 'none'
                }
            },
            'language': {
                'info': '_START_ to _END_ of _TOTAL_ orders',
                'infoEmpty': 'Showing 0 to 0 of 0 scans',
                'infoFiltered': '(filtered from _MAX_ total orders)',
                'sLengthMenu': '_MENU_'
                // "infoFiltered":""
            },
        });

        codeListTable = $("#pack_list_table").DataTable();
    });
    // $('#printbc').hide();
    $('#barcodeType').on('change', function(xc) {
        xc.preventDefault();
        var CurrentVal = $('#barcodeType').val();
        if (CurrentVal == 'Select') {
            $('#errors').html('Select number of plates to print');
        } else if (CurrentVal == '1') {
            var __href = 'print.php?p=';
            $("#printbc").attr("href", __href + 'a');
        } else if (CurrentVal == '10') {
            var __href = 'print.php?p=';
            $("#printbc").attr("href", __href + 'v');
        } else if (CurrentVal == '50') {
            var __href = 'print.php?p=';
            $("#printbc").attr("href", __href + 'b');
        } else if (CurrentVal == '80') {
            var __href = 'print.php?p=';
            $("#printbc").attr("href", __href + 'r');
        } else if (CurrentVal == '100') {
            var __href = 'print.php?p=';
            $("#printbc").attr("href", __href + 'j');
        } else if (CurrentVal == '200') {
            var __href = 'print.php?p=';
            $("#printbc").attr("href", __href + 'l');
        }

    });

    $('#plateform').on('submit', function(ee) {
        ee.preventDefault();
        var selection = $('#barcodeType option:selected').val();
        if (selection == 'Select') {
            $('.errors').html('Select number of stockplates to print');
        } else {
            $('#printbc').show();
            $('.errors').html('');

            $('#messenger_a').show();
            var clickId = $(this).attr('id');
            var barcodeSize = $('#barcodeSize').val();
            var printText = $('#printText').val();
            var platecount = $('#barcodeType').val();

            $.ajax({
                url: "populate_plates.php", //the page containing php script
                type: "POST", //request type,
                data: {
                    link: clickId,
                    barcodeSize: barcodeSize,
                    printText: printText,
                    platecount: platecount
                },
                success: function(result) {
                    // alert(result);
                    $('#content_plates').html(result);
                    $('#messenger_a').hide();
                    $('#printbc').show();
                },
                error: function(err) {
                    //alert('Error : WZSD323');
                    console.log(err);
                    alert(err);
                }
            });
        }
    });

    function printContent(el) {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;

        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }

    $('.refresh_dropdown').on('click', function(ede) {
        ede.preventDefault();
        location.reload();
        // $('#spinner_refresh').show();
        // $.ajax({
        //     url: "refreshdropdown.php", //the page containing php script
        //     type: "POST", //request type,
        //     success: function(result) {
        //         // alert(result);
        //         $('.dropContainer').html(result);
        //         $('#spinner_refresh').hide();
        //     }
        // });
    });

    $('#search').on('keyup', function() {
        codeListTable.search(this.value).draw();
        codeListTable.state.save();
    });

    $('#save-lbl-data').on('click', function(gg) {
        gg.preventDefault();

        var packid_ = $('#_upkr option:selected').val();
        var transport_ = $('#courier option:selected').val()
        var connote_ = $('#connote').val();
        var palcount_ = $('#palcount').val();
        var boxcount_ = $('#boxcount').val();
        var footnote_ = $('#footnote').val();

        $.ajax({
            url: "UpdatePackListData.php", //the page containing php script
            type: "POST", //request type,
            data: {
                packid: packid_,
                transport: transport_,
                connote: connote_,
                palcount: palcount_,
                boxcount: boxcount_,
                footnote: footnote_
            },
            success: function(result) {
                if (result == 'updated') {
                    $('#_upkr').val('selectpackinglist');
                    $('#courier').val('selectcourier')
                    $('#connote').val('');
                    $('#palcount').val('');
                    $('#boxcount').val('');
                    $('#footnote').val('');
                    $('#pack_list_table').DataTable().ajax.reload();
                } else {
                    alert(result);
                }
            },

        });
    });

    $('#_upkr').on('change', function(cr) {
        cr.preventDefault();
        var pklId = $('#_upkr option:selected').val();

        $.ajax({
            url: "findcounts.php", //the page containing php script
            type: "POST", //request type,
            data: {
                packid: pklId,
            },
            success: function(res) {
                if (jQuery.parseJSON(res).Alert_ === 'No pack id') {
                    alert('Unable to fetch the Pack list ID');
                } else if (jQuery.parseJSON(res).Alert_ === 'Error') {
                    alert('Unable to fetch Pack list data. Please refresh the browser and try again.');
                } else {
                    $('#boxcount').val(jQuery.parseJSON(res).bc);
                    $('#palcount').val(jQuery.parseJSON(res).pc);
                }
            }
        })
    })

    $('#pack_list_table').on('click', '.orderRef_', function(dx) {
        dx.preventDefault();
        var id = $(this).attr('id');
        var lblcount_ = $(this).attr('lblcount');
        $('#pkl-id').val(id);
        $('#printcount').val(lblcount_);

        $('#print-modal').modal('show');

    });

    $('#confirm-print').on('click', function(iu) {
        iu.preventDefault();
        $a1 = $('#pkl-id').val();
        $a2 = $('#printcount').val();

        $.ajax({
            url: "../packing_label/index.php", //the page containing php script
            type: "POST", //request type,
            data: {
                linked:  $a1,
                pcount: $a2
            },
            success: function(res) {
                $('#print-modal').modal('hide');
                window.open("https://workspace.inbracket.com/p/packing_label/index.php?linked=" + $a1 + "&pcount=" + $a2, "_blank");
            }
        })

    })
</script>