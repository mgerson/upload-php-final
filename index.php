<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/xhtml1-strict.dtd">
<html >

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>jQuery</title>
        <style>
            h2{
                text-align:center;
                color: #1A5018;
            }



        </style>
    </head>
    <body>
        <h2>Upload de Ficheiros</h2>
        
       
            <?php
            if (array_key_exists('upload', $_POST)) {
                // print_r($_FILES); imprime informacao legivel a humanos sobre uma variavel 

                define('MAX_FILE_SIZE', 100000);
                //$_files e um array com todos os ficheiros carregados, ao carregar o ficheiro fica num arquivo temporario
                $path = dirname(__FILE__);
                $up_dir = $path . '/uploads/';

                $file = ($_FILES['image']['name']); //nome do arquivo original

                $extension = pathinfo($file, PATHINFO_EXTENSION); //pegar a extensao do arquivo
                $fileName = date('Y') . date('m') . date('d').'_' . time() . '.' . $extension; //definir um novo nome para o arquivo
                $filesize = false;
                $typeOK = false;
                $types = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');
                if ($_FILES['image']['size'] > 0 && $_FILES['image']['size'] <= MAX_FILE_SIZE) {
                    $filesize = TRUE;
                }
                foreach ($types as $type) {
                    if ($type == $_FILES['image']['type']) {
                        $typeOK = true;
                        break;
                    }
                }

                if ($filesize && $typeOK) {
                    switch ($_FILES['image']['error']) {
                        case 0:
                            $sucesso = move_uploaded_file($_FILES['image']['tmp_name'], $up_dir . $fileName); //mover o arquivo carregado do arquivo temporario para outro sitio
                            if ($sucesso) {
                                $mensagem = 'Ficheiro carregado com sucesso';
                            } else {
                                $mensagem = 'erro ao tentar gravar o ficheiro, por favor tetar de novo!';
                            }
                            break;


                        case 3:
                            $mensagem = 'Erro ao carregar ficheiro...';
                            break;


                        default:
                            break;
                    }
                } else if ($_FILES['image']['error'] == 4) {
                    $mensagem = 'Nenhum ficheiro seleccionado';
                } elseif (!$filesize) {
                    $mensagem = 'O ficheiro seleccionado e muito maior...';
                } elseif (!$typeOK) {
                    $mensagem = 'So podem ser carregados ficheiros do tipo imagem: gif, jpg, png';
                }
                //verificar se ocoreu algum erro e imprimir a devida mensagem
//*********Error level Meaning****************//
//0 Upload successful
//1 File exceeds maximum upload size specified in php.ini (default 2MB)
//2 File exceeds size specified by MAX_FILE_SIZE embedded in the form
//(see PHP Solution 6-3)
//3 File only partially uploaded
//4 Form submitted with no file specified
//5 Currently not defined
//6 No temporary folder (PHP 4.3.10 and 5.0.3 and above)
//7 Cannot write file to disk (PHP 5.1.0 and above)
                //  echo 'o CAMINHO ABSOLUTO DO PEOJECTO EH: ' . $path;
            }
            ?>
       <center>
            <fieldset>
                <legend align="center">Upload a File to a server</legend>
                <form action="" method="post" enctype="multipart/form-data" name="uploadImage" id="uploadImage">
                    <p>
                        <h4>
                            <?php
                            if(isset($mensagem)){
                                echo $mensagem;
                            }
                            ?>
                        </h4>
                    </p>
                    <p><img src="<?php echo './uploads/'. $fileName; ?>" width="200px" height="200px" style="position: relative"/></p>
                    <p>
                        <label for="image">Upload image:</label>                        
                        <input type="file" name="image" id="image" />

                    </p>
                    <p>
                        <input type="submit" name="upload" id="upload" value="Upload" />
                    </p>
                </form>
            </fieldset>
        </center>
    </body>

</html>