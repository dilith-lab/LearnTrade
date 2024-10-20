<?php
class Wallet extends DBconn
{
    # Get Wallet Balance from user_id
    protected function getWalletBalance($user_id)
    {

        try {

            $sql = "SELECT * FROM wallet WHERE user_id=?";

            $pdo = $this->connect();
            $statement = $pdo->prepare($sql);

            $statement->bindValue(1, $user_id);

            $statement->execute();
            $rowCount = $statement->rowCount();
            $fetch = $statement->fetch(PDO::FETCH_ASSOC);
            if ($rowCount > 0) {
                $pdo = null;
                return $fetch;
            }
        } catch (PDOException $e) {
            throw $e;
        }
    }
    
}
