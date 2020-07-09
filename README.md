# PDOClickHouse

[![Latest Stable Version](https://poser.pugx.org/faapz/pdo/v/stable)](https://packagist.org/packages/faapz/pdo)
[![Total Downloads](https://poser.pugx.org/faapz/pdo/downloads)](https://packagist.org/packages/faapz/pdo)
[![Latest Unstable Version](https://poser.pugx.org/faapz/pdo/v/unstable)](https://packagist.org/packages/faapz/pdo)
[![License](https://poser.pugx.org/faapz/pdo/license)](https://packagist.org/packages/faapz/pdo)

Just another PDOClickHouse database library

### Installation

Use [Composer](https://getcomposer.org/)

```bash
$ composer require rezon73/pdo-vertica
```

### Usage

Examples selecting, inserting, updating and deleting data from or into `users` table.

```php
require_once 'vendor/autoload.php';

$hostname = '127.0.0.1';
$port = 8123;

$pdo = new \Rezon73\PDOClickHouse\Database($hostname, $port);

// SELECT * FROM users WHERE id = ?
$selectStatement = $pdo->select()
                       ->from('users')
                       ->where('id', '=', 1234);

$stmt = $selectStatement->execute();
$data = $stmt->fetch();

// INSERT INTO users ( id , usr , pwd ) VALUES ( ? , ? , ? )
$insertStatement = $pdo->insert(array(
                           "id" =>1234,
                           "usr" => "your_username",
                           "pwd" => "your_password"
                       ))
                       ->into("users");

$insertStatement->execute();

// UPDATE users SET pwd = ? WHERE id = ?
$updateStatement = $pdo->update(array("pwd" => "your_new_password"))
                       ->table("users")
                       ->where(new Clause\Conditional("id", "=", 1234));

$affectedRows = $updateStatement->execute();

// DELETE FROM users WHERE id = ?
$deleteStatement = $pdo->delete()
                       ->from("users")
                       ->where(new Clause\Conditional("id", "=", 1234));

$affectedRows = $deleteStatement->execute();
```

> The `sqlsrv` extension will fail to connect when using error mode `PDOClickHouse::ERRMODE_EXCEPTION` (default). To connect, you will need to explicitly pass `array(PDOClickHouse::ATTR_ERRMODE => PDOClickHouse::ERRMODE_WARNING)` (or `PDOClickHouse::ERRMODE_SILENT`) into the constructor, or override the `getDefaultOptions()` method when using `sqlsrv`.

### Documentation

See [DOCUMENTATION](docs/README.md)

### Changelog

See [CHANGELOG](CHANGELOG.md)

### License

See [LICENSE](LICENSE)
