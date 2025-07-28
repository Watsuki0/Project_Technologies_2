<?php
class Database
{
    private static $pdo = null;

    private static function getConfig()
    {
        static $config = null;
        if ($config === null) {
            $config = require __DIR__ . '/../config/data_db.php';  // adapter le chemin si besoin
        }
        return $config;
    }

    public static function getConnection()
    {
        if (self::$pdo === null) {
            $config = self::getConfig();
            try {
                self::$pdo = new PDO(
                    "pgsql:host={$config['host']};dbname={$config['dbname']}",
                    $config['user'],
                    $config['pass']
                );
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erreur de connexion à la base de données : ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
