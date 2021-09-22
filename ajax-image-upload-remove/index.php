<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #alert {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            margin: 0 auto;
        }
        #preview img{
            height: 100%;
            width: 100%;
        }
    </style>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <header>
        <div class="container">
            <div class="row justify-content-center bg-warning">
                <div class="col-md-6">
                    <h3>IMAGE UPLOAD AND REMOVE</h3>
                </div>
            </div>
            <div class="row mt-2 bg-dark text-white p-5">
                <div class="col-md-4">
                    <form id="submitForm">
                        <div class="form-group">
                            <label>Uploade Image:</label>
                            <input type="file" name="file" class="p-1 form-control" id="uploadFile">
                            <p class="text-info">Image should be only png, jpg, jpeg or gif</p>
                        </div>
                        <input type="submit" value="Upload" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 my-2">
                    <div id="preview" class="border border-dark rounded p-2 d-none">
                        <h4>Image Preview</h4>
                        <div class="mt-2" id="image-preview">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="modal fade" id="confirmModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    Are You Sure You Want To Delete This Pic?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="alert fade" id="alert" role="alert">
        <span id="inner-message"></span>
    </div>



    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {

            function showMessage(message, bootclass) {
                $(".alert").removeClass("fade").addClass(bootclass).slideDown("slow");
                $("#inner-message").html(message)
                setTimeout(function () {
                    $(".alert").slideUp("slow").addClass("fade").removeClass("alert-danger alert-success alert-warning");
                }, 3000)
            }

            $("#submitForm").on("submit", function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                $.ajax({
                    url: "upload-delete-pic.php",
                    type: "POST",
                    data: formData,
                    contentType: false, // or multipart/form-data
                    processData: false, // by default value is true and true means data in obj or string
                    success: function(data) {
                        if (data == 0) {
                            showMessage("Please Select file", "alert-danger")
                            // $(".alert").removeClass("fade").addClass("alert-danger");
                            // $("#inner-message").html("Please Select file");
                            // setTimeout(function() {
                            //     $(".alert").addClass("fade").removeClass("alert-danger alert-success alert-warning");
                            //     $("#inner-message").html("");
                            // }, 3000)
                        } else if (data == 1) {
                            showMessage("Invalid File Format.", "alert-danger")
                            // $(".alert").removeClass("fade").addClass("alert-danger");
                            // $("#inner-message").html("Invalid File Format.");
                            // setTimeout(function() {
                            //     $(".alert").addClass("fade").removeClass("alert-danger alert-success alert-warning");
                            //     $("#inner-message").html("");
                            // }, 3000)
                        } else {
                            showMessage("Upload Done.", "alert-success")
                            $("#preview").removeClass("d-none");
                            $("#image-preview").html(data);
                            $("#uploadFile").val("");
                        }

                    }
                })
            })

            $(document).on("click","#delete-btn", function(){
                $("#confirmModal").modal("show");
            })
            $("#confirm-delete").on("click",function(){
                var path = $("#delete-btn").data("path");
                $.ajax({
                    url : "upload-delete-pic.php",
                    type : "POST",
                    data : {path : path},
                    success : function(data){
                        $("#confirmModal").modal("hide");
                        if(data == 1){
                            showMessage("Image Deleted.!", "alert-warning")
                            $("#preview").addClass("d-none");
                            $("#image-preview").html("");
                        }else{

                        }
                    }
                })
            })

        })
    </script>
</body>

</html>