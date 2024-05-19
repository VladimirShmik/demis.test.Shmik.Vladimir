<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //  получение и декодирование json
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    //переменные формы
    $userName = htmlspecialchars($data['userName']);
    $userPhone = htmlspecialchars($data['userPhone']);
    $userComment = htmlspecialchars($data['userComment']);
    $productName = htmlspecialchars($data['productName']);
    $priceCount = htmlspecialchars($data['priceCount']);
    $priceForUnit = htmlspecialchars($data['priceForUnit']);
    $priceTotal = htmlspecialchars($data['priceTotal']);

    // генерация номера заказа
    $orderNumber = rand(100, 999);

    // цепляем айпи юзера
    $clientIp = $_SERVER['REMOTE_ADDR'];

    // цепляем урл откуда была форма отправлена
    $pageUrl = htmlspecialchars($_SERVER['HTTP_REFERER']);

    // вывод данных в листе
    $orderDetails = '
                      <h2 class="section-wrapper__title">Детали заказа</h2>
                      <ul>
                        <li>Новый заказ №' . $orderNumber . '</li>
                        <li>Имя: ' . $userName . '</li>
                        <li>Телефон: ' . $userPhone . '</li>
                        <li>Комментарий: ' . $userComment . '</li>
                        <li>Товар: ' . $productName . '</li>
                        <li>Количество: ' . $priceCount . '</li>
                        <li>Стоимость: ' . $priceForUnit . '</li>
                        <li>Сумма: ' . $priceTotal . '</li>
                        <li>Адрес страницы: ' . $pageUrl . '</li>
                        <li>IP адрес клиента: ' . $clientIp . '</li>
                    </ul>';

    echo $orderDetails;
    // Формируем текст письма
    $to = "indigosunset00@gmail.com";
    $subject = "Новый заказ";
    $message = "Имя: $userName\nТелефон: $userPhone\nКомментарий: $userComment\n\nТовар: $productName\nКоличество: $priceCount\nСтоимость: $priceForUnit\nСумма: $priceTotal";
    $headers = "From: shop@gmail.com" . "\r\n" .
        "Reply-To: shop@gmail.com" . "\r\n" .
        "X-Mailer: PHP/" . phpversion();

    // Отправляем письмо
    if (mail($to, $subject, $message, $headers)) {
        echo '<h2 class="section-wrapper__title">Письмо успешно отправлено!</h2>';
    } else {
        echo  '<h2 class="section-wrapper__title">Ошибка при отправке письма.</h2>';
    }


    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Demis.Test</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body class="body-wrapper">
<!--main-->
<main class="main">
    <!--shop-section-->
    <section class="shop-section">
        <div class="section-wrapper">
            <h1 class="section-wrapper__title">Каталог продукции</h1>
            <!--shop-grid-->
            <div class="shop-grid g-1">
                <!--shop-card-->
                <article class="shop-card p-1 g-1">
                    <img src="./img/card-img-1.avif" alt="img-title" class="shop-card__img mb-1 pb-1">
                    <div class="shop-block g-1">
                        <h3 class="shop-block__title">Товар №1</h3>
                        <div class="shop-box">
                            <div class="shop-box__price shopPrice" data-initial-price="1000">1000 р.</div>
                            <div class="shop-counter g-half">
                                <span class="shop-counter__symbol counterMinus">-</span>
                                <input type="number"
                                       class="shop-counter__symbol shop-counter__symbol--number counterInput"
                                       value="1">
                                <span class="shop-counter__symbol counterPlus">+</span>
                            </div>
                        </div>
                        <button class="shop-block__btn shopModalBtn" type="button" data-modal-target="#modal1">В корзину</button>
                    </div>
                </article>
                <!--shop-card-->
                <article class="shop-card p-1 g-1">
                    <img src="./img/card-img-1.avif" alt="img-title" class="shop-card__img mb-1 pb-1">
                    <div class="shop-block g-1">
                        <h3 class="shop-block__title">Товар №2</h3>
                        <div class="shop-box">
                            <div class="shop-box__price shopPrice" data-initial-price="2000">2000 р.</div>
                            <div class="shop-counter g-half">
                                <span class="shop-counter__symbol counterMinus">-</span>
                                <input type="number"
                                       class="shop-counter__symbol shop-counter__symbol--number counterInput"
                                       value="1">
                                <span class="shop-counter__symbol counterPlus">+</span>
                            </div>
                        </div>
                        <button class="shop-block__btn shopModalBtn" type="button">В корзину</button>
                    </div>
                </article>
                <!--shop-card-->
                <article class="shop-card p-1 g-1">
                    <img src="./img/card-img-1.avif" alt="img-title" class="shop-card__img mb-1 pb-1">
                    <div class="shop-block g-1">
                        <h3 class="shop-block__title">Товар №3</h3>
                        <div class="shop-box">
                            <div class="shop-box__price shopPrice" data-initial-price="3000">3000 р.</div>
                            <div class="shop-counter g-half">
                                <span class="shop-counter__symbol counterMinus">-</span>
                                <input type="number"
                                       class="shop-counter__symbol shop-counter__symbol--number counterInput"
                                       value="1">
                                <span class="shop-counter__symbol counterPlus">+</span>
                            </div>
                        </div>
                        <button class="shop-block__btn shopModalBtn" type="button">В корзину</button>
                    </div>
                </article>
                <!--shop-card-->
                <article class="shop-card p-1 g-1">
                    <img src="./img/card-img-1.avif" alt="img-title" class="shop-card__img mb-1 pb-1">
                    <div class="shop-block g-1">
                        <h3 class="shop-block__title">Товар №4</h3>
                        <div class="shop-box">
                            <div class="shop-box__price shopPrice" data-initial-price="4000">4000 р.</div>
                            <div class="shop-counter g-half">
                                <span class="shop-counter__symbol counterMinus">-</span>
                                <input type="number"
                                       class="shop-counter__symbol shop-counter__symbol--number counterInput"
                                       value="1">
                                <span class="shop-counter__symbol counterPlus">+</span>
                            </div>
                        </div>
                        <button class="shop-block__btn shopModalBtn" type="button">В корзину</button>
                    </div>
                </article>
                <!--shop-card-->
                <article class="shop-card p-1 g-1">
                    <img src="./img/card-img-1.avif" alt="img-title" class="shop-card__img mb-1 pb-1">
                    <div class="shop-block g-1">
                        <h3 class="shop-block__title">Товар №5</h3>
                        <div class="shop-box">
                            <div class="shop-box__price shopPrice" data-initial-price="5000">5000 р.</div>
                            <div class="shop-counter g-half">
                                <span class="shop-counter__symbol counterMinus">-</span>
                                <input type="number"
                                       class="shop-counter__symbol shop-counter__symbol--number counterInput"
                                       value="1">
                                <span class="shop-counter__symbol counterPlus">+</span>
                            </div>
                        </div>
                        <button class="shop-block__btn shopModalBtn" type="button">В корзину</button>
                    </div>
                </article>
                <!--shop-card-->
                <article class="shop-card p-1 g-1">
                    <img src="./img/card-img-1.avif" alt="img-title" class="shop-card__img mb-1 pb-1">
                    <div class="shop-block g-1">
                        <h3 class="shop-block__title">Товар №6</h3>
                        <div class="shop-box">
                            <div class="shop-box__price shopPrice" data-initial-price="6000">6000 р.</div>
                            <div class="shop-counter g-half">
                                <span class="shop-counter__symbol counterMinus">-</span>
                                <input type="number"
                                       class="shop-counter__symbol shop-counter__symbol--number counterInput"
                                       value="1">
                                <span class="shop-counter__symbol counterPlus">+</span>
                            </div>
                        </div>
                        <button class="shop-block__btn shopModalBtn" type="button">В корзину</button>
                    </div>
                </article>
                <!--shop-card-->
                <article class="shop-card p-1 g-1">
                    <img src="./img/card-img-1.avif" alt="img-title" class="shop-card__img mb-1 pb-1">
                    <div class="shop-block g-1">
                        <h3 class="shop-block__title">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Quisquam, saepe.</h3>
                        <div class="shop-box">
                            <div class="shop-box__price shopPrice" data-initial-price="7000">7000 р.</div>
                            <div class="shop-counter g-half">
                                <span class="shop-counter__symbol counterMinus">-</span>
                                <input type="number"
                                       class="shop-counter__symbol shop-counter__symbol--number counterInput"
                                       value="1">
                                <span class="shop-counter__symbol counterPlus">+</span>
                            </div>
                        </div>
                        <button class="shop-block__btn shopModalBtn" type="button">В корзину</button>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <div id='debugContainer'></div>
</main>
<!--footer-->
<footer class="footer">
</footer>
<div class="modal-fade">
    <div class="modal-dialog modalContent">
        <div class="modal-content">
            <div class="modal-header">
                <button class="modal-header__btn">x</button>
            </div>
            <form action="index.php" class="modal-body formAction" method="post">
                <img src="" alt="" class="modal-body__img productImg">
                <h3 class="modal-body__text">Название товара: <span class="modal-body__span productName"></span></h3>
                <p class="modal-body__text">Количество товара: <span class="modal-body__span priceCount"></span></p>
                <p class="modal-body__text">Стоимость за единицу товара: <span class="modal-body__span priceForUnit"></span></p>
                <p class="modal-body__text">Итоговая сумма: <span class="modal-body__span priceTotal"></span></p>

                <!-- Hidden input fields -->
                <input type="hidden" name="productName" class="hiddenProductName">
                <input type="hidden" name="priceCount" class="hiddenPriceCount">
                <input type="hidden" name="priceForUnit" class="hiddenPriceForUnit">
                <input type="hidden" name="priceTotal" class="hiddenPriceTotal">

                <fieldset class="form-grid">
                    <legend class="form-legend">Форма обратной связи</legend>
                    <label class="form-label">
                        Ваше имя
                        <input type="text" class="form-input" placeholder="Введите ваше имя" name="userName">
                    </label>
                    <label class="form-label">
                        Ваш телефон*
                        <input type="text" class="form-input inputPhone" placeholder="Введите ваш телефон" name="userPhone" required>
                        <span class="error-text phoneError">Неверный формат телефона</span>
                    </label>
                    <label class="form-label">
                        Ваш комментарий
                        <textarea class="form-area" placeholder="Введите ваш комментарий" name="userComment"></textarea>
                    </label>
                    <button class="form-btn disabled" type="submit">Оформить заказ</button>
                </fieldset>
            </form>

            <p class="form-accept formAccept hidden">Форма удачно отправлена</p>
        </div>
    </div>
</div>

<script src="./index.js"></script>
<script src="./input_mask.js"></script>
<!--дебаг контейнер пхп-->
<div id="debugContainer"></div>
</body>
</html>
