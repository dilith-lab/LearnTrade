<?php
require_once __DIR__ . "/../models/register.model.php";
class RegisterContr extends Register
{

    private $registerModel;

    // Constructor initializes the model internally
    public function __construct()
    {
        // Instantiate the Register model inside the constructor
        $this->registerModel = new Register();
    }

    public function register($fname, $lname, $email, $mobile, $password_hash)
    {
        try {
            // Check if email already exists
            if ($this->registerModel->checkEmailExists($email)) {
                return ['status_code' => 400, 'message' => 'Email already exists.'];
            }

            // Register user if email does not exist
            $user_id = $this->registerModel->registerUser($fname, $lname, $email, $mobile, $password_hash);

            // Return success or failure message
            if ($user_id) {
                return ['status_code' => 100, 'message' => 'Registration successful!'];
            } else {
                return ['status_code' => 400, 'message' => 'Registration failed.'];
            }

        } catch (Exception $e) {
            return ['status_code' => 400, 'message' => $e->getMessage()];
        }
    }
}
