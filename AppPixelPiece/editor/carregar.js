// Importar a biblioteca Blockly
import * as Blockly from 'blockly';

// Função para converter o XML para a configuração dos blocos
function convertXmlToBlocks() {
  const xmlFile = 'savedWork.xml';
  const xmlHttp = new XMLHttpRequest();
  
  xmlHttp.onreadystatechange = function() {
    if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
      const xmlText = xmlHttp.responseText;
      const xmlDoc = Blockly.Xml.textToDom(xmlText);
      const workspace = new Blockly.Workspace();
      Blockly.Xml.domToWorkspace(xmlDoc, workspace);
      
      // Obter a configuração dos blocos no formato JSON
      const blocks = [];
      const topBlocks = workspace.getTopBlocks();
      
      for (const block of topBlocks) {
        blocks.push(recursiveBlockToJson(block));
      }
      
      console.log(blocks);
    }
  };
  
  xmlHttp.open('GET', xmlFile, true);
  xmlHttp.send();
}

// Função auxiliar para converter um bloco em JSON
function recursiveBlockToJson(block) {
  // Implementação da função recursiveBlockToJson conforme o exemplo anterior
}

// Chamar a função para converter o XML para a configuração dos blocos
convertXmlToBlocks();
