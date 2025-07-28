<?php
class Database {
    private static $host = 'localhost';
    private static $dbname = 'Credo';
    private static $user = 'postgres';
    private static $pass = 'postgres';
    private static $pdo = null;

    private function __construct() {} // Empêche l'instanciation

    public static function getConnection() {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO("pgsql:host=" . self::$host . ";dbname=" . self::$dbname, self::$user, self::$pass);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die('Erreur de connexion : ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
?>
