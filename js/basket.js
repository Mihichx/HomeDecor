document.addEventListener('click', async (e) => {
    // 1. Проверяем клик по кнопкам + или -
    if (!e.target.classList.contains('btn-quantity')) return;

    const cartItem = e.target.closest('.cart-item');
    const input = cartItem.querySelector('.quantity-input');
    const priceOne = parseFloat(cartItem.querySelector('.price-one').getAttribute('data-price'));
    const totalBlock = cartItem.querySelector('.item-total');
    
    let currentQty = parseInt(input.value);
    
    // Получаем ID товара: либо из data-id, либо вырезаем цифры из номера товара
    const productId = cartItem.getAttribute('data-id') || cartItem.querySelector('.item-number').textContent.replace(/[^0-9]/g, '');

    // 2. Меняем значение в зависимости от кнопки
    if (e.target.textContent === '+') {
        currentQty++;
    } else {
        currentQty--;
    }

    // 3. Собираем данные для отправки на сервер
    const formData = new FormData();
    formData.append('set_quantity', '1');
    formData.append('id', productId);
    formData.append('quantity', currentQty);

    try {
        if (currentQty <= 0) {
            // Эффект плавного удаления карточки (интерактив на клиенте)
            cartItem.style.opacity = '0';
            cartItem.style.transform = 'scale(0.9)';
            cartItem.style.transition = 'all 0.3s ease';
            
            // Отправляем запрос на сервер параллельно с анимацией
            await fetch(window.location.href, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            });

            // Ждем завершения анимации удаления (300мс) и только ПОТОМ обновляем страницу
            setTimeout(() => {
                cartItem.remove();
                updateCartTotal(); 
                location.reload(); // Перезагрузка строго после того, как сервер удалил товар из сессии
            }, 300);

        } else {
            // Мгновенно меняем цифры на экране для отзывчивости интерфейса
            input.value = currentQty;
            totalBlock.textContent = (priceOne * currentQty).toLocaleString('ru-RU') + ' руб.'; 
            updateCartTotal(); 

            // Отправляем запрос на сервер и ГАРАНТИРОВАННО ждем его выполнения
            const response = await fetch(window.location.href, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            });

            if (response.ok) {
                // Перезагружаем страницу ТОЛЬКО когда PHP ответил 'ok' и сбросил скидку
                location.reload();
            }
        }
    } catch (error) {
        console.error('Ошибка при изменении количества:', error);
    }
});

// Функция, которая пересчитывает суммы и общее количество штук на экране
function updateCartTotal() {
    let finalPrice = 0;
    let finalQty = 0;

    // 1. Считаем чистую сумму (без форматирования внутри цикла)
    document.querySelectorAll('.item-total').forEach(item => {
        // Убираем пробелы из текста, чтобы parseFloat смог прочитать число
        const cleanText = item.textContent.replace(/\s/g, '').replace(/[^0-9.]/g, '');
        finalPrice += parseFloat(cleanText) || 0;
    });
    
    // 2. Считаем общее количество штук
    document.querySelectorAll('.quantity-input').forEach(input => {
        finalQty += parseInt(input.value) || 0;
    });
    
    // 3. ПРИМЕНЯЕМ СКИДКУ (если есть скрытый тег)
    const multiplierEl = document.getElementById('active-multiplier');
    if (multiplierEl) {
        const multiplier = parseFloat(multiplierEl.getAttribute('data-multiplier')) || 1;
        finalPrice = Math.round(finalPrice * multiplier);
    }
    
    // 4. Форматируем и выводим результаты с пробелами
    const finalBlock = document.querySelector('.total-sum');
    if (finalBlock) {
        finalBlock.textContent = finalPrice.toLocaleString('ru-RU') + ' руб.';
    }

    document.querySelectorAll('.items-count').forEach(el => {
        el.textContent = 'В корзине ' + finalQty + ' товар(ов)';
    });
}
