<?php

class RefreshTokenGateway
{
    private PDO $conn;
    private string $key;

    public function __construct(Database $database, string $key)
    {
        $this->conn = $database->getConnection();
        $this->key = $key;
    }

    public function create(string $token, int $expiry): bool
    {
        $hash = hash_hmac("sha256", $token, $this->key);

        $sql = "INSERT INTO INB_REFRESH_TOKEN(TOKEN_HASH, EXPIRES_AT)
                VALUES (:token_hash, :expires_at)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":token_hash", $hash, PDO::PARAM_STR);
        $stmt->bindValue(":expires_at", $expiry, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete(string $token): int
    {
        $hash = hash_hmac("sha256", $token, $this->key);

        $sql = "DELETE FROM INB_REFRESH_TOKEN
                WHERE TOKEN_HASH = :token_hash";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":token_hash", $hash, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->rowCount();
    }
}