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
const deleteBtn = document.querySelector('#delete-image-btn');
const deleteInput = document.querySelector('#delete_image');

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
        <p class="mt-2 text-center">${file.name}</p>
        </div>
    `;
    deleteInput.value = 0;
}

if (deleteBtn) {
    deleteBtn.addEventListener('click', function () {
        if (confirm('Are you sure you want to delete this image?')) {
            previewContainer.innerHTML = `
                <i class="fa-solid fa-cloud-arrow-up me-2 fs-1 mb-3 text-secondary"></i>
                <span class="fs-5">1920x1080 thumbnail size</span>
                <span class="fs-6 text-secondary text-center ms-3 me-3">JPEG, PNG or any image formats, up to 2MB</span>
                <span class="btn btn-lg btn-secondary mt-4">Choose an image</span>
            `;
            deleteInput.value = 1;
        }
    });
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
