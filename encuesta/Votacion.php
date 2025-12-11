<?php
require_once "DB.php";
class Votacion {

    public static function save(string $opcion): bool {
        $pdo = DB::getConnection();

        // Validación y normalización mínima
        $opcion_limpia = ($opcion === 'Si' || $opcion === 'No') ? $opcion : null;
        if ($opcion_limpia === null) return false;

        $sql = "INSERT INTO votos (opcion) VALUES (?)"; // Uso directo de la tabla 'votos'
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute([$opcion_limpia]);
    }

    public static function findAll(): array {
        $pdo = DB::getConnection();
        
        $sql = "SELECT opcion, COUNT(*) as total FROM votos GROUP BY opcion"; 
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $resultados = ['Si' => 0, 'No' => 0];
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) { 
            $resultados[$row['opcion']] = (int)$row['total'];
        }
        
        return $resultados;
    }
}