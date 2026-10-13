
<?php
require_once __DIR__ . "/../database.php";

class NhaPhatHanh
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    
    public function getAll()
    {
        $sql = "SELECT * FROM NhaPhatHanh
                ORDER BY MaNhaPhatHanh DESC";

        return $this->pdo->query($sql)
                         ->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getById($id)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM NhaPhatHanh
             WHERE MaNhaPhatHanh = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($ten, $quocGia, $email, $website)
    {
        $sql = "INSERT INTO NhaPhatHanh
                (TenNhaPhatHanh, QuocGia, Email, Website)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $ten,
            $quocGia,
            $email,
            $website
        ]);
    }

    public function update($id, $ten, $quocGia, $email, $website, $trangThai)
    {
        $sql = "UPDATE NhaPhatHanh
                SET TenNhaPhatHanh = ?,
                    QuocGia = ?,
                    Email = ?,
                    Website = ?,
                    TrangThai = ?
                WHERE MaNhaPhatHanh = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $ten,
            $quocGia,
            $email,
            $website,
            $trangThai,
            $id
        ]);
    }

    
    public function delete($id)
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM NhaPhatHanh
             WHERE MaNhaPhatHanh = ?"
        );

        return $stmt->execute([$id]);
    }

   
    public function search($keyword)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM NhaPhatHanh
             WHERE TenNhaPhatHanh LIKE ?
                OR QuocGia LIKE ?
             ORDER BY MaNhaPhatHanh DESC"
        );

        $keyword = "%" . $keyword . "%";
        $stmt->execute([$keyword, $keyword]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
