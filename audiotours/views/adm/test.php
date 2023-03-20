<?php include_once("./views/templates/document-start.php");
$url="https://blog.audiotours.es/wp-json/wp/v2";
$json = json_encode([
    'title' => 'tour ejemplo',
    'content' => '<img class="img-fluid mx-4" src="https://audiotours.es/media/tours/3-jardin-de-floridabalanca.jpg" /><br />Each block has its own block-specific controls that allow you to manipulate the block right in the editor. The classic block offers the ability to edit as HTML, duplicate, or convert to blocks :',
    'status' => 'publish',
]);

try {
    $ch = curl_init(POINTISERTPOST);
    curl_setopt($ch, CURLOPT_USERPWD, USERWP.':'.PASSWORDAPLICATIONWP);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    $result = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    print_r(json_decode($result));
} catch(Exception $e) {
    echo $e->getMessage();
}


echo "test enviado ".USERWP.", contraseña: ".PASSWORDAPLICATIONWP;


 


include_once("./views/templates/document-end.php");?>