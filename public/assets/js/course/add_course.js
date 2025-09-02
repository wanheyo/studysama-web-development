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
$(document).ready(function () {
    $('.category-select').select2();

    let hideSuggestionsTimeout;
    const $courseInput = $('#course_title');
    const $suggestionBox = $('#course_suggestions');
    const $warning = $('#course_exists_warning');

    // 🛠 Helper: Hide warning
    function hideWarning() {
        $warning.hide().text('');
    }

    // 🛠 Helper: Render suggestions
    function renderSuggestions(data) {
        $suggestionBox.empty();
        data.forEach(course => {
            $suggestionBox.append(`<li class="list-group-item">${course.name}</li>`);
        });

        // Auto-hide suggestions if user stops typing
        clearTimeout(hideSuggestionsTimeout);
        hideSuggestionsTimeout = setTimeout(() => {
            $suggestionBox.empty();
        }, 1500);
    }

    // 🛠 Helper: Check exact match + show warning if exists
    function checkExactMatch(data, inputVal) {
        let exactMatch = data.find(c => c.name.toLowerCase() === inputVal.toLowerCase());
        if (exactMatch) {
            let tutorNames = exactMatch.tutors.map(t => t.username).join(', ');
            $warning
                .text(`⚠️ This course name already exists! Created by ${tutorNames}, You might want to choose a different name.`)
                .show();
        } else {
            hideWarning();
        }
    }

    // 🔎 Search on typing
    $courseInput.on('keyup', function () {
        let query = $(this).val().trim();

        if (!query) {
            $suggestionBox.empty();
            hideWarning();
            return;
        }

        if (query.length > 2) {
            $.ajax({
                url: courseSearchUrl,
                type: "GET",
                data: { q: query },
                success: function (data) {
                    console.log("AJAX response:", data);

                    if (data.length > 0) {
                        renderSuggestions(data);
                        checkExactMatch(data, query);
                    } else {
                        hideWarning();
                    }
                }
            });
        } else {
            $suggestionBox.empty();
            hideWarning();
        }
    });

    // 🖱️ Click on suggestion
    $(document).on('click', '#course_suggestions li', function () {
        let selectedName = $(this).text();
        $courseInput.val(selectedName);
        $suggestionBox.empty();

        // Check match again
        $.ajax({
            url: courseSearchUrl,
            type: "GET",
            data: { q: selectedName },
            success: function (data) {
                checkExactMatch(data, selectedName);
            }
        });
    });
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
const agreeCheck = document.querySelector('#agree_check');

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
