<?php
error_reporting(-1);
ini_set('display_errors', 1);


//Include the library
require_once 'lib/AESCryptFileLib.php';

//Include an AES256 Implementation
require_once 'controller/MCryptAES256Implementation.php';

//Construct the implementation
$mcrypt = new MCryptAES256Implementation();

//Use this to instantiate the encryption library class
$lib = new AESCryptFileLib($mcrypt);

//This example encrypts and decrypts the README.md file
$file_to_encrypt = "teste.txt";
$encrypted_file = "teste.txt.aes";
$decrypted_file = "teste.decrypted.txt";

//Ensure target file does not exist
unlink($encrypted_file);
//Encrypt a file
$lib->encryptFile($file_to_encrypt, "1234", $encrypted_file);
//Ensure file does not exist
@unlink($decrypted_file);
//Decrypt using same password
$lib->decryptFile($encrypted_file, "1234", $decrypted_file);

echo "Done";