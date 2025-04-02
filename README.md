# Query Logger

![Packagist Version](https://img.shields.io/packagist/v/rifat-simoom/query-logger)
![License](https://img.shields.io/github/license/rifat-simoom/query-logger)
![Downloads](https://img.shields.io/packagist/dt/rifat-simoom/query-logger)

Query Logger is a lightweight PHP library for logging SQL queries executed via PDO. It is framework-agnostic but can be seamlessly integrated into Laravel.

## ✨ Features
- Logs all SQL queries with execution time
- Includes a stack trace for better debugging
- Works with any PHP project using PDO
- Simple and efficient implementation

## 📦 Installation
You can install the package via Composer:

```sh
composer require rifat-simoom/query-logger
```

## 🚀 Usage
### **Standalone PHP Usage**
```php
require 'vendor/autoload.php';

use RifatSimoom\QueryLogger;

$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
$logger = new QueryLogger($pdo, __DIR__ . '/logs/query.log');
$logger->startLogging();
```

### **Using in Laravel**
For Laravel applications, you can integrate it as follows:

```php
use RifatSimoom\QueryLogger;
use Illuminate\Support\Facades\DB;

$logger = new QueryLogger(DB::connection()->getPdo(), storage_path("/logs/get-token-query.log"));
$logger->startLogging();
```

## ⚙️ Configuration
By default, the logger saves queries in the specified log file. You can customize:
- **Log file location**
- **Formatting of logged queries**
- **Filtering specific queries**

## 📄 Example Log Output
```
1. SELECT * FROM users WHERE email = ? [Execution Time: 12ms]
   Called in /var/www/project/app/Services/UserService.php:45

2. INSERT INTO orders (user_id, total) VALUES (?, ?) [Execution Time: 20ms]
   Called in /var/www/project/app/Repositories/OrderRepository.php:32
```

## 🛠️ Contributing
Contributions are welcome! Please fork the repository and submit a pull request.

## 📜 License
This project is open-sourced under the MIT License.

## 📬 Contact
For issues, please open a GitHub issue or reach out to [your email or GitHub profile].

