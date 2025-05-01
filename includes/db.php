<?php
class Database {
    private static $host = 'localhost';
    private static $dbname = 'Credo';
    private static $user = 'postgres';
    private static $pass = 'postgres';
    private static $pdo = null;

    public static function getConnection() {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO("pgsql:host=" . self::$host . ";dbname=" . self::$dbname, self::$user, self::$pass);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erreur de connexion à la base de données : ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
?>
