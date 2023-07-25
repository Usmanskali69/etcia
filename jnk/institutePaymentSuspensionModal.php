<?php
include('db_connect.php');
//$row_id = htmlspecialchars($_GET['row_id']);
$instituteRowId = htmlspecialchars($_GET['instituteRowId']);
/* echo 'aaaa'.$row_id.'____gggg____'.$instituteRowId;
exit; */
?>

</head>
<!--<form role="form" id="suspend" class="form-horizontal" method="post">
	<div class="modal-header" style="background-color:#f6f6f6">
		<button type="button" class="close" data-dismiss="modal">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only">Close</span>
		</button>
		<h4 class="modal-title" align="center">Payment Suspension Confirmation</h4>
	</div>
	<div class="modal-body">
		 <div class="form-group">
			<label for="remarks" class="col-lg-9 control-label">Do you want to confirm the payment suspension?</label>
		</div>									
	</div>	
	<div class="modal-footer" style="background-color:#f6f6f6">
	<div class="col-lg-8" id = "PaymentSuspensionMessage"></div>
		<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
		<input type="hidden" id="studentRowId" value="<?PHP //echo $row_id; ?>">
		<input type="hidden" id="instituteRowId2" value="<?PHP //echo $instituteRowId; ?>">
		<?PHP// if(($row_id == '' || $row_id == null) && ($instituteRowId != '' && $instituteRowId != null)) { ?>
		<a class="btn btn-success updateInstitutePaymentSuspensionStatus1" type="button" id="updateInstitutePaymentSuspensionStatus1" name="updateInstitutePaymentSuspensionStatus1">Confirm</a>
		<?PHP //} else if(($row_id != '' && $row_id != null) && ($instituteRowId == '' || $instituteRowId == null)) { ?>
		<a class="btn btn-success updateStudentPaymentSuspensionStatus2" type="button" id="updateStudentPaymentSuspensionStatus2" name="updateStudentPaymentSuspensionStatus2">Confirm</a>
		<?PHP //} ?>
	</div>
</form>-->

<form role="form" id="institute" class="form-horizontal" method="post">
	<div class="modal-header" style="background-color:#f6f6f6">
		<button type="button" class="close" data-dismiss="modal">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only">Close</span>
		</button>
		<h4 class="modal-title" align="center">Institute Payment Suspension</h4>
	</div>
	<div class="modal-body">
		 <div class="form-group">
			<label for="remarks" class="col-lg-4 control-label">Remarks:</label>
			<div class="col-lg-7">
				<textarea type="text" name="remarksInst" class="form-control remarksInst" id="remarksInst" placeholder="Remarks"></textarea>
			</div>
		</div>									
	</div>	
	<input type="hidden" class="form-control" id="rowId2" value="<?php echo $instituteRowId; ?>" >
	<div class="modal-footer" style="background-color:#f6f6f6">
	<div class="col-lg-8" id = "institutePaymentSuspensionMessage"></div>
		<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
		<a class="btn btn-success updateInstitutePaymentSuspensionStatus" type="button" id="updateInstitutePaymentSuspensionStatus" name="updateInstitutePaymentSuspensionStatus">Suspend</a>
	</div>
</form>

<script>
$(document).ready(function(){
	$('.updateInstitutePaymentSuspensionStatus').click(function(event){
		event.preventDefault();
		//row_id=$('#row_id').val();
		//var row_id = $(this).attr("id");
		row_id2=$('#rowId2').val();
		remarks2=$('#remarksInst').val();
		if(remarks2 == '' || remarks2 == null)
		{
			alert('Remarks are mandatory for payment suspension');
		}
		//alert(row_id);
		else
		{
			$.ajax
			({		
				type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
				data: {'row_id2':row_id2, 'remarks2':remarks2}, // our data object
				url: '../partials/ajax/institutePaymentSuspend.php', // the url where we want to POST			
				encode: true,
				beforeSend: function() 
				{		
					$("#updateInstitutePaymentSuspensionStatus").attr("disabled", true);
					$("#updateInstitutePaymentSuspensionStatus").text('Please wait...');
				},
				success:function(data) {
				var reply = data.replace(/\s+/, "");
				$("#updateInstitutePaymentSuspensionStatus").attr("disabled", false);
				//$(".institutePaymentSuspend").prop("disabled", true);
				$("#"+row_id2).attr("disabled", true);
				$("#updateInstitutePaymentSuspensionStatus").text('Suspend');
				if(reply == 'Success')
				{
					$("#institutePaymentSuspensionMessage").html("<b><font color='green'>Forwarded to finance for Payment suspension</font></b>");
					
				}
				setTimeout(function()
				{
					$('#remarks2').modal('hide');
					$('#remarksInst').val('');
					$("#institutePaymentSuspensionMessage").html("");
					location.reload();
					
				},2000);
			}
			});
		}
	});
	
	$('.paymentSuspend').click(function(event){
		//$('#rowId').val($('#row_id').val());
		//row_id=$('#row_id').val();
		var row_id = $(this).attr("id");
		$('#rowId').val(row_id);
		$(".remarks1").modal("show");
		//alert(row_id);
    });
	
	$('.institutePaymentSuspend').click(function(event){
		//$('#rowId').val($('#row_id').val());
		//row_id=$('#row_id').val();
		var row_id2 = $(this).attr("id");
		$('#rowId2').val(row_id2);
		$(".remarks2").modal("show");
		//alert(row_id);
    });

	/* $('.updateStudentPaymentSuspensionStatus2').click(function(event){
		event.preventDefault();
		studentRowId=$('#studentRowId').val();
		$.ajax
		({		
			type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
			data: {'studentRowId':studentRowId}, // our data object
			url: '../partials/ajax/paymentSuspend.php', // the url where we want to POST			
			encode: true,
			beforeSend: function() 
			{		
				$("#updateStudentPaymentSuspensionStatus2").attr("disabled", true);
				$(".updateStudentPaymentSuspensionStatus2").text('Please wait...');
			},
			success:function(data) {
			var reply = data.replace(/\s+/, "");
			$("#updateStudentPaymentSuspensionStatus2").attr("disabled", false);
			$(".updateStudentPaymentSuspensionStatus2").text('Confirm');
			if(reply == 'Success')
			{
				$("#PaymentSuspensionMessage").html("<b><font color='green'>Forwarded to finance for Payment suspension</font></b>");
				$(".paymentSuspend").prop("disabled", true);
				//location.reload();
			}
			setTimeout(function()
			{
				location.reload();
				
				
			},2000);
		}
		});
	});
	$('.updateInstitutePaymentSuspensionStatus1').click(function(event){
		event.preventDefault();
		instituteRowId2=$('#instituteRowId2').val();
		$.ajax
		({		
			type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
			data: {'instituteRowId2':instituteRowId2}, // our data object
			url: '../partials/ajax/institutePaymentSuspend.php', // the url where we want to POST			
			encode: true,
			beforeSend: function() 
			{		
				$("#updateInstitutePaymentSuspensionStatus1").attr("disabled", true);
				$(".updateInstitutePaymentSuspensionStatus1").text('Please wait...');
			},
			success:function(data) {
			var reply = data.replace(/\s+/, "");
			$("#updateInstitutePaymentSuspensionStatus1").attr("disabled", false);
			$(".institutePaymentSuspend").prop("disabled", true);
			$(".updateInstitutePaymentSuspensionStatus1").text('Confirm');
			if(reply == 'Success')
			{
				$("#PaymentSuspensionMessage").html("<b><font color='green'>Forwarded to finance for Payment suspension</font></b>");
				$(".institutePaymentSuspend").prop("disabled", true);
				//location.reload();
			}
			setTimeout(function()
			{
				location.reload();
				
			},2000);
		}
		});
	});	 */
});
</script>  