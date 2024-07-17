<?php
// Проверяем тип запроса, обрабатываем только POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Проверяем, что все необходимые поля были переданы
    if (isset($_POST['name']) && isset($_POST['count']) && isset($_POST['phone']) && isset($_POST['time'])) {
        
        // Получаем параметры, посланные с JavaScript
        $name = htmlspecialchars($_POST['name']);
        $count = intval($_POST['count']); // Преобразуем в целое число
        $phone = htmlspecialchars($_POST['phone']);
        $time = htmlspecialchars($_POST['time']);

        // создаем переменную с содержанием письма
        $content = $name . ' оставил заявку на бронирование столика для ' . $count . ' человек в ' . $time . '. Его телефон: ' . $phone;

        // Первый параметр - кому отправляем письмо, второй - тема письма, третий - содержание
        $to = "nikolaichukkateryna@gmail.com";
        $subject = 'Запрос на бронирование столика';
        $headers = "From: webmaster@example.com\r\n";
        $headers .= "Reply-To: webmaster@example.com\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // Отправляем письмо
        $success = mail($to, $subject, $content, $headers);

        if ($success) {
            // Отдаем 200 код ответа на HTTP запрос
            http_response_code(200);
            echo "Письмо отправлено";
        } else {
            // Отдаем ошибку с кодом 500 (internal server error).
            http_response_code(500);
            echo "Письмо не отправлено";
        }

    } else {
        // Один или несколько обязательных параметров отсутствуют
        http_response_code(400);
        echo "Недостаточно данных для отправки письма";
    }

} else {
    // Если это не POST запрос - возвращаем код 405 (метод не разрешен)
    http_response_code(405);
    echo "Метод запроса не разрешен";
}
?>
