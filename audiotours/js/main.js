
/**
 * Lee un iput de tipo file ,e inserta la imagen en una etiqueta img que esté en esa página
 * y si es mp3 inserta una nueva imagen en el div
 * @param {*} input 
 */
function fileImageValidation(){
    var fileInput = document.getElementById('file');
    var filePath = fileInput.value;
    var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
        fileInput.value = '';
        return false;
    }else{
        //Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('divImageFile').innerHTML = '<img src="'+e.target.result+'"/>';
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}


function readImage(input, url) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var divError=document.getElementById("divError");
        reader.onload = function (e) {
            var result=e.target.result;
            var extension=input.files[0].name.split('.').pop();
            var allowedExtensions = "/(.jpg|.jpeg|.png|.gif)$/i";
            if(extension=="jpg" || extension=="jpeg" || extension=="png" || extension=="gif"){
                $('#imageFile').attr('src', result);
                divError.innerHTML="";
            }
            else{
                var divImageFile=document.getElementById("divImageFile");
                divImageFile.innerHTML="<img src='"+url+"media/prohibited.png' name='imageFile' id='imageFile' width='200px'></img>";
                divError.innerHTML="<p>Only image files type.</p>";
                $('#imageFile').attr('src', "");
                //$('#imageFile').attr('src', null);
            }
        };
        /*reader.onloadend=function(){
            var preview=document.querySelector('imageFile');
            preview.src = reader.result;
        }*/
        reader.readAsDataURL(input.files[0]);
    }
    return permitido;
}

function setOnImageFilePictureBlanck(url){
    $('#imageFile').attr('src', url+"media/the-selected-image.png");
}


function readAudio(input, url) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var divError=document.getElementById("divError");
        var imageMp3=document.getElementById("imageMp3");
        reader.onload = function (e) {
            var result=e.target.result;
            var extension=input.files[0].name.split('.').pop();
            if(extension=="mp3"){
                $('#audioMp3').attr('src', result);
                divError.innerHTML="";
                //imageMp3.hidden=false;
            }else{
                var divAudioFile=document.getElementById("divAudioFile");
                divAudioFile.innerHTML="<img src='"+url+"media/prohibited.png' name='imageFile' id='imageFile' width='200px'></img>";
                divError.innerHTML="<p>Only audios files type.</p>";
                $('#audioMp3').attr('src', "");
                //imageMp3.hidden=true;
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

