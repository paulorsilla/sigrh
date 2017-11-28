<?php
namespace SigRH\Service;

class FileUpload {
    
    public function __construct(){ //$serviceInst
    }
    
    public function uploadPonto($file) {
        error_log("Uploading... ");

        $fileName = $file['tmp_name'];

        $ponteiro = fopen ( $fileName, 'r' );
	while ( ! feof ( $ponteiro ) ) {
            $linha = fgets($ponteiro);
            error_log($linha);
        }

    }
    
}
