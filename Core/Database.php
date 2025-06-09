<?php
class Database {
    private static string $host = 'localhost';
    private static string $dbname = 'Credo';
    private static string $user = 'postgres';
    private static string $pass = 'root';
    private static ?PDO $pdo = null;

    private function __construct() {} // Empêche l'instanciation

    public static function getConnection(): PDO {
        if (self::$pdo === null) {
            try {
                $dsn = "pgsql:host=" . self::$host . ";dbname=" . self::$dbname;
                self::$pdo = new PDO($dsn, self::$user, self::$pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);

                // Pour forcer l'encodage UTF-8 sur la connexion si besoin (pgsql le gère bien normalement)
                self::$pdo->exec("SET NAMES 'UTF8'");

            } catch (PDOException $e) {
                // On lève une exception au lieu de mourir immédiatement
                throw new RuntimeException('Erreur de connexion à la base : ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    // Optionnel : méthodes pour changer la config si besoin avant la première connexion
    public static function configure(string $host, string $dbname, string $user, string $pass): void {
        if (self::$pdo !== null) {
            throw new RuntimeException('Connexion déjà établie, impossible de reconfigurer.');
        }
        self::$host = $host;
        self::$dbname = $dbname;
        self::$user = $user;
        self::$pass = $pass;
    }
}
?>
