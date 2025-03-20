<?php
//177.85.101.50
//getheo.com.br
//getheoc_meutelao
//M39T3l@0
abstract class Config
{
    private static $configs = [
        'database' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'port' => 3306,
            'dbname' => 'getheoc_meutelao',
            'username' => 'getheoc_meutelao',
            'password' => 'M39T3l@0',
            'options' => [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        ]
    ];

    public static function get(string $service, string $key = null)
    {
        self::validate($service, self::$configs);
        if (is_null($key)) {
            return self::$configs[$service];
        }
        self::validate($key, self::$configs[$service]);
        return self::$configs[$service][$key];
    }

    private static function validate($key, $array)
    {
        if (array_key_exists($key, $array)) {
            return true;
        }
        throw new Exception('Configuração inválida.');
    }

}
