require('./bootstrap');

document.addEventListener('DOMContentLoaded', function () {
    // let form = document.getElementById('check_answer');
    // form.addEventListener('submit', function (event_submit) {
    //     event_submit.preventDefault();
    //
    //     var xhr = new XMLHttpRequest();
    //     var body = new FormData(form);
    //     var meta = document.getElementById('meta').getAttribute('content');
    //     xhr.open(form.getAttribute('method'), form.getAttribute('action'), true);
    //
    //     xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    //     xhr.setRequestHeader('X-CSRF-TOKEN', meta);
    //
    //     xhr.onreadystatechange = function () {
    //         var done = this.readyState === XMLHttpRequest.DONE;
    //         if (done && this.status === 200) {
    //             var respone = JSON.parse(this.response);
    //             document.getElementById('decision').classList.add('hidden');
    //             if (respone.success) {
    //                 document.getElementById('decision_success').classList.remove('hidden');
    //             } else {
    //                 document.getElementById('decision_error').classList.remove('hidden');
    //             }
    //         }
    //         if (done && this.status === 422) {
    //             document.getElementById('decision_error').classList.remove('hidden');
    //         }
    //     };
    //
    //     xhr.send(body);
    // });

    // $('#check_answer').submit(function (event) {
    //     event.preventDefault();
    // });

    $('.fancybox-selector').fancybox({
        keyboard: true,
        smallBtn: true,
        toolbar: true,
        buttons: [
            "zoom",
            "fullScreen",
            "download",
            "close"
        ],
        btnTpl: {
            download:
                '<a download data-fancybox-download class="fancybox-button fancybox-button--download" title="{{DOWNLOAD}}" href="javascript:;">' +
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.62 17.09V19H5.38v-1.91zm-2.97-6.96L17 11.45l-5 4.87-5-4.87 1.36-1.32 2.68 2.64V5h1.92v7.77z"/></svg>' +
                "</a>",

            zoom:
                '<button data-fancybox-zoom class="fancybox-button fancybox-button--zoom" title="{{ZOOM}}">' +
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.7 17.3l-3-3a5.9 5.9 0 0 0-.6-7.6 5.9 5.9 0 0 0-8.4 0 5.9 5.9 0 0 0 0 8.4 5.9 5.9 0 0 0 7.7.7l3 3a1 1 0 0 0 1.3 0c.4-.5.4-1 0-1.5zM8.1 13.8a4 4 0 0 1 0-5.7 4 4 0 0 1 5.7 0 4 4 0 0 1 0 5.7 4 4 0 0 1-5.7 0z"/></svg>' +
                "</button>",
        },
    });

    $('.table tr').filter(function() {
        return $.trim($(this).text()) === '';
    }).hide();
});

// FB.getLoginStatus(function(response) {
//     statusChangeCallback(response);
// });
