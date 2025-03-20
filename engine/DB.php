<?php


date_default_timezone_set('America/Cuiaba');

if (strtolower(basename($_SERVER['REQUEST_URI'])) == strtolower(basename(__FILE__))) {
    header('location: ../index.php');
    exit();
}

require_once __DIR__ . '/../app/Config/config.php';

class DB
{
    // private static $d = [
    // 	'HOST' => 'localhost',
    // 	'USER' => 'root',
    // 	'PASS' => '',
    // 	'DBNAME' => 'gv'
    // ];

    private static $pdo = null;

    public static function getConnection()
    {
        $config = Config::get('database');
        if (self::$pdo == null) {
            try {
                self::$pdo = new PDO($config['driver'] . ':host=' . $config['host'] . ';port=' . $config['port'] . ';dbname=' . $config['dbname'], $config['username'], $config['password'], $config['options']);
            } catch (PDOException $e) {
                throw new \Exception($e->getMessage());
            }
        }
    }

    public static function get()
    {
        if (self::$pdo == null) {
            self::getConnection();
        }
        return self::$pdo;
    }

    public static function transaction($sql, $values)
    {
        try {
            self::getConnection();
            self::$pdo->beginTransaction();
            $statement = self::$pdo->prepare($sql);
            $statement->execute($values);
            if (self::$pdo->lastInsertId()) {
                $id = self::$pdo->lastInsertId();
            }
            self::$pdo->commit();
            return $id ?? $statement;
        } catch (PDOException $e) {
            self::$pdo->rollback();
            throw new \Exception($e->getMessage());
        } finally {
            self::$pdo = null;
        }
    }

    public static function select(string $sql, $values = null, $type_params = 3)
    {
        self::getConnection();
        $statement = self::$pdo->prepare($sql);

        switch ($type_params) {
            case 0:
                if ($values) {
                    $key = 1;
                    foreach ($values as $value) {
                        if (is_int($value)) {
                            $param = PDO::PARAM_INT;
                        } elseif (is_bool($value)) {
                            $param = PDO::PARAM_BOOL;
                        } elseif (is_string($value)) {
                            $param = PDO::PARAM_STR;
                        } elseif (is_null($value)) {
                            $param = PDO::PARAM_NULL;
                        } else {
                            $param = PDO::PARAM_STR;
                        }
                        $statement->bindParam($key, $value, $param);
                        $key++;
                    }
                }
                $statement->execute();
                break;

            case 1:
                foreach ($values as $value) {
                    $statement->bindParam($value['pos'], $value['value'], $value['type']);
                }
                $statement->execute();
                break;

            default:
                $statement->execute($values);
        }

        if ($statement->rowCount() > 1) {
            $resultsClean = [];
            foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $krow => $row) {
                foreach ($row as $key => $value) {
                    $resultsClean[$krow][$key] = htmlentities($value, ENT_QUOTES, 'UTF-8');
                }
            }
            return $resultsClean;
        }

        if ($statement->rowCount() == 1) {
            $resultsClean = [];
            foreach ([$statement->fetch(PDO::FETCH_ASSOC)] as $krow => $row) {
                foreach ($row as $key => $value) {
                    $resultsClean[$krow][$key] = htmlentities($value, ENT_QUOTES, 'UTF-8');
                }
            }
            return $resultsClean;
        }

        return null;
    }

    public static function action(string $sql, array $values)
    {
        $statement = self::$pdo->prepare($sql);
        $statement->execute($values);
        if (self::$pdo->lastInsertId()) {
            $id = self::$pdo->lastInsertId();
        }
        return $id ?? $statement;
    }

    public static function safeTransaction(Closure $callback)
    {
        $errors = [false, null];
        try {
            self::getConnection();
            self::$pdo->beginTransaction();
            $callback();
            self::$pdo->commit();
        } catch (PDOException $e) {
            $errors = [true, $e->getMessage()];
            self::$pdo->rollback();
        } finally {
            if ($errors[0]) {
                return [true, $errors[1]];
            }
        }
    }

    public static function query(string $query)
    {
        self::getConnection();
        return self::$pdo->query($query);
    }

    public static function auditoria($table, $operacao, $query, $bindings)
    {

        foreach (array_fill(0, count($bindings), '?') as $key => $wildcard) {
            $query = substr_replace($query, $bindings[$key], strpos($query, $wildcard), strlen($wildcard));
        }

        $sql = 'INSERT INTO auditoria (datahora,idusuario,tabela,operacao,detalhe,url,ip_address,user_agent) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $values = [date('Y-m-d H:i:s'), $_SESSION['user']['id'], $table, $operacao, $query, $_SERVER['HTTP_REFERER'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']];

        self::action($sql, $values);
    }

    public function __destruct()
    {
        self::$pdo = null;
    }

}
