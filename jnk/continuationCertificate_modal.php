<?php
die('<b> Tab is closed </b>');
include('db_connect.php');
$studentId  = htmlspecialchars($_GET['studentId']);

$query = "select * from students where studentUniqueId=?";
$stmt1 = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt1, 'i', $studentId);
mysqli_stmt_execute($stmt1);
$result = mysqli_stmt_get_result($stmt1);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel" align="center"><b>Continuation Certificate</b></h4>
</div>
<div class="modal-body">
    <div class="col-12">
        <?php if ($row['continuationCertificate'] != null && $row['continuationCertificate'] != '') {
            $imageFileType = pathinfo($row['continuationCertificate'], PATHINFO_EXTENSION);
            if ($imageFileType == 'pdf' || $imageFileType == 'PDF' || $imageFileType == 'Pdf') { ?>
                <object height='400' data='../jk_media/<?php echo $row["continuationCertificate"] ?>' type='application/pdf' width='100%' ></object><br>
            <?php } else { ?>
                <img src='../jk_media/<?php echo $row["continuationCertificate"] ?>' style="width: 100%;"><br>
            <?php }
            } else { ?>
            <form id="continuationCertificate" class="form-horizontal" onsubmit="return validateMyForm();" enctype="multipart/form-data" role="form" method="post">
                <table class="table table-bordered f11">
                    <tr>
                        <td colspan="3" align="left" class="danger"><b>Continuation Certificate:</b></td>
                    </tr>
                    <tr>
                        <td align="left" colspan="1"><b>Continuation Certificate Attachment:</b></td>
                        <td align="left" colspan="2">
                            <div class="input-group">
                                <input type="text" class="form-control" name="continuationCertificatesubfile" onchange="Validatefile('#continuationCertificatesubfile')" id="continuationCertificatesubfile" placeholder="Continuation Certificate" disabled>
                                <span class="input-group-btn"><button class="btn btn-primary" type="button" id="continuationCertificatesubfileBtn" onclick="$('#continuationCertificatepdffile').click();">Browse</button></span>
                            </div>
                        </td>

                        <!-- hidden inputs test keep above submit button -->
                        <input type="hidden" name="studentUniqueId" id="studentUniqueId" value="<?php echo $row['studentUniqueId']; ?>">
                        <input type="file" name="continuationCertificate" style="visibility:hidden;" id="continuationCertificatepdffile" />
                    </tr>
                    <tr>
                        <td colspan="4">
                            <button class="btn btn-success btn-block" id="continuationCertificateSubmit">Submit</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div id='verifiedMessage'></div>
                        </td>
                    </tr>
                </table>

            </form>

        <?php } ?>
    </div>
</div>
<?php mysqli_close($con); ?>

<script>
    $('#continuationCertificatepdffile').change(function() {
        Validatefile('#continuationCertificatepdffile');
        $('#continuationCertificatesubfile').val($(this).val());
    });

    function Validatefile(btnid) {
        //alert(btnid);
        var file = document.querySelector(btnid);
        var filedata = file.files[0].name;

        var y = filedata.split("."); // here i want check how many extention use in file if there is greater then one extention then its not valid file
        if (y.length <= 2) {
            if (/\.(jpe?g|png|pdf)$/i.test(file.files[0].name) === false) //here i am checking the extention of file
            {
                alert("Please upload only image!");
                //  var c2='#joiningtutionhostelReceiptpdffile';
                $(btnid).val('');
                return false;
            } else {
                var yoo = (y[(y.length) - 1]);
                // alert("Your file extention is "+yoo);
            }
        } else {
            alert("Please upload valid files.!");
            $(btnid).val('');
            return false;
        }
    }
</script>  