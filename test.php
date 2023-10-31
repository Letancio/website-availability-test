<?php
$domain = 'itiuba.ba.gov.br';

$startTime = microtime(true); // Marca o tempo de início da requisição

// Obtém o endereço IP do domínio
$ip = gethostbyname($domain);

// Realiza uma requisição HTTP para o servidor (substitua a URL pelo seu próprio servidor)
$ch = curl_init("http://$domain/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

$endTime = microtime(true); // Marca o tempo de término da requisição

// Calcula o tempo de resposta em milissegundos
$responseTime = ($endTime - $startTime) * 1000;

// Define critérios para avaliar o desempenho
if ($responseTime < 100) {
    $performance = "Rápido";
} elseif ($responseTime < 500) {
    $performance = "Aceitável";
} elseif ($responseTime < 1000) {
    $performance = "Lento";
} else {
    $performance = "Ruim";
}

// Nome do arquivo de log (substitua pelo caminho e nome desejado)
$logFileName = $domain . 'log.txt';

// Formatação do log
$logEntry = date('Y-m-d H:i:s') . " - Domínio: $domain (IP: $ip) - Tempo de resposta: {$responseTime} ms - Desempenho: {$performance}\n";

// Executa traceroute ou tracert com base no sistema
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $tracerouteOutput = shell_exec("tracert $domain");
} else {
    $tracerouteOutput = shell_exec("traceroute $domain");
}

// Adiciona as informações do traceroute ou tracert ao log
$logEntry .= "Resultado do Traceroute/Tracert:\n$tracerouteOutput\n";

// Escreve o log no arquivo
file_put_contents($logFileName, $logEntry, FILE_APPEND);

// Fecha a conexão cURL
curl_close($ch);
?>
