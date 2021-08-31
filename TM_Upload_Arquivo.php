<?php
/*
* Plugin Name: TM Upload Arquivo
* Plugin URI: http://exemplo.com
* Description:
*/   
if(!defined('ABSPATH')){
    exit;
}
if(! function_exists('upload_arquivo')){
function upload_arquivo(){
        add_menu_page('Forms','Upload Arquivo','manage_options','Upload-admin-menu','upload_arquivo_main','dashicons-media-archive',6);
    }
    add_action('admin_menu','upload_arquivo');
    function upload_arquivo_main(){
        echo'
        <div class="conteudo-upload-pdf">
            <h2>Upload de Arquivos</h2>
            <form class="enviar-pdf" method="post" enctype="multipart/form-data" >

                <p> 1- Escolha o arquivo.</p>
                <input id="id_upload" type="file" name="file" required><br/>
                
                <p> 2- Digite o nome do arquivo seguindo as orientações (ano+mês+seguro+produto+versão). <br/>Ex: 202104-seguroempresarial-v1</p>
                <input name="img" type="text" />

                <p> 3- Clique em enviar para alterar o nome e Clique no botão verde para copiar o endereço do link do arquivo</p>
                <input type="submit" name="upload_file" value="Enviar">      
            </form>
        </div>
        <style>.conteudo-upload-pdf{padding-top: 50px;padding-left: 30px;} #wpbody-content{background:#fff;}   .enviar-pdf{padding-top: 10px;margin-bottom: 10px!important;}.pdf-url{margin-left:30px; width:600px}        .copiar{background-color: #117F63;color: #fff;padding: 7px;border-radius: 7px;border: none;} .conteudo-upload-pdf p{ margin-bottom: 1px; font-size: 14px;font-weight: 500;}</style>

        ';
        if ( isset($_POST['upload_file']) ) {
            $upload_dir = wp_upload_dir();
            $name_img = $_FILES['file']['name'];
            $extension = pathinfo($name_img, PATHINFO_EXTENSION);
            if ( ! empty( $upload_dir['basedir'] ) ) {
                $user_dirname = $upload_dir['basedir'].'/PDF';
                if ( ! file_exists( $user_dirname ) ) {
                    wp_mkdir_p( $user_dirname );
                }           
                $filename = wp_unique_filename( $user_dirname, $_POST['img'].'.'.$extension );
                move_uploaded_file($_FILES['file']['tmp_name'], $user_dirname .'/'. $filename);      
            }
            unset($_POST["upload_file"]);
            $uploads = wp_upload_dir();
            ?>
            <p class="pdf-url" style="font-size: 14px;font-weight: 500;margin-bottom: 1px;"> 4- Clique no botão verde para copiar o endereço do link do arquivo</p>
            <input class="pdf-url" type="text" value=" <?php echo $uploads['baseurl']. '/PDF/'. $filename ;?>" id="myInput">
            <button class="copiar" id="copiar" onclick="myFunction()">Clique para copiar</button>
        <?php
        }
    }
}
?>
<script>
    function myFunction() {
    var copyText = document.getElementById("myInput");
    copyText.select();
    copyText.setSelectionRange(0, 99999)
    document.execCommand("copy");
    document.getElementById("copiar").innerHTML = "Endereço copiado!"
    }
</script>