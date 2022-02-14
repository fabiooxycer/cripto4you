<?php

/* ACESSO AO BANCO DE DADOS DOS APPS */
class BancoApps
{
    private static $dbNome = 'pericias';
    private static $dbHost = 'oxycer-db-dev.cqbylo3g9unc.us-east-2.rds.amazonaws.com';
    private static $dbUsuario = 'root';
    private static $dbSenha = 'Bottling3-Cornflake-Exemption';
    // private static $dbHost = 'localhost';
    // private static $dbUsuario = 'pericias';
    // private static $dbSenha = 'oxycer';


    private static $cont = null;

    public function __construct()
    {
        die('A função Init nao é permitido!');
    }

    public static function conectar()
    {
        if (null == self::$cont) {
            try {
                self::$cont =  new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbNome, self::$dbUsuario, self::$dbSenha, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            } catch (PDOException $exception) {
                die($exception->getMessage());
            }
        }
        return self::$cont;
    }

    public static function desconectar()
    {
        self::$cont = null;
    }
}