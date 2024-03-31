<?php
/*
use \RedBeanPHP\R as R;

R::setup("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']}", "{$_ENV['DB_USERNAME']}", "{$_ENV['DB_PASSWORD']}");

$tableExists = R::exec("SHOW TABLES LIKE 'users'");

if ($tableExists == 0) {
    // Если таблицы не существует, создайте ее
    R::exec("CREATE TABLE `users` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `email` VARCHAR(255) NOT NULL UNIQUE,
        `password` VARCHAR(255) NOT NULL,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
}
*/
