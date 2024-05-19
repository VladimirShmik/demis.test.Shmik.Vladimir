class ShopCounter {
    constructor(container) {
        this.container = container;
        this.counterMinus = container.querySelector('.counterMinus');
        this.counterPlus = container.querySelector('.counterPlus');
        this.counterInput = container.querySelector('.counterInput');
        this.shopPrice = container.querySelector('.shopPrice');
        this.basePrice = parseInt(this.shopPrice.textContent); // базовая цена товара
        this.counterMinus.addEventListener('click', this.decrement.bind(this));
        this.counterPlus.addEventListener('click', this.increment.bind(this));
    }
    // кнопка минус
    decrement() {
        let value = parseInt(this.counterInput.value);
        if (value > 1) {
            value--;
            this.counterInput.value = value;
            this.updatePrice(value);
        }
    }
    // кнопка плюс
    increment() {
        let value = parseInt(this.counterInput.value);
        if (value < 10) {
            value++;
            this.counterInput.value = value;
            this.updatePrice(value);
        }
    }
    // обновление цены от value.input
    updatePrice(value) {
        this.shopPrice.textContent = value * this.basePrice + ' p.';
    }
}
class ModalController {
    constructor() {
        this.modalFade = document.querySelector('.modal-fade');
        this.modalContent = this.modalFade.querySelector('.modal-content');
        this.modalFadeCancel = document.querySelector('.modal-header__btn');
        this.bodyOverflow = document.querySelector('body');
        this.shopModalBtns = document.querySelectorAll('.shopModalBtn');
        this.modalProductName = document.querySelector('.productName');
        this.modalProductImg = document.querySelector('.productImg');
        this.modalPriceCount = document.querySelector('.priceCount');
        this.modalPriceForUnit = document.querySelector('.priceForUnit');
        this.modalPriceTotal = document.querySelector('.priceTotal');
        this.init();
    }

    init() {
        // обработчик для каждой кнопки для открытия модалки
        this.shopModalBtns.forEach(btn => {
            btn.addEventListener('click', this.handleModalBtnClick.bind(this));
        });
        //кнопка скрыть модалку
        this.modalFadeCancel.addEventListener('click', () => this.hideModal());
      // клик вне модалки
        document.addEventListener('click', (event) => {
            if (!this.modalContent.contains(event.target) && !this.isShopModalBtn(event.target) && !this.modalFadeCancel.isSameNode(event.target)) {
                this.hideModal();
            }
        });
    }
    // перенос значений из карточки в модалку
    handleModalBtnClick(event) {
        const card = event.target.closest('.shop-card');
        if (card) {
            const productName = card.querySelector('.shop-block__title').textContent;
            const productImgSrc = card.querySelector('.shop-card__img').src;
            const initialPriceForUnit = parseInt(card.querySelector('.shopPrice').getAttribute('data-initial-price'));
            const quantity = parseInt(card.querySelector('.counterInput').value);

            this.modalProductName.textContent = productName;
            this.modalProductImg.src = productImgSrc;
            this.modalPriceCount.textContent = quantity;
            this.modalPriceForUnit.textContent = initialPriceForUnit;
            this.modalPriceTotal.textContent = initialPriceForUnit * quantity;

            this.showModal();
        }
    }

// отображение модалки
    showModal() {
        this.modalFade.classList.add('show');
        this.bodyOverflow.classList.add('body-wrapper--overflow');
    }
// скрытие модалки
    hideModal() {
        this.modalFade.classList.remove('show');
        this.bodyOverflow.classList.remove('body-wrapper--overflow');
    }
//проверка таргета клика кнопки
    isShopModalBtn(target) {
        let isShopModalBtn = false;
        this.shopModalBtns.forEach(btn => {
            if (btn.contains(target) || btn.isSameNode(target)) {
                isShopModalBtn = true;
            }
        });
        return isShopModalBtn;
    }
}
// собираем все shop-box
document.addEventListener("DOMContentLoaded", function () {
    const shopContainers = document.querySelectorAll('.shop-box');
    const shopCounters = [];
    shopContainers.forEach(container => {
        shopCounters.push(new ShopCounter(container));
    });
    const modalController = new ModalController();
});
class OrderForm {
    constructor(form) {
        this.form = form;
        this.phoneInput = this.form.querySelector('.inputPhone');
        this.submitButton = this.form.querySelector('.form-btn');
        this.phoneError = this.form.querySelector('.phoneError');
        this.formAccept = document.querySelector('.formAccept');

        this.init();
    }
  // маска при помощи либы Imask
    init() {
        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleSubmit();
        });
        this.phoneMask = IMask(this.phoneInput, {
            mask: '+{7}(000)000-00-00'
        });
        this.phoneInput.addEventListener('input', () => this.validatePhone());
    }
// валидация формы телефона на ошибки
    validatePhone() {
        const phoneRegex = /^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/;
        if (this.phoneInput.value.length === 0 || phoneRegex.test(this.phoneInput.value)) {
            this.phoneError.style.display = 'none';
            if (phoneRegex.test(this.phoneInput.value)) {
                this.submitButton.classList.remove('disabled');
                this.submitButton.removeAttribute('disabled');
            } else {
                this.submitButton.classList.add('disabled');
                this.submitButton.setAttribute('disabled', true);
            }
        } else {
            this.phoneError.style.display = 'block';
            this.submitButton.classList.add('disabled');
            this.submitButton.setAttribute('disabled', true);
        }
    }
    // отображение ошибки валидации
    handleSubmit() {
        this.form.style.display = 'none';
        this.formAccept.classList.remove('hidden');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.formAction');
    new OrderForm(form);
});

document.querySelector('.formAction').addEventListener('submit', function(event) {
    event.preventDefault();
    // добртный костыль по дублированию значений в скрытый инпуты
    document.querySelector('.hiddenProductName').value = document.querySelector('.productName').textContent;
    document.querySelector('.hiddenPriceCount').value = document.querySelector('.priceCount').textContent;
    document.querySelector('.hiddenPriceForUnit').value = document.querySelector('.priceForUnit').textContent;
    document.querySelector('.hiddenPriceTotal').value = document.querySelector('.priceTotal').textContent;
    const formData = new FormData(this);
    const jsonData = {};
    formData.forEach((value, key) => {
        jsonData[key] = value;
    });

    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(jsonData)
    })
        .then(response => response.text())
        .then(data => {
            console.log(data); // проверка данных модалки
            document.getElementById('debugContainer').innerHTML = data;
            // обновление данных модалки
            const modalProductName = document.querySelector('.productName');
            const modalPriceCount = document.querySelector('.priceCount');
            const modalPriceForUnit = document.querySelector('.priceForUnit');
            const modalPriceTotal = document.querySelector('.priceTotal');
            modalProductName.textContent = jsonData.productName;
            modalPriceCount.textContent = jsonData.priceCount;
            modalPriceForUnit.textContent = jsonData.priceForUnit;
            modalPriceTotal.textContent = jsonData.priceTotal;

            // отображение модалки
            const modalFade = document.querySelector('.modal-fade');
            modalFade.classList.add('show');
            const bodyOverflow = document.querySelector('body');
            bodyOverflow.classList.add('body-wrapper--overflow');
        })
        .catch(error => console.error('Error:', error));
});

