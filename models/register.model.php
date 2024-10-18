<?php

class Register extends DBconn {

    // Function to check if email already exists
    protected function checkEmailExists($email) {
        try {
            $sql = "SELECT * FROM user WHERE email = ?";

            $pdo = $this->connect();
            $statement = $pdo->prepare($sql);
            $statement->bindValue(1, $email);
            $statement->execute();

            // Return true if email exists, false otherwise
            return $statement->rowCount() > 0;

        } catch (PDOException $e) {
            throw $e;
        }
    }

    // Function to register a new user
    protected function registerUser($fname, $lname, $email, $mobile, $password_hash) {
    
        $pdo = $this->connect();  // Establish the connection first
        
        try {
            // Begin the transaction
            $pdo->beginTransaction();

            // Insert into user table
            $sql_user = "INSERT INTO user (fname, lname, mobile, email, account_status, role_id) 
                        VALUES (?, ?, ?, ?, ?, ?)";
            
            $statement = $pdo->prepare($sql_user);
            $default_role = DEFAULT_ROLE;

            $statement->bindValue(1, $fname);
            $statement->bindValue(2, $lname);
            $statement->bindValue(3, $mobile);
            $statement->bindValue(4, $email);
            $statement->bindValue(5, 1); // Default account status
            $statement->bindValue(6, $default_role);

            // Execute user insertion
            $statement->execute();
            $user_id = $pdo->lastInsertId();

            // Insert into login table
            $sql_login = "INSERT INTO login (user_id, password, is_verified) 
                        VALUES (?, ?, 0)"; // is_verified can be handled separately, initially set to 0

            $statement_login = $pdo->prepare($sql_login);
            $statement_login->bindValue(1, $user_id);
            $statement_login->bindValue(2, $password_hash);

            // Execute login insertion
            $statement_login->execute();

            // Commit the transaction if both inserts succeed
            $pdo->commit();

            return $user_id;

        } catch (Exception $e) {
            // Rollback the transaction if any error occurs
            if ($pdo->inTransaction()) {
                $pdo->rollBack();  // Only rollback if a transaction is active
            }
            // Log the error or handle as needed (for security, avoid displaying raw errors in production)
            error_log("Error in registration transaction: " . $e->getMessage());

            return false;  // Return false to indicate failure
        }
    }

}

?>
