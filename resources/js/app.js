document.addEventListener('DOMContentLoaded', function () {
    let form = document.getElementById('check_answer');

    form.addEventListener('submit', function (event_submit) {
        event_submit.preventDefault();

        var xhr = new XMLHttpRequest();
        var body = new FormData(form);
        var meta = document.getElementById('meta').getAttribute('content');
        xhr.open(form.getAttribute('method'), form.getAttribute('action'), true);

        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.setRequestHeader( 'X-CSRF-TOKEN', meta);

        xhr.onreadystatechange = function () {
            var done = this.readyState === XMLHttpRequest.DONE;
            if (done && this.status === 200) {
                var respone = JSON.parse(this.response);
                document.getElementById('decision').classList.add('hidden');
                if (respone.success) {
                    document.getElementById('decision_success').classList.remove('hidden');
                } else  {
                    document.getElementById('decision_error').classList.remove('hidden');
                }
            }
            if (done && this.status === 422) {
                document.getElementById('decision_error').classList.remove('hidden');
            }
        };

        xhr.send(body);
    });
});
