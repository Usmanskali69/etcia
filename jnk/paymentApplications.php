<?php 
session_start(); 
$session_utility	=	isset($_SESSION["utility"])?$_SESSION["utility"]:false;
if($session_utility!==true) {
 header('Location: utility.php');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
        <META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="MARUDHAR/KANCHAN">

		<title></title>

		<!-- Bootstrap Core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- Bootstrap Table CSS -->
		<link href="css/bootstrap-table.min.css" rel="stylesheet" >
		
		<!-- Bootstrap Date Picker CSS -->
		<!--<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">-->
		
		<!-- Custom Fonts -->
		<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<link href="css/style.css" rel="stylesheet" type="text/css">
		 <style>
		 #applicationslogin .modal-backdrop
{
    opacity:0.8!important;
}

</style>
<style>
		#studentModal .modal-dialog {
  width: 90%;
  height: 100%;
  padding: 0;
}

$studentModal .modal-content {
  height: auto;
  min-height: 100%;
  border-radius: 0;
}


		</style>
	</head>
<body style="padding-top: 10px;">
	<div class="container-fluid">
					<h3 align="center">  Export Student Details with Payment Details</h3><br>
					<div class="pull-right" style="margin-top:35px;margin-right:20px;"><button  class="btn btn-primary btn-xs" onclick="tablesToExcel(['tbl1','tbl2','tbl4','tbl3'], ['Basic Details','Student Payment Details','Student Payment Details (2019-20)','Institute Payment Details'], 'Report.xls', 'Excel')">Export <span class="glyphicon glyphicon glyphicon-log-out" aria-hidden="true"></span></button></div>
					<div class="container-fluid" id="tableContent">
 <ul class="nav nav-tabs" style="margin-top:20px;">
				<li class="active"><a href="#student" data-toggle="tab">Student Details</a><li>
				<li ><a href="#payment" data-toggle="tab">Student Payment Details</a><li>			
				<li ><a href="#payment1920" data-toggle="tab">Student Payment Details (2019-20)</a><li>			
				<li ><a href="#institutePayment" data-toggle="tab">Institute Payment Details</a><li>			
			</ul>
	<div class="tab-content" style="border:1px solid #E0E0E0;">
				<div class="tab-pane active" id="student">
	<font size="1"><b>
	 <table id="tbl1" class="table2excel" data-height="460" data-toggle="table" data-url="operations/export/showSubmittedTable.php" data-pagination="true" data-search="true" data-sort-name="isStudentVerified" data-sort-order="asc" data-show-refresh="true" data-page-list="[5, 10, 20, 50, 100, ALL]">
	
		<thead class="btn-primary" >
			
						<th data-field="studentUniqueId" data-sortable="true">Candidate ID</th>
						<th data-field="name">Name</th>
						<th data-field="studentRank" data-visible="false">Rank</th>
						<th data-field="fatherName" data-visible="false">Name of the Father/Guardian</th>					
						<th data-field="gender" data-visible="false">Gender</th>					
						<th data-field="casteCategory">Caste Cateogory</th>
						<th data-field="yearOfCounselling">Counselling Year</th>
						<th data-field="modeOfAdmission">Mode of Admission</th>
						<th data-field="applicationStatus">Application Status</th>
						<th data-field="CurrentSemester">Current Semester</th>
						<th data-field="DBTApplicationStatus">DBTApplicationStatus</th>
						<th data-field="collegeId">College Id</th>
						<th data-field="CollegeName">College Name</th>
						<th data-field="address">Address</th>
						<th data-field="district">District</th>
						<th data-field="city">City</th>
						<th data-field="state">State</th>
						<th data-field="stream">Stream</th>
						

					
		</thead>
	</table>
	</font></b>
	</div>
				<div class="tab-pane " id="payment">
  <font size="1"><b>
	 <table id="tbl2" class="table2excel" data-height="430" data-toggle="table" data-url="operations/export/showSubmittedPaymentTable.php?type=old" data-pagination="true" data-search="true" data-sort-name="isStudentVerified" data-sort-order="asc" data-show-refresh="true" data-page-list="[5, 10, 20, 50, 100, ALL]">
	
		<thead class="btn-primary" >
			
						<th data-field="studentUniqueId" data-sortable="true">Candidate ID</th>
						<th data-field="name">Name</th>						
						<th data-field="gender">Gender</th>						
						<th data-field="casteCategory">Caste</th>						
						<th data-field="yearOfCounselling">Batch</th>
						<th data-field="title">Level</th>
						<th data-field="appliedSemester">Applied Semester</th>
						<th data-field="collegeId">College Id</th>
						<th data-field="CollegeName">College Name</th>
						<th data-field="address">Address</th>
						<th data-field="district">District</th>
						<th data-field="city">City</th>
						<th data-field="state">State</th>
						<th data-field="stream">Stream</th>
						<th data-field="fee">Maintanance Fee</th>
						<th data-field="status">Payment Status</th>
						<th data-field="comments">Comments</th>
						<th data-field="paymentInitiated">Payment Initiated Date</th>
						<th data-field="paymentDate">Payment Date</th>
		</thead>
	</table>
	</font></b>
</div>
<div class="tab-pane " id="payment1920">
  <font size="1"><b>
	 <table id="tbl4" class="table2excel" data-height="430" data-toggle="table" data-url="operations/export/showSubmittedPaymentTable.php?type=new" data-pagination="true" data-search="true" data-sort-name="isStudentVerified" data-sort-order="asc" data-show-refresh="true" data-page-list="[5, 10, 20, 50, 100, ALL]">
	
		<thead class="btn-primary" >
			
						<th data-field="studentUniqueId" data-sortable="true">Candidate ID</th>
						<th data-field="name">Name</th>						
						<th data-field="gender">Gender</th>						
						<th data-field="casteCategory">Caste</th>						
						<th data-field="yearOfCounselling">Batch</th>
						<th data-field="title">Level</th>
						<th data-field="appliedSemester">Applied Semester</th>
						<th data-field="collegeId">College Id</th>
						<th data-field="CollegeName">College Name</th>
						<th data-field="address">Address</th>
						<th data-field="district">District</th>
						<th data-field="city">City</th>
						<th data-field="state">State</th>
						<th data-field="stream">Stream</th>
						<th data-field="fee">Maintanance Fee</th>
						<th data-field="status">Payment Status</th>
						<th data-field="comments">Comments</th>
						<th data-field="paymentInitiated">Payment Initiated Date</th>
						<th data-field="paymentDate">Payment Date</th>
		</thead>
	</table>
	</font></b>
</div>
<div class="tab-pane " id="institutePayment">
  <font size="1"><b>
	 <table id="tbl3" class="table2excel" data-height="430" data-toggle="table" data-url="operations/export/showSubmittedInstitutePaymentTable.php" data-pagination="true" data-search="true" data-sort-name="isStudentVerified" data-sort-order="asc" data-show-refresh="true" data-page-list="[5, 10, 20, 50, 100, ALL]">
	
		<thead class="btn-primary" >
			
						<th data-field="studentUniqueId" data-sortable="true">Candidate ID</th>
						<th data-field="name">Name</th>	
                        <th data-field="gender">Gender</th>
                        <th data-field="casteCategory">Caste</th>						
                        <th data-field="title">Level</th>                      				
						<th data-field="yearOfStudy">Year of Study</th>
						<th data-field="academicYear">Academic Year</th>
						<th data-field="collegeId">College Id</th>
						<th data-field="CollegeName">College Name</th>
						<th data-field="address">Address</th>
						<th data-field="district">District</th>
						<th data-field="city">City</th>
						<th data-field="state">State</th>
						<th data-field="stream">Stream</th>
						<th data-field="fee">Tution Fee</th>
						<th data-field="status">Payment Status</th>
						<th data-field="comments">Comments</th>
						<th data-field="paymentInitiated">Payment Initiated Date</th>
                        <th data-field="paymentDate">Payment Date</th>					
		</thead>
	</table>
	</font></b>
</div></div>




	</div>
</div>
 <div class="modal fade" id="applicationslogin" tabindex="-1" data-backdrop="static"  data-keyword="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 align="center">Login for official users only</h4>
            </div>
            <div class="modal-body">			
                <form id="applicationsForm">
			  <div class="modal-body">
				<div class="form-group" style="padding-left:0px;">
					<input class="form-control" name="applicationsID" id="applicationsID" placeholder="Login ID" type="text" autofocus  required="required"/>
				</div>
				<div class="form-group" >
					<input class="form-control" name="applicationsPassword" id="applicationsPassword" placeholder="Password" type="password"  required="required">
				</div>			
				<button type="submit" class="btn btn-md btn-success btn-block">Login</button>
				<div id="applicationsBox" align="center"></div>
			  </div>
		  </form>
		</div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	  
	</div>
  </div>
</div>
</body>
   <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-table.js"></script>
	<script type="text/javascript" src="js/custom/ajaxForRetrivingPublicIP.js"></script>
    <script type="text/javascript" src="DBT_HO/js/bootstrap-table.js"></script>
	<script type="text/javascript" src="operations/submittedapplications.js"></script>
	<script>
	  var tablesToExcel = (function() {	 
    var uri = 'data:application/vnd.ms-excel;base64,'
    , tmplWorkbookXML = '<?xml version="1.0"?><?mso-application progid="Excel.Sheet"?><Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">'
      + '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office"><Author>Axel Richter</Author><Created>{created}</Created></DocumentProperties>'
      + '<Styles>'
      + '<Style ss:ID="Currency"><NumberFormat ss:Format="Currency"></NumberFormat></Style>'
      + '<Style ss:ID="Date"><NumberFormat ss:Format="Medium Date"></NumberFormat></Style>'
      + '</Styles>' 
      + '{worksheets}</Workbook>'
    , tmplWorksheetXML = '<Worksheet ss:Name="{nameWS}"><Table>{rows}</Table></Worksheet>'
    , tmplCellXML = '<Cell{attributeStyleID}{attributeFormula}><Data ss:Type="{nameType}">{data}</Data></Cell>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
    return function(tables, wsnames, wbname, appname) {
      var ctx = "";
      var workbookXML = "";
      var worksheetsXML = "";
      var rowsXML = "";

      for (var i = 0; i < tables.length; i++) {
        if (!tables[i].nodeType) tables[i] = document.getElementById(tables[i]);
        for (var j = 0; j < tables[i].rows.length; j++) {
          rowsXML += '<Row>'
          for (var k = 0; k < tables[i].rows[j].cells.length; k++) {
            var dataType = tables[i].rows[j].cells[k].getAttribute("data-type");
            var dataStyle = tables[i].rows[j].cells[k].getAttribute("data-style");
            var dataValue = tables[i].rows[j].cells[k].getAttribute("data-value");
            dataValue = (dataValue)?dataValue:tables[i].rows[j].cells[k].innerHTML;
            var dataFormula = tables[i].rows[j].cells[k].getAttribute("data-formula");
            dataFormula = (dataFormula)?dataFormula:(appname=='Calc' && dataType=='DateTime')?dataValue:null;
            ctx = {  attributeStyleID: (dataStyle=='Currency' || dataStyle=='Date')?' ss:StyleID="'+dataStyle+'"':''
                   , nameType: (dataType=='Number' || dataType=='DateTime' || dataType=='Boolean' || dataType=='Error')?dataType:'String'
                   , data: (dataFormula)?'':dataValue
                   , attributeFormula: (dataFormula)?' ss:Formula="'+dataFormula+'"':''
                  };
            rowsXML += format(tmplCellXML, ctx);
          }
          rowsXML += '</Row>'
        }
        ctx = {rows: rowsXML, nameWS: wsnames[i] || 'Sheet' + i};
        worksheetsXML += format(tmplWorksheetXML, ctx);
        rowsXML = "";
      }

      ctx = {created: (new Date()).getTime(), worksheets: worksheetsXML};
      workbookXML = format(tmplWorkbookXML, ctx);

console.log(workbookXML);

      var link = document.createElement("A");
      link.href = uri + base64(workbookXML);
      link.download = wbname || 'Workbook.xls';
      link.target = '_blank';
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }
  })();
	</script>
	<script>
$(document).ready(function() 
{	
/*
	var url='http://<?php echo $_SERVER['HTTP_HOST'];?>/paymentApplications.php';
	if (url.match(/payment.*))
	{
 $('#applicationslogin').modal('show');
	}
	*/
});
 </script>
<script>
 $(document).on('hidden.bs.modal', function(e) {       
        var target = $(e.target);
        target.removeData('bs.modal')
            .find(".modal-content").html('');
    });
</script>
 
 
</html>
  