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
        return $this->loginModel->verifyCredentials($email, $password);
    }

    # Change password on password change
    public function changePassword($user_id, $password)
    {
        return $this->loginModel->updatePassword($user_id, $password);
    }

    # Update Account Status on password change
    public function changeVerification($tid)
    {
        return $this->loginModel->updateVerification($tid);
    }

    # Check if email address exist 
    public function checkEmail($email)
    {
        return $this->loginModel->verifyEmail($email);
    }

    # Create new Password reset request
    public function createPasswordResetReq($user_id)
    {
        return $this->loginModel->newPasswordResetReq($user_id);
    }

    # Validate if password reset token is valid for a given token
    public function checkUIDToken($token)
    {
        $fetch = $this->loginModel->verifyUIDToken($token);
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
