<?php
require "../models/common.model.php";

class CommonContr extends Common
{
    private $commonModel;
    public function __construct(Common $commonModel)
    {
        $this->commonModel = $commonModel;
    }
    public function generatePassword($charLen)
    {
        return $this->commonModel->createPassword($charLen);
    }

    public function viewRoles()
    {
        return $this->commonModel->getRoles();
    }

    public function viewWalletBalance($user_id)
    {
        return $this->commonModel->getWalletBalance($user_id);
    }
}
