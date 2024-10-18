<?php
class Common extends DBconn
{
    protected function createPassword($charLen = 8)
    {
        # Password format Xxxx@567

        $letters  = range('a', 'z');
        shuffle($letters);
        $special_chars = range('!', '*');
        shuffle($special_chars);

        $letter_len = round($charLen * 0.5);
        $num_len = round($charLen * 0.4);

        # Create a random no from variable length to create random letter
        $rand_letter = strval(rand(str_repeat('1', $letter_len),  str_repeat('9', $letter_len)));
        $letter_pass = "";

        for ($i = 0; $i <= ($letter_len - 1); $i++) {
            $digit = $rand_letter[$i];
            $index = intval($digit);
            $letter_pass .= $letters[$index];
        }

        # Create a random no from variable length
        $rand_num = strval(rand(str_repeat('1', $num_len),  str_repeat('9', $num_len)));
        # Randomly select a special character
        $special_char = $special_chars[rand(0, 9)];

        # Letter part of the password and make the first char a capital letter
        return ucfirst($letter_pass) . $special_char . $rand_num;
    }

    protected function getRoles()
    {
        $sql = "SELECT * FROM role";
        $result = $this->connect()->prepare($sql);
        $result->execute();
        $numRows = $result->rowCount();

        if ($numRows > 0) {
            $roles = $result->fetchAll(PDO::FETCH_ASSOC);
        }
        return $roles;
    }
}
