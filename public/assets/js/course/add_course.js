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


const dropZone = document.querySelector('#drop-zone');
const inputFile = document.querySelector('#file-input');
const previewContainer = document.querySelector('#uploaded_image');

function handleFile(file) {
const isImage = file.type.startsWith("image/");
const isSizeValid = file.size <= 2 * 1024 * 1024; // 2MB

if (!isImage) {
    alert("Only image files are allowed.");
    return;
}

if (!isSizeValid) {
    alert("File size exceeds 2MB limit.");
    return;
}

const fileURL = URL.createObjectURL(file);
previewContainer.innerHTML = `
    <div>
    <img src="${fileURL}" class="uploaded-image mb-2" style="max-width: 100%; max-height: 200px; object-fit: contain;" />
    <p class="mt-2">${file.name}</p>
    </div>
`;
}

// Click upload
inputFile.addEventListener("change", (e) => {
if (e.target.files[0]) {
    handleFile(e.target.files[0]);
}
});

// Drag and drop
dropZone.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropZone.classList.add("border-primary");
});

dropZone.addEventListener("dragleave", () => {
    dropZone.classList.remove("border-primary");
});

dropZone.addEventListener("drop", (e) => {
    e.preventDefault();
    dropZone.classList.remove("border-primary");
    const file = e.dataTransfer.files[0];
    if (file) 
        handleFile(file);
});
