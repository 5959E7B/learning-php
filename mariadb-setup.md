# Quick (unsecure) mariadb setup

## 1. Install mariadb

```bash
sudo apt install mariadb
sudo pacman -Sy mariadb
```

```bash
sudo apt install php-mysqli
```
For Arch-based distros
> https://wiki.archlinux.org/title/PHP#MySQL/MariaDB
> Uncomment the following lines in /etc/php/php.ini:
> ──┬──────────────────────
>   │ /etc/php/php.ini
> ──┼──────────────────────
>   │ extension=pdo_mysql
>   │ extension=mysqli
> ──┴──────────────────────

## 2. Install DB

```bash
sudo mariadb-install-db --user=mysql --basedir=/usr --datadir=/var/lib/mysql

# Two all-privilege accounts were created.
# One is root@localhost, it has no password, but you need to
# be system 'root' user to connect. Use, for example, sudo mariadb
# The second is mysql@localhost, it has no password either, but
# you need to be the system 'mysql' user to connect.
# After connecting you can set the password, if you would need to be
# able to connect as any of these users with a password and without sudo
```

## 3. Start the service

```bash
sudo systemctl start mariadb
```

## 4. Connect & CREATE a DATABASE

```bash
sudo mariadb
# or better
sudo runuser -u mysql mariadb
```

```sql
CREATE DATABASE `testing`;
```

## 5. Create a dedicated USER 

```sql
CREATE USER 'test_user'@'localhost' IDENTIFIED BY 'correct horse battery staple';
GRANT SELECT, INSERT, UPDATE, DELETE ON testing.* TO 'test_user'@'localhost'; # note that this user can't change the schema (CREATE/ALTER/DROP etc.)
FLUSH PRIVILEGES;
```

You can then access the database via:

```bash
❯ mariadb -u test_user -p testing
Enter password: correct horse battery staple
...
MariaDB [testing]> 
```

or

```php
<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // throw exceptions on failure

    $hostname = "localhost";
    $username = "test_user";
    $password = "correct horse battery staple";
    $database_name = "testing";

    $db = new mysqli($hostname, $username, $password, $database_name);
    $db->set_charset("utf8mb4");
 ?>
```

## 6. Commands

`thing` gets the value
'thing' is a literal

```bash
mariadb -u test_user -p testing
```

```sql
# prints existing databases
SHOW DATABASES;

# creates a database
# CREATE DATABASE `testing`;

# deletes a database
# DROP DATABASE `testing`;

# select db to use
USE `testing`

# table creation
CREATE TABLE `table_name` (
    # https://mariadb.com/docs/server/reference/data-types
    `id` INT NOT NULL AUTO_INCREMENT,
    # up to 100 chars
    `username` VARCHAR(100),
    `time` DATETIME,
    `comment` TEXT,
    PRIMARY KEY (`id`) # () is necessary
);

# akin to .schema in sqlite3
# print table's schema
DESCRIBE `table_name`;

# more in detail https://mariadb.com/docs/server/reference/sql-statements/administrative-sql-statements/show/show-columns
SHOW FULL COLUMNS FROM table_name;

INSERT INTO `table_name`
(`username`, `time`,                `comment`) VALUES
('John',     '2026-10-23 12:00:00', 'comment');

INSERT INTO `table_name`
(`username`, `time`, `comment`) VALUES
('Mary',     NOW(),  'hello');

SELECT * FROM `table_name`;
+----+----------+---------------------+---------+
| id | username | time                | comment |
+----+----------+---------------------+---------+
|  1 | John     | 2026-10-23 12:00:00 | comment |
|  2 | Mary     | 2026-10-23 10:00:00 | hello   |
+----+----------+---------------------+---------+

SELECT * FROM `table_name` ORDER BY `time` DESC;
+----+----------+---------------------+---------+
| id | username | time                | comment |
+----+----------+---------------------+---------+
|  1 | John     | 2026-10-23 12:00:00 | comment |
|  2 | Mary     | 2026-10-23 10:00:00 | hello   |
+----+----------+---------------------+---------+

RENAME TABLE `table_name` TO `more_descriptive_name`;

CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `username` VARCHAR(128) UNIQUE NOT NULL,
    `password_hash` BINARY(32) NOT NULL, # sha256
    # X'0123456789ABCDEF' or UNHEX('FEDCBA9876543210') to INSERT
    `creation_time` DATETIME NOT NULL,
    `last_login_time` DATETIME,
    PRIMARY KEY (`id`)
);

# delete table
DROP TABLE `more_descriptive_name`;

CREATE TABLE `comments` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `user_id` INT NOT NULL,
    `time` DATETIME NOT NULL,
    `comment` TEXT NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_user_id` # constraints have names
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

# copy pasted, list CONSTRAINTS for current database
SELECT TABLE_NAME, CONSTRAINT_NAME, CONSTRAINT_TYPE
FROM information_schema.TABLE_CONSTRAINTS
WHERE CONSTRAINT_SCHEMA = DATABASE()
ORDER BY TABLE_NAME, CONSTRAINT_TYPE;

SHOW TABLES;
+-------------------+
| Tables_in_testing |
+-------------------+
| comments          |
| users             |
+-------------------+

INSERT INTO `users`
(`username`, `password_hash`, `creation_time`) VALUES
('John', X'0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF', NOW());

# repeat for 'Alice' and 'Bob'

SELECT id, username, creation_time FROM users;
+----+----------+---------------------+
| id | username | creation_time       |
+----+----------+---------------------+
|  1 | John     | 2026-10-23 10:57:00 |
|  2 | Alice    | 2026-10-23 10:58:00 |
|  3 | Bob      | 2026-10-23 10:59:00 |
+----+----------+---------------------+

INSERT INTO `comments`
(`user_id`, `time`, `comment`) VALUES
(1, NOW(), 'Hello World!');

INSERT INTO `comments`
(`user_id`, `time`, `comment`) VALUES
(2, NOW(), 'I\'m Alice');

INSERT INTO `comments`
(`user_id`, `time`, `comment`) VALUES
(3, NOW(), 'I\'m Bob');

# i forgot to change id for Bob, if you did too:
# DELETE FROM `comments` WHERE `user_id` = 2 AND `comment` = 'I\'m Bob' LIMIT 1;

SELECT * FROM comments;
+----+---------+---------------------+--------------+
| id | user_id | time                | comment      |
+----+---------+---------------------+--------------+
|  1 |       1 | 2026-10-23 11:07:08 | Hello World! |
|  2 |       2 | 2026-10-23 11:07:26 | I'm Alice    |
|  4 |       3 | 2026-10-23 11:10:33 | I'm Bob      |
+----+---------+---------------------+--------------+

SELECT username, comment FROM comments JOIN users ON (comments.user_id = users.id) ORDER BY comments.id ASC;
+----------+--------------+
| username | comment      |
+----------+--------------+
| John     | Hello World! |
| Alice    | I'm Alice    |
| Bob      | I'm Bob      |
+----------+--------------+
```

## PHP & MariaDB

https://mariadb.com/resources/blog/developer-quickstart-php-mysqli-and-mariadb/