<?php
class AesCode2 {

static function  encrypt_mcrypt($msg, $iv = null) {
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        if (!$iv) {
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        }
        $pad = $iv_size - (strlen($msg) % $iv_size);
        $msg .= str_repeat(chr($pad), $pad);
        $encryptedMessage = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, SECURE_KEY, $msg, MCRYPT_MODE_CBC, $iv);
        return base64_encode($iv . $encryptedMessage);
    }
static function decrypt_mcrypt($payload ) {
        $raw = base64_decode($payload);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = substr($raw, 0, $iv_size);
        $data = substr($raw, $iv_size);
        $result = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, SECURE_KEY, $data, MCRYPT_MODE_CBC, $iv);
        $ctrlchar = substr($result, -1);
        $ord = ord($ctrlchar);
        if ($ord < $iv_size && substr($result, -ord($ctrlchar)) === str_repeat($ctrlchar, $ord)) {
            $result = substr($result, 0, -ord($ctrlchar));
        }
        return $result;
    }

    static  function encrypt_openssl($msg , $iv = null) {
        $iv_size = openssl_cipher_iv_length('AES-128-CBC');
        if (!$iv) {
            $iv = openssl_random_pseudo_bytes($iv_size);
        }
        $encryptedMessage = openssl_encrypt($msg, 'AES-128-CBC', SECURE_KEY, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encryptedMessage);
    }
static function decrypt_openssl($payload ) {
        $raw = base64_decode($payload);
        $iv_size = openssl_cipher_iv_length('AES-128-CBC');
        $iv = substr($raw, 0, $iv_size);
        $data = substr($raw, $iv_size);
        return openssl_decrypt($data, 'AES-128-CBC', SECURE_KEY, OPENSSL_RAW_DATA, $iv);
    }

    function  test()
    {
        $json = ''; // your data for encrypt
        $key = ''; // your key for encrypt

        $cipher = "AES-128-CBC";
        $options = OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING;

        $ivSize = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivSize);

        $cipherText = openssl_encrypt(pad_zero($json), $cipher, $this->key, $options, $iv);
        $cipherText = $iv . $cipherText;
        return $cipherText;

    }
    public function pad_zero($data)
    {
        $len = 16;
        if (strlen($data) % $len) {
            $padLength = $len - strlen($data) % $len;
            $data .= str_repeat("\0", $padLength);
        }
        return $data;
    }
}
