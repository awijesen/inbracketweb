<?php
session_start();
include('header.php');

echo $_SESSION['PCOUNT'];
?>
<title>Plate Generator</title>
<style>
	img.barcode {
		border: 1px solid #ccc;
		padding: 20px 10px;
		border-radius: 5px;
	}
</style>
<?php //include('container.php'); 
?>

<div class='col-md-12 card mb-3' id="msgconn">
	<div class='card-header'>
		<h5 class='mb-0'>Plate Generator</h5>
	</div>

	<div class="card-body bg-light">
		<div class="row">
			<div class="col-md-5">
				<form method="post" name="plateform" id="plateform">
					<!-- <div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label>Product Name or Number</label>
										<input type="text" name="barcodeText" class="form-control" value="<?php echo @$_POST['barcodeText']; ?>">
									</div>
								</div>
							</div> -->
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Plate count to print:</label>
								<select name="barcodeType" id="barcodeType" class="form-control">
									<option value="Select">Select</option>
									<option value="1">1</option>
									<option value="10">10</option>
									<option value="50">50</option>
									<option value="80">80</option>
									<option value="100">100</option>
									<option value="200">200</option>
								</select>
							</div>
							<!-- <div class="form-group">
										<label>Barcode Type</label>
										<select name="barcodeType" id="barcodeType" class="form-control">
											<option value="codabar" <?php echo (@$_POST['barcodeType'] == 'codabar' ? 'selected="selected"' : ''); ?>>Codabar</option>
											<option value="code128" <?php echo (@$_POST['barcodeType'] == 'code128' ? 'selected="selected"' : ''); ?>>Code128</option>
											<option value="code39" <?php echo (@$_POST['barcodeType'] == 'code39' ? 'selected="selected"' : ''); ?>>Code39</option>
										</select>
									</div> -->
						</div>
					</div>
					<!-- <div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Barcode Display</label>
										<select name="barcodeDisplay" class="form-control" required>
											<option value="horizontal" <?php echo (@$_POST['barcodeDisplay'] == 'horizontal' ? 'selected="selected"' : ''); ?>>Horizontal</option>
											<option value="vertical" <?php echo (@$_POST['barcodeDisplay'] == 'vertical' ? 'selected="selected"' : ''); ?>>Vertical</option>
										</select>
									</div>
								</div>
							</div> -->
					<div class="row">
						<div class="col-md-7">
							<input type="hidden" name="barcodeSize" id="barcodeSize" value="20">
							<input type="hidden" name="printText" id="printText" value="true">
							<input type="submit" id="generateBarcode" name="generateBarcode" class="btn btn-primary form-control generateBarcode" value="Generate Plates">
						</div>
						<div class="col-md-7 pt-3">
							<a type="button" name="printbc" id="printbc" class="btn btn-primary form-control" target="_blank" href="print.php?p=">Print</a>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-4" id="content_plates"></div>
		</div>
	</div>



	<?php //include('footer.php'); 
	?>

	<script>
		// $(document).ready(function(){
		// $('#printbc').hide();
		$('#barcodeType').on('change', function(xc) {
			xc.preventDefault();
			var CurrentVal = $('#barcodeType').val();
			if (CurrentVal == 'Select') {
				alert('Select number of plates to print');
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

		});

		//   $('#printbc').on('click', function(exe) {
		//     exe.preventDefault();
		// window.open('print.php?platecount="10"');
		// $("#content_plates").printThis();
		// 	$('#msgconn').hide();
		// 	$("#content_plates").show();
		//     window.print();
		//    $('#messenger_a').show();
		//     var clickId = $(this).attr('id');
		// 	var barcodeSize = $('#barcodeSize').val();
		// 	var printText = $('#printText').val();
		// 	var platecount = $('#barcodeType').val();

		// 	alert(platecount);
		//     $.ajax({
		//       url: "print.php", //the page containing php script
		//       type: "POST", //request type,
		//       data: {
		//         link: clickId,
		// 		barcodeSize : barcodeSize,
		// 		printText: printText,
		// 		platecount: platecount
		//       },
		//       success: function(result) {
		// 		// alert(result);
		// 		window.open('print.php', '_blank'); 
		//       },
		//       error: function(err) {
		//         //alert('Error : WZSD323');
		// 		console.log(err);
		// 		alert(err);
		//       }
		//     });

		//   });

		// })
	</script>