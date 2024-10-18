<?php
require_once __DIR__ . "/../models/login.model.php";
class LoginContr extends Login
{
    private $loginModel;

    public function __construct(Login $loginModel)
    {
        $this->loginModel = $loginModel;
    }

    # Login Module
    # Check if username and password is valid 
    public function checkCredentials($email, $password)
    {
        $login = new Login;
        $fetch = $login->verifyCredentials($email, $password);
        return $fetch;
    }

    # Change password on password change
    public function changePassword($user_id, $password)
    {
        $login = new Login;
        $fetch = $login->updatePassword($user_id, $password);
        return $fetch;
    }

    # Update Account Status on password change
    public function changeVerification($tid)
    {
        $login = new Login;
        $fetch = $login->updateVerification($tid);
        return $fetch;
    }

    # Check if email address exist 
    public function checkEmail($email)
    {
        $login = new Login;
        $fetch = $login->verifyEmail($email);
        return $fetch;
    }

    # Create new Password reset request
    public function createPasswordResetReq($user_id)
    {
        $login = new Login;
        $fetch = $login->newPasswordResetReq($user_id);
        return $fetch;
    }

    # Validate if password reset token is valid for a given token
    public function checkUIDToken($token)
    {
        $login = new Login;
        $fetch = $login->verifyUIDToken($token);
        #echo "Current Time: " . $current_timestamp = date('Y-m-d H:i:s', time());
        #echo "Expire Time : " . $expire_timestamp = $fetch['expiration_time'];
        $current_timestamp = date('Y-m-d H:i:s', time());
        $expire_timestamp = $fetch['expiration_time'];

        if ($current_timestamp < $expire_timestamp) {
            return array('token_valid' => True, 'user_id' => $fetch['user_id']);
        } else {
            return array('token_valid' => False, 'user_id' => $fetch['user_id']);
        }
    }


    public function sendMail($template, $email, $token)
    {
        $to = $email;
        $subject = "Password Reset Link";
        $message = str_replace('{token}', $token, $template);
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // Set sender display name and email address
        $headers .= 'From: RoshChem EMS Admin <roshchem.admin@tastyrolling.com>' . "\r\n";

        try {
            mail(
                $to,
                $subject,
                $message,
                $headers
            );
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
