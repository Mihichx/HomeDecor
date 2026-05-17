document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('submit', async (e) => {
        const form = e.target;
        if (form.hasAttribute('data-no-ajax')) return;

        e.preventDefault();

        // Автоматическое создание/поиск контейнера статуса
        let statusBox = form.querySelector('.form-status');
        if (!statusBox) {
            statusBox = document.createElement('div');
            statusBox.className = 'form-status';
            form.prepend(statusBox);
        }

        const formData = new FormData(form);
        const submitButton = e.submitter;
        if (submitButton && submitButton.name) {
            formData.append(submitButton.name, submitButton.value || '1');
        }

        try {
            statusBox.innerHTML = '<p style="color: gray;">Загрузка...</p>';

            const response = await fetch(window.location.href, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            const result = await response.json();

            // Если промокод успешный и вернул множитель скидки
            if (result.data && result.data.discount_multiplier) {
                location.reload();
                return; 
            }

            // Если сервер прислал инструкцию к редиректу
            if (result.redirect) {
                window.location.href = result.redirect;
                return;
            }

            // Вывод сообщения (если это была ошибка ввода промокода или другая форма)
            statusBox.innerHTML = `<p style="color: ${result.color || 'red'};">${result.status}</p>`;

            if (result.color === 'green') {
                form.reset();
            }

        } catch (err) {
            console.error('Ошибка AJAX:', err);
            statusBox.innerHTML = '<p style="color: red;">Ошибка на стороне сервера</p>';
        }
    });
});
