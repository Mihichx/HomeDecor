document.addEventListener('click', (e) => {
    // 1. Проверяем клик по кнопкам + или -
    if (!e.target.classList.contains('btn-quantity')) return;

    const cartItem = e.target.closest('.cart-item');
    const input = cartItem.querySelector('.quantity-input');
    const priceOne = parseFloat(cartItem.querySelector('.price-one').textContent); // Цена за 1 шт
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

    // 3. Отправляем новое количество на сервер
    const formData = new FormData();
    formData.append('set_quantity', '1');
    formData.append('id', productId);
    formData.append('quantity', currentQty);

    fetch(window.location.href, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
    });

    // 4. Интерактив на клиенте (срабатывает мгновенно)
    if (currentQty <= 0) {
        // Эффект плавного удаления карточки
        cartItem.style.opacity = '0';
        cartItem.style.transform = 'scale(0.9)';
        cartItem.style.transition = 'all 0.3s ease';
        setTimeout(() => {
            cartItem.remove();
            updateCartTotal(); // Пересчитываем общее "Итого" и штуки
        }, 300);
    } else {
        input.value = currentQty;
        totalBlock.textContent = (priceOne * currentQty) + ' руб.'; // Меняем цену строки
        updateCartTotal(); // Пересчитываем общее "Итого" и штуки
    }
});

// Функция, которая пересчитывает суммы и общее количество штук на экране
function updateCartTotal() {
    let finalPrice = 0;
    let finalQty = 0;

    // Считаем общую стоимость, складывая блоки .item-total
    document.querySelectorAll('.item-total').forEach(item => {
        finalPrice += parseFloat(item.textContent) || 0;
    });
    
    // Считаем общее количество товаров, складывая значения всех инпутов .quantity-input
    document.querySelectorAll('.quantity-input').forEach(input => {
        finalQty += parseInt(input.value) || 0;
    });
    
    // Обновляем блок с итоговой ценой
    const finalBlock = document.querySelector('.total-sum');
    if (finalBlock) {
        finalBlock.textContent = finalPrice + ' руб.';
    }

    // Обновляем блоки с общим количеством товаров (например, в шапке или блоке заказа)
    // Поддерживает обновление сразу нескольких блоков на странице с классом .items-count
    document.querySelectorAll('.items-count').forEach(el => {
        el.textContent ='В корзине ' + finalQty + ' товар(ов)';
    });
}
