<?php

class Login extends DBconn
{

    # Create a Random Token
    protected function generateRandomToken($length = 64)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';

        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[random_int(0, $max)];
        }

        return $token;
    }

    # Login Module 
    # Check if username and password is valid on employee table
    protected function verifyCredentials($email, $password)
    {

        try {
            $pass = "password";

            $sql = "SELECT * FROM user
                    JOIN login
                    ON user.user_id = login.user_id
                    JOIN role
                    ON user.role_id = role.role_id
                    WHERE email=? AND $pass=?";

            $pdo = $this->connect();
            $statement = $pdo->prepare($sql);

            $statement->bindValue(1, $email);
            $statement->bindValue(2, $password);

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

    # Update password on employee table on password change
    protected function updatePassword($user_id, $password)
    {

        try {
            $pass = "password";

            $sql = "UPDATE login SET $pass=? WHERE user_id=?";
            $pdo = $this->connect();
            $statement = $pdo->prepare($sql);

            $statement->bindValue(1, $password);
            $statement->bindValue(2, $user_id);

            $statement->execute();

            $login_id = $pdo->lastInsertId();
            return $login_id;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    # Update Account status to '2'
    # '0' - Inactive
    # '1' - Active; Password reset required
    # '2' - Active; Password reset done
    protected function updateVerification($user_id, $account_status = 2)
    {

        try {
            $sql = "UPDATE user SET account_status=? WHERE user_id=?";
            $pdo = $this->connect();
            $statement = $pdo->prepare($sql);

            $statement->bindValue(1, $account_status);
            $statement->bindValue(2, $user_id);

            $statement->execute();

            $login_id = $pdo->lastInsertId();
            return $login_id;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    # Check if email address exist in Employee table 
    protected function verifyEmail($email)
    {

        try {
            $sql = "SELECT user_id FROM user
                    WHERE email=?";

            $pdo = $this->connect();
            $statement = $pdo->prepare($sql);

            $statement->bindValue(1, $email);

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

    # Update Password reset token table
    protected function newPasswordResetReq($user_id)
    {
        try {
            $sql = "INSERT INTO passwordresettoken(user_id, token, expiration_time, ip) VALUES (?, ?, ?, ?)";
            $pdo = $this->connect();
            $statement = $pdo->prepare($sql);

            # Generate a token
            $randomToken = $this->generateRandomToken(64);

            $token_exp_time = TOKEN_EXP_TIME;

            # Calculate token expiration time
            $token_expiration_time = date('Y-m-d H:i:s', strtotime("+{$token_exp_time} minutes", time()));

            # Check remote IP address
            $ip = $_SERVER['REMOTE_ADDR'];

            $statement->bindValue(1, $user_id);
            $statement->bindValue(2, $randomToken);
            $statement->bindValue(3, $token_expiration_time);
            $statement->bindValue(4, $ip);

            $statement->execute();

            return $randomToken;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    # Check the UID for the corresponding token and token expiration time
    protected function verifyUIDToken($token)
    {

        try {
            $sql = "SELECT user.user_id, passwordresettoken.expiration_time FROM user
                    JOIN passwordresettoken
                    ON user.user_id = passwordresettoken.user_id
                    WHERE token=?";

            $pdo = $this->connect();
            $statement = $pdo->prepare($sql);

            $statement->bindValue(1, $token);

            $statement->execute();
            $rowCount = $statement->rowCount();
            $fetch = $statement->fetch(PDO::FETCH_ASSOC);
            if (
                $rowCount > 0
            ) {
                $pdo = null;
                return $fetch;
            }
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
