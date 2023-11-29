<?php
$caminhoArquivo = 'work.xml';
$caminhoArquivoSalvo = 'savedWork.xml';

$xml = file_get_contents($caminhoArquivo);

if ($xml !== false) {
  $arquivoSalvo = fopen($caminhoArquivoSalvo, 'w');
  
  if ($arquivoSalvo) {
    if (fwrite($arquivoSalvo, $xml) === false) {
      echo 'Erro ao escrever no arquivo';
    } else {
      echo 'Conteúdo do arquivo "work.xml" salvo com sucesso em "savedWork.xml"';
    }
    
    fclose($arquivoSalvo);
  } else {
    echo 'Erro ao abrir o arquivo para escrita';
  }
} else {
  echo 'Erro ao ler o arquivo "work.xml"';
}
