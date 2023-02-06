<?php
//Проведите рефакторинг, исправьте баги и продокументируйте в стиле PHPDoc код, приведённый ниже (таблица users здесь аналогична таблице users из задачи №1).
//Примечание: код написан исключительно в тестовых целях, это не "жизненный пример" :)

/**
 * @param string $userIds
 * @return array
 */
function loadUsersData(string $userIds): array
{
    $userIds = explode(',', $userIds);
    $data = [];
    foreach ($userIds as $userId) {
        $db = mysqli_connect("localhost", "root", "123123", "database");
        $sql = mysqli_query($db,  sprintf("SELECT * FROM users WHERE id=%u", $userId));
        while($obj = $sql->fetch_object()){
            $data[$userId] = $obj->name;
        }
        mysqli_close($db);
    }

    return $data;
}
// Как правило, в $_GET['user_ids'] должна приходить строка
// с номерами пользователей через запятую, например: 1,2,17,48 - ?user_ids=1,2,3
// Массив удобнее - ?user_ids[]=1&user_ids[]=2&user_ids[]=17&user_ids[]=48
$data = loadUsersData($_GET['user_ids']);
foreach ($data as $user_id=>$name) {
    echo "<a href=\"/show_user.php?id=$user_id\">$name</a>";
}
//Плюсом будет, если укажете, какие именно уязвимости присутствуют в исходном варианте (если таковые, на ваш взгляд, имеются), и приведёте примеры их проявления.
// Существует опасность sql инъекции.