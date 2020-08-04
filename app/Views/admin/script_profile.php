<script>
    var base_url="<?=site_url()?>";
    $(document).ready(function(){
        var $imageinput = $('#profilephoto');

        $imageinput.on("change",function(){
            $image = $('#image');
            // if(!Validate("image")){
            //     return false;
            // }
            var file = $(this)[0].files[0];
            $image.attr("src",window.URL.createObjectURL(file));
            $image.cropper({
                aspectRatio: 1/1,
                viewMode: 2
            });
            var cropper = $image.data('cropper');
            $("#validate").on("click",function(){
                cropper.crop();
                cropper.getCroppedCanvas().toBlob((blob) => {
                    const formData = new FormData();

                    // Pass the image file name as the third parameter if necessary.
                    formData.append('croppedImage', blob/*, 'example.png' */);

                    // Use `jQuery.ajax` method for example
                    $.ajax('<?=site_url("admin/ajax/updateprofilepicture")?>', {
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success(response) {
                            var result = JSON.parse(response);
                            if(result.status){
                                $(".cropper-container").remove();
                                $("img#image").attr("src",base_url+"/uploads/images/"+result.filename);
                                $("img#image").removeClass("cropper-hidden");
                                $("#profile-avatar").attr("src",base_url+"/uploads/images/"+result.filename);
                            }else{
                                alert(result.message);
                            }
                        },
                        error() {
                            console.log('Une érreur est survenue, veuillez recharger la page');
                        },
                    });
                }/*, 'image/png' */);
                return false;
            });
            
        });
    });
    // var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];    
    // function Validate(fileinput) {
    //         var oInput = document.getElementById(fileinput);
    //         if (oInput.type == "file") {
    //             var sFileName = oInput.value;
    //             if (sFileName.length > 0) {
    //                 var blnValid = false;
    //                 for (var j = 0; j < _validFileExtensions.length; j++) {
    //                     var sCurExtension = _validFileExtensions[j];
    //                     if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
    //                         blnValid = true;
    //                         break;
    //                     }
    //                 }
                    
    //                 if (!blnValid) {
    //                     alert("Desolé, " + sFileName + " est non valide, les formats autorisés sont: " + _validFileExtensions.join(", "));
    //                     return false;
    //                 }
    //             }
    //         }
    // return true;
// }
</script>