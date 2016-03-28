<?php

header('Content-Type: text/plain');

// Test Postgres
echo 'Postgres' . PHP_EOL;
echo '- Config: host=' . getenv('PG_HOST') . ';dbname=' . getenv('PG_DBNAME')
. ';user=' . getenv('PG_USER') . ';password=' . getenv('PG_PASSWORD') . PHP_EOL;

try {
    $dbh = new PDO(
        'pgsql:host=' . getenv('PG_HOST') . ';dbname=' . getenv('PG_DBNAME'),
        getenv('PG_USER'),
        getenv('PG_PASSWORD')
    );
    echo '- Succesful connected to PostgreSQL' . PHP_EOL;
} catch (PDOException $e) {
    echo 'x Failed to connect to PostgreSQL: ' . $e->getMessage() . PHP_EOL;
}

try {
    $tableList = array();
    $result = $dbh->query("SELECT table_schema || '.' || table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema NOT IN ('pg_catalog', 'information_schema');");
    while ($row = $result->fetch(PDO::FETCH_NUM)) {
        $tableList[] = $row[0];
    }
    echo '- Succesful query to PostgreSQL' . PHP_EOL;
} catch (PDOException $e) {
    echo 'x Failed to query PostgreSQL: ' . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL;

// Test MySQL
echo 'MySql' . PHP_EOL;
echo '- Config: host=' . getenv('MYSQL_HOST') . ';dbname=' . getenv('MYSQL_DBNAME')
. ';user=' . getenv('MYSQL_USER') . ';password=' . getenv('MYSQL_PASSWORD') . PHP_EOL;

try {
    $dbh = new PDO(
        'mysql:host=' . getenv('MYSQL_HOST') . ';dbname=' . getenv('MYSQL_DBNAME'),
        getenv('MYSQL_USER'),
        getenv('MYSQL_PASSWORD'),
        [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
    );
    echo '- Succesful connected to MySql' . PHP_EOL;
} catch (PDOException $e) {
    echo 'x Failed to connect to MySql: ' . $e->getMessage() . PHP_EOL;
}

try {
    $tableList = array();
    $result = $dbh->query("SHOW TABLES;");
    while ($row = $result->fetch(PDO::FETCH_NUM)) {
        $tableList[] = $row[0];
    }
    echo '- Succesful query to MySql' . PHP_EOL;
} catch (PDOException $e) {
    echo 'x Failed to query MySql: ' . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL;

// Test Memcached
echo 'Memcached' . PHP_EOL;
echo '- Config: host=' . getenv('MEMCACHED_HOST') . PHP_EOL;
$mem = new Memcached();
$mem->addServer(getenv('MEMCACHED_HOST'), 11211);
$mem->set('test', 1);
$result = $mem->get('test');
if ($result === 1) {
    echo '- Succesful connection to Memcached' . PHP_EOL;
} else {
    echo 'x Failed to use Memcached' . PHP_EOL;
}

echo PHP_EOL;

// Test Redis
echo 'Redis' . PHP_EOL;
echo '- Config: host=' . getenv('REDIS_HOST') . PHP_EOL;
$redis = new Redis();
$redis->connect(getenv('REDIS_HOST'));
$redis->set('test', 1);
$result = $redis->get('test');
if ($result == 1) {
    echo '- Succesful connection to Redis' . PHP_EOL;
} else {
    echo 'x Failed to use Redis' . PHP_EOL;
}

echo PHP_EOL;

// Test FS permissions
echo 'Permissions' . PHP_EOL;
touch('test');
if(file_exists('test')) {
    unlink('test');
    echo '- Succesfully created a file' . PHP_EOL;
} else {
    echo 'x Failed to create a file' . PHP_EOL;
}