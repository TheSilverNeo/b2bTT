CREATE TABLE `users` (
     `id`         INT(11) NOT NULL AUTO_INCREMENT,
     `name`       VARCHAR(255) DEFAULT NULL,
     `gender`     gender NOT NULL COMMENT '0 - не указан, 1 - мужчина, 2 - женщина.',
     `birth_date` INT(11) NOT NULL COMMENT 'Дата в unixtime.',
     PRIMARY KEY (`id`),
     FOREIGN KEY(id) REFERENCES phone_numbers (user_id)
);
CREATE TYPE gender AS ENUM (0, 1, 2);
# Я бы добавил индекс на `gender`, но не знаю на сколько часто будет поиск по этому параметру

CREATE TABLE `phone_numbers` (
     `id`      INT(11) NOT NULL AUTO_INCREMENT,
     `user_id` INT(11) NOT NULL,
     `phone`   VARCHAR(255) DEFAULT NULL,
     PRIMARY KEY (`id`)
);

SELECT users.name, count(phone_numbers.phone) as phone_count
FROM users
LEFT JOIN phone_numbers ON users.id = phone_numbers.user_id
WHERE gender = 2 AND
      users.birth_date BETWEEN (SELECT UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 22 YEAR)))
          AND (SELECT UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 18 YEAR)))
GROUP BY users.name