<?php

/* ACESSO AO BANCO DE DADOS DOS CADASTROS */
class BancoCadastros
{

    private static $dbNome = 'cripto4y_site';
    private static $dbHost = 'cripto4you.net';
    private static $dbUsuario = 'cripto4y_admin';
    private static $dbSenha = 'Zxcvbnm@2022';


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
