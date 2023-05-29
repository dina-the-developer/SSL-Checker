<?php  

if(empty($_POST['domain'])){
    echo json_encode("Domain empty!!!");
}else{

    $hostname = $_POST['domain'];

    //echo (json_encode($domain));
    $output=null;
    $retval=null;
    exec('openssl s_client -connect '.$hostname.':443 </dev/null 2>/dev/null | openssl x509 -inform pem -text', $output, $retval);
    
    //exec('openssl s_client -connect google.com:443 -showcerts </dev/null | openssl x509 -inform pem > googlecert.pem -text', $output, $retval);

    //echo "Returned with status $retval and output:\n";
    echo json_encode($output);

}
?>