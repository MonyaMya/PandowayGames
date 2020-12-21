export const DragAndDrop = {
    getFormData(form) {
        return new FormData(form);
    },
    send(request, form) {
        fetch(request)
            .then(function (response) {
                if (response.ok) {
                    return response.json();
                }
            })
            .then(function (data) {
                let container = document.getElementById('block-message-forms');
                let content = '';

                for (const key in data) {
                    if (key === "errorsList") {
                        content += `<div class="container container-error"><ul>`;
                        for (const errorKey in data[key]) {
                            content += `<li>${data[key][errorKey]}</li>`;

                        }
                        content += `</ul></div>`;
                    } else if (key === "message") {
                        content += `<div class="container container-success">`;
                        content += `<p>${data[key]}</p>`;
                        content += `</div>`;
                    }
                }

                container.innerHTML = content;

                if (data['status'] === 'success') {
                    form.reset();
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    },
    submit() {
        const btnForm = document.getElementById('form_contact_submit');
        btnForm.addEventListener('click', function (event) {
            event.preventDefault()
            const form = event.target.closest('form');
            let data = Form.getFormData(form);
            let formErrors = 0;

            for (let i = 0; i < form.querySelectorAll('input').length - 1; i++) {
                if (form.querySelectorAll('input')[i].value.length === 0) {
                    formErrors += 1;
                }
            }

            if (formErrors === 0) {
                let request = new Request(
                    form.action,
                    {
                        method: 'POST',
                        body: data,
                        headers: new Headers({
                            'X-Requested-With': 'XMLHttpRequest'
                        })
                    }
                );

                Form.send(request, form);
            } else {
                let container = document.getElementById('block-message-forms');
                let content = '';

                content += `<div class="container container-error"><ul>`;
                for (let i = 0; i < form.querySelectorAll('input').length - 1; i++) {
                    if (form.querySelectorAll('input')[i].value.length === 0) {
                        content += `<li>Le champ ${form.querySelectorAll('input')[i].name} ne doit pas être vide</li>`;
                    }
                }

                content += `</ul></div>`;
                container.innerHTML = content;
            }
        })
    }
}
