// 1 basic editor

// editor js
$('#description-editor').trumbowyg({
    btns: [
        ['viewHTML'],
        ['undo', 'redo'], // Only supported in Blink browsers
        ['formatting'],
        ['strong', 'em', 'del'],
        ['superscript', 'subscript'],
        ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
        ['unorderedList', 'orderedList'],
        ['horizontalRule'],
        ['removeformat'],
        ['fullscreen']
    ],
});

// select js
$(document).ready(function() {
    $('.category-select').select2();
});   

// file upload js
FilePond.registerPlugin(FilePondPluginFileValidateType);
FilePond.registerPlugin(FilePondPluginImagePreview);
FilePond.registerPlugin(FilePondPluginFileEncode);
FilePond.registerPlugin(FilePondPluginFileValidateSize);
FilePond.registerPlugin(FilePondPluginImageExifOrientation);

const pondInput = FilePond.create(
    document.querySelector('#addProduct'),
    {
      labelIdle: `<i class="fa-solid fa-cloud-upload fa-fw fs-4"></i> <div class="filepond--label-action text-decoration-none">Upload Your Product Images</div>`,
    }
);

document.querySelector('#file-input').addEventListener("change",(evt)=>{
    const rawFile = evt.target.files;
    const file = rawFile[0] ? URL.createObjectURL(rawFile[0]) : null;
    if(file) {
       document.querySelector("#uploaded_image").innerHTML = `
          <div>
             <img src=${file} class="uploaded-image">
             <p>${rawFile[0].name}</p>
          </div>
       `
    }
})