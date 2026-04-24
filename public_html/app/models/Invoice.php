<?php
require_once "app/core/Database.php";

class Invoice {
    public static function create($data) {
        $db = Database::connect();
        
        $sql = "INSERT INTO invoices (
            tanggal, no_nota, nama, no_hp, resep_dari, 
            frame, lensa, r_sph, r_cyl, r_as, l_sph, l_cyl, l_as, 
            add_lens, pd_jauh, pd_dekat, jumlah, uang_muka, metode_dp, sisa
        ) VALUES (
            :tanggal, :no_nota, :nama, :no_hp, :resep_dari, 
            :frame, :lensa, :r_sph, :r_cyl, :r_as, :l_sph, :l_cyl, :l_as, 
            :add_lens, :pd_jauh, :pd_dekat, :jumlah, :uang_muka, :metode_dp, :sisa
        )";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':tanggal' => $data['tanggal'] ?? date('Y-m-d'),
            ':no_nota' => $data['no_nota'] ?? '',
            ':nama' => $data['nama'] ?? '',
            ':no_hp' => $data['no_hp'] ?? '',
            ':resep_dari' => $data['resep_dari'] ?? '',
            ':frame' => $data['frame'] ?? '',
            ':lensa' => $data['lensa'] ?? '',
            ':r_sph' => $data['r_sph'] ?? '',
            ':r_cyl' => $data['r_cyl'] ?? '',
            ':r_as' => $data['r_as'] ?? '',
            ':l_sph' => $data['l_sph'] ?? '',
            ':l_cyl' => $data['l_cyl'] ?? '',
            ':l_as' => $data['l_as'] ?? '',
            ':add_lens' => $data['add_lens'] ?? '',
            ':pd_jauh' => $data['pd_jauh'] ?? '',
            ':pd_dekat' => $data['pd_dekat'] ?? '',
            ':jumlah' => $data['jumlah'] ?? 0,
            ':uang_muka' => $data['uang_muka'] ?? 0,
            ':metode_dp' => $data['metode_dp'] ?? '',
            ':sisa' => $data['sisa'] ?? 0
        ]);

        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = Database::connect();
        $sql = "UPDATE invoices SET 
            tanggal = :tanggal, no_nota = :no_nota, nama = :nama, no_hp = :no_hp, resep_dari = :resep_dari, 
            frame = :frame, lensa = :lensa, r_sph = :r_sph, r_cyl = :r_cyl, r_as = :r_as, l_sph = :l_sph, l_cyl = :l_cyl, l_as = :l_as, 
            add_lens = :add_lens, pd_jauh = :pd_jauh, pd_dekat = :pd_dekat, jumlah = :jumlah, uang_muka = :uang_muka, metode_dp = :metode_dp, sisa = :sisa
            WHERE id = :id";

        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':tanggal' => $data['tanggal'] ?? date('Y-m-d'),
            ':no_nota' => $data['no_nota'] ?? '',
            ':nama' => $data['nama'] ?? '',
            ':no_hp' => $data['no_hp'] ?? '',
            ':resep_dari' => $data['resep_dari'] ?? '',
            ':frame' => $data['frame'] ?? '',
            ':lensa' => $data['lensa'] ?? '',
            ':r_sph' => $data['r_sph'] ?? '',
            ':r_cyl' => $data['r_cyl'] ?? '',
            ':r_as' => $data['r_as'] ?? '',
            ':l_sph' => $data['l_sph'] ?? '',
            ':l_cyl' => $data['l_cyl'] ?? '',
            ':l_as' => $data['l_as'] ?? '',
            ':add_lens' => $data['add_lens'] ?? '',
            ':pd_jauh' => $data['pd_jauh'] ?? '',
            ':pd_dekat' => $data['pd_dekat'] ?? '',
            ':jumlah' => $data['jumlah'] ?? 0,
            ':uang_muka' => $data['uang_muka'] ?? 0,
            ':metode_dp' => $data['metode_dp'] ?? '',
            ':sisa' => $data['sisa'] ?? 0
        ]);
    }

    public static function getAll() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM invoices ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function getById($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM invoices WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
