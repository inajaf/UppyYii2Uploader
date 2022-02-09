const url = document.getElementById("drag-drop-area").getAttribute("data-url");
const modelID = document.getElementById("drag-drop-area").getAttribute('data-id');
const redirectUrl = document.getElementById("drag-drop-area").getAttribute('data-redirect');

const csrfValue = $("meta[name=csrf-token]").attr("content");

// Create news with images
const uppy = new Uppy.Core({
    restrictions: {
        allowedFileTypes: ['image/*', '.jpg', '.jpeg', '.png', '.svg', '.mp4'],
        maxNumberOfFiles: 15,
        autoProceed: false,
    },
})
    .use(Uppy.Dashboard, {
        attribute: 'imageFiles',
        hideUploadButton: true,
        debug: true,
        inline: true,
        target: '#drag-drop-area',
        width: 513,
        height: 416,
    })

    .use(Uppy.XHRUpload, {
        endpoint: url,
        fieldName: 'imageFiles[]',
        method: 'post',
        bundle: true,
        formData: true,
        headers: {
            'X-CSRF-Token': csrfValue,
            'modelid': modelID,
        },
    })

    .use(Uppy.Form, {
        target: '.form-horizontal',
        getMetaFromForm: true,
        method: 'post',
        addResultToForm: false,
        submitOnSuccess: false,
        triggerUploadOnSubmit: false,
    })

uppy.on('file-added', (file) => {
    $('.btn').hide();
    $('.uppy-submit').show();
})

$(".uppy-submit").click(function(e){
    $('.form-horizontal').yiiActiveForm('validate', true);
    $("form").submit(function(e){
        e.preventDefault();
    });
    $('.form-horizontal').on('beforeSubmit', function (e) {
        uppy.upload().then((result) => {
            window.location.href = redirectUrl;
        })
    });
});

