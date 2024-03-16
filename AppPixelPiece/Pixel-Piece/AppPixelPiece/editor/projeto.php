<html>

<head>

    <title>Pixel Piece</title>

    <script src="https://unpkg.com/blockly/blockly.min.js"></script>

    <script src="https://unpkg.com/blockly/blocks/procedures.js"></script>

    <script src="https://unpkg.com/blockly/blocks/logic.js"></script>

    <script src="https://unpkg.com/blockly/blocks/text.js"></script>

    <script src="https://unpkg.com/blockly/blocks/lists.js"></script>

    <script src="https://unpkg.com/blockly/blocks/variables.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/blockly/blockly.css" />

    <style>
        body {
            background-color: rgb(30, 30, 40);
        }

        #blocklyDiv {
            width: 100%;
            height: 700px;
            margin-right: 1px;
            border: solid grey 2px;
            float: left;
        }

        #codeDiv {
            width: 100%;
            height: 700px;
            overflow: scroll;
            border: solid grey 2px;
            white-space: pre-wrap;
            font-family: monospace;
        }

        #gamescreen {
            overflow: scroll;
            width: 100%;
            height: 700px;
            border: solid grey 2px;
        }

        .blocklyToolboxDiv .blocklyTreeRow:not(.blocklyTreeSelected):hover {
            background-color: #e4e4e4;
        }

        .blocklyToolboxDiv .blocklyTreeRow.blocklyTreeSelected:hover {
            background-color: #f0f0f0;
        }

        .blocklyToolboxDiv .blocklyTreeIconClosed {
            background-image: url("https://www.gstatic.com/blockly/demos/blockfactory/texthtml/trashcan_closed.svg");
        }

        .blocklyToolboxDiv .blocklyTreeIconOpen {
            background-image: url("https://www.gstatic.com/blockly/demos/blockfactory/texthtml/trashcan_open.svg");
        }

        .blocklyToolboxDiv .blocklyTreeIconClosed {
            background-image: url("images/trashcan_closed.svg");
        }

        .blocklyToolboxDiv .blocklyTreeIconOpen {
            background-image: url("images/trashcan_open.svg");
        }
    </style>

<script>
    //constrói o bloco when key pressed na workspace
    Blockly.Blocks['when_key_pressed'] = {
        init: function() {
            this.uniqueId_ = Math.random().toString(36).substr(2, 9);
            this.appendDummyInput()
                .appendField("When the")
                .appendField(new Blockly.FieldDropdown([
                    ["A", "65"],
                    ["B", "66"],
                    ["C", "67"],
                    ["D", "68"],
                    ["E", "69"],
                    ["F", "70"],
                    ["G", "71"],
                    ["H", "72"],
                    ["I", "73"],
                    ["J", "74"],
                    ["K", "75"],
                    ["L", "76"],
                    ["M", "77"],
                    ["N", "78"],
                    ["O", "79"],
                    ["P", "80"],
                    ["Q", "81"],
                    ["R", "82"],
                    ["S", "83"],
                    ["T", "84"],
                    ["U", "85"],
                    ["V", "86"],
                    ["W", "87"],
                    ["X", "88"],
                    ["Y", "89"],
                    ["Z", "90"]
                ]), "TECLA");
            this.appendDummyInput()
                .appendField("key is pressed do :");
            this.appendStatementInput("MENSAGEM")
                .setCheck(null);
            this.setColour(230);
            this.setTooltip('');
            this.setHelpUrl('http://www.example.com/');
            var idField = new Blockly.FieldTextInput(this.uniqueId_);
            idField.setVisible(true);
            this.appendDummyInput()
                .appendField(idField, "ID")
                .setVisible(true);
        },
        customContextMenu: function(options) {
            // Add option to duplicate block with new unique ID
            var option = {
                enabled: true
            };
            var block = this;
            option.text = "Duplicate with new ID";
            option.callback = function() {
                var newBlock = block.workspace.newBlock('when_key_pressed');
                newBlock.initSvg();
                newBlock.render();
                // Generate new unique ID
                newBlock.uniqueId_ = Math.random().toString(36).substr(2, 9);
                newBlock.getField('ID').setValue(newBlock.uniqueId_);
                // Copy the rest of the block's fields
                newBlock.getField('TECLA').setValue(block.getFieldValue('TECLA'));
                newBlock.getInput('MENSAGEM').connection.connect(block.getInput('MENSAGEM').connection.targetConnection);
            };
            options.push(option);
        }
    };

    Blockly.JavaScript['when_key_pressed'] = function(block) {
        var dropdown_tecla = block.getFieldValue('TECLA');
        var keyCode = parseInt(dropdown_tecla);
        var statements_mensagem = Blockly.JavaScript.statementToCode(block, 'MENSAGEM');
        var uniqueId = block.getFieldValue('ID') || block.uniqueId_;
        var functionName = 'when_key_pressed_' + uniqueId;
        var code = 'function ' + functionName + '(event) {\n  if (event.keyCode === ' + keyCode + ') {\n    ' + statements_mensagem + '\n  }\n}\n\n';
        code += 'document.addEventListener("keydown", ' + functionName + ');\n';
        return code;
    };

    Blockly.Blocks['wait'] = {
  init: function() {
    this.appendValueInput('TIME')
        .setCheck('Number')
        .appendField('wait for');
    this.setPreviousStatement(true, null);
    this.setNextStatement(true, null);
    this.setColour(230);
    this.setTooltip('Wait for a specific amount of time');
    this.setHelpUrl('');
  }
};
Blockly.JavaScript['wait'] = function(block) {
  var time = Blockly.JavaScript.valueToCode(block, 'TIME', Blockly.JavaScript.ORDER_ATOMIC);
  var code = 'await new Promise(resolve => setTimeout(resolve, ' + time + ' * 1000));\n';
  return code;
};


    Blockly.Blocks['move_item'] = {
        init: function() {
            this.appendDummyInput()
                .appendField("Move")
                .appendField(new Blockly.FieldTextInput("item"), "itemId")
                .appendField("to (")
                .appendField(new Blockly.FieldNumber(0), "x")
                .appendField(",")
                .appendField(new Blockly.FieldNumber(0), "y")
                .appendField(")")
                .appendField("with transition")
                .appendField(new Blockly.FieldNumber(0), "transition")
                .appendField("s");
            this.setPreviousStatement(true, null);
            this.setNextStatement(true, null);
            this.setColour(230);
            this.setTooltip("");
            this.setHelpUrl("");
        }
    };

    Blockly.JavaScript['move_item'] = function(block) {
        var itemId = block.getFieldValue('itemId');
        var x = block.getFieldValue('x');
        var y = block.getFieldValue('y');
        var transition = block.getFieldValue('transition');
        var code = 'move_item("' + itemId + '", ' + x + ', ' + y + ', ' + transition + ');\n';
        return code;
    };
</script>

</head>

 <script>
    //constrói o bloco when key pressed na workspace
    Blockly.Blocks['when_key_pressed'] = {
        init: function() {
            this.uniqueId_ = Math.random().toString(36).substr(2, 9);
            this.appendDummyInput()
                .appendField("When the")
                .appendField(new Blockly.FieldDropdown([
                    ["A", "65"],
                    ["B", "66"],
                    ["C", "67"],
                    ["D", "68"],
                    ["E", "69"],
                    ["F", "70"],
                    ["G", "71"],
                    ["H", "72"],
                    ["I", "73"],
                    ["J", "74"],
                    ["K", "75"],
                    ["L", "76"],
                    ["M", "77"],
                    ["N", "78"],
                    ["O", "79"],
                    ["P", "80"],
                    ["Q", "81"],
                    ["R", "82"],
                    ["S", "83"],
                    ["T", "84"],
                    ["U", "85"],
                    ["V", "86"],
                    ["W", "87"],
                    ["X", "88"],
                    ["Y", "89"],
                    ["Z", "90"]
                ]), "TECLA");
            this.appendDummyInput()
                .appendField("key is pressed do :");
            this.appendStatementInput("MENSAGEM")
                .setCheck(null);
            this.setColour(230);
            this.setTooltip('');
            this.setHelpUrl('http://www.example.com/');
            var idField = new Blockly.FieldTextInput(this.uniqueId_);
            idField.setVisible(true);
            this.appendDummyInput()
                .appendField(idField, "ID")
                .setVisible(true);
        },
        customContextMenu: function(options) {
            // Add option to duplicate block with new unique ID
            var option = {
                enabled: true
            };
            var block = this;
            option.text = "Duplicate with new ID";
            option.callback = function() {
                var newBlock = block.workspace.newBlock('when_key_pressed');
                newBlock.initSvg();
                newBlock.render();
                // Generate new unique ID
                newBlock.uniqueId_ = Math.random().toString(36).substr(2, 9);
                newBlock.getField('ID').setValue(newBlock.uniqueId_);
                // Copy the rest of the block's fields
                newBlock.getField('TECLA').setValue(block.getFieldValue('TECLA'));
                newBlock.getInput('MENSAGEM').connection.connect(block.getInput('MENSAGEM').connection.targetConnection);
            };
            options.push(option);
        }
    };

    Blockly.JavaScript['when_key_pressed'] = function(block) {
        var dropdown_tecla = block.getFieldValue('TECLA');
        var keyCode = parseInt(dropdown_tecla);
        var statements_mensagem = Blockly.JavaScript.statementToCode(block, 'MENSAGEM');
        var uniqueId = block.getFieldValue('ID') || block.uniqueId_;
        var functionName = 'when_key_pressed_' + uniqueId;
        var code = 'function ' + functionName + '(event) {\n  if (event.keyCode === ' + keyCode + ') {\n    ' + statements_mensagem + '\n  }\n}\n\n';
        code += 'document.addEventListener("keydown", ' + functionName + ');\n';
        return code;
    };

    Blockly.Blocks['move_item'] = {
        init: function() {
            this.appendDummyInput()
                .appendField("Move ")
                .appendField(new Blockly.FieldTextInput("item"), "obj")
                .appendField(new Blockly.FieldDropdown([
                    ["Left", "1"],
                    ["Right", "2"],
                    ["Up", "3"],
                    ["Down", "4"]
                ]), "NAME");
            this.appendValueInput("distance")
                .setCheck("Number")
                .setAlign(Blockly.ALIGN_RIGHT)
                .appendField("Distance");
            this.appendValueInput("transition")
                .setCheck("Number")
                .setAlign(Blockly.ALIGN_RIGHT)
                .appendField("Transition");
            this.setPreviousStatement(true, null);
            this.setNextStatement(true, null);
            this.setColour(230);
            this.setTooltip("");
            this.setHelpUrl("");
        }
    };

    Blockly.JavaScript['move_item'] = function(block) {
        var text_item = block.getFieldValue('obj');
        var dropdown_directions = block.getFieldValue('NAME');
        var value_distance = Blockly.JavaScript.valueToCode(block, 'distance', Blockly.JavaScript.ORDER_ATOMIC);
        var value_transition = Blockly.JavaScript.valueToCode(block, 'transition', Blockly.JavaScript.ORDER_ATOMIC);

        var code = 'var element = document.getElementById("' + text_item + '");\n';

        if (dropdown_directions == '1') {
            code += 'element.style.left = (parseInt(element.style.left) - ' + value_distance + ') + "px";\n';
        } else if (dropdown_directions == '2') {
            code += 'element.style.left = (parseInt(element.style.left) + ' + value_distance + ') + "px";\n';
        } else if (dropdown_directions == '3') {
            code += 'element.style.top = (parseInt(element.style.top) - ' + value_distance + ') + "px";\n';
        } else if (dropdown_directions == '4') {
            code += 'element.style.top = (parseInt(element.style.top) + ' + value_distance + ') + "px";\n';
        }

        if (value_transition) {
            code += 'element.style.transition = "all ' + value_transition + 's";\n';
        }

        return code;
    };

    Blockly.Blocks['wait'] = {
    init: function() {
        this.appendValueInput("time")
            .setCheck("Number")
            .appendField(new Blockly.FieldLabelSerializable("wait"), "label");
        this.appendStatementInput("code")
            .setCheck(null)
            .appendField("do");
        this.setPreviousStatement(true, null);
        this.setNextStatement(true, null);
        this.setColour(230);
        this.setTooltip("");
        this.setHelpUrl("");
    }
};

Blockly.JavaScript['wait'] = function(block) {
    var time = Blockly.JavaScript.valueToCode(block, 'time', Blockly.JavaScript.ORDER_ATOMIC);
    var code = Blockly.JavaScript.statementToCode(block, 'code');

    code = 'setTimeout(function() {\n' + code + '}, ' + time + ' * 1000);\n';
    return code;
};

var workspace = Blockly.inject('blocklyDiv', {
    media: 'blockly/media/',
    toolbox: document.getElementById('toolbox'),
    zoom: {
        controls: true,
        wheel: true,
        startScale: 1.0,
        maxScale: 3,
        minScale: 0.3,
        scaleSpeed: 1.2
    },
    trashcan: true
});

function runCode() {
    var code = Blockly.JavaScript.workspaceToCode(workspace);
    try {
        eval(code);
    } catch (error) {
        console.error(error);
    }
}

</script>


<body>

    <a href="game.html?v=1" target="telaexecutar"><button>Executar</button></a>

    <center>

        <table width="100%">

            <tr>

                <td width="60%">

                    <div id="gamescreen">

                        <iframe name="telaexecutar" src="game.html" width="100%" height="100%" frameborder="0"></iframe>

                    </div>

                </td>

                <td width="40%">

                    <div id="blocklyDiv">

                        <xml xmlns="https://developers.google.com/blockly/xml" id="toolbox" style="display: none">

                            <category name="Logic" colour="#5b80a5">
                                <block type="controls_if"></block>
                                <block type="logic_compare">
                                    <field name="OP">EQ</field>
                                </block>
                                <block type="logic_operation">
                                    <field name="OP">AND</field>
                                </block>
                                <block type="logic_negate"></block>
                                <block type="logic_boolean">
                                    <field name="BOOL">TRUE</field>
                                </block>
                                <block type="logic_null"></block>
                                <block type="logic_ternary"></block>
                            </category>

                            <category name="Loops" colour="#5ba55b">
                                <block type="controls_repeat_ext">
                                    <value name="TIMES">
                                        <shadow type="math_number">
                                            <field name="NUM">10</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="controls_whileUntil">
                                    <field name="MODE">WHILE</field>
                                </block>
                                <block type="controls_for">
                                    <field name="VAR" id="/EA8TDOp~TMfXh;nAeYY">i</field>
                                    <value name="FROM">
                                        <shadow type="math_number">
                                            <field name="NUM">1</field>
                                        </shadow>
                                    </value>
                                    <value name="TO">
                                        <shadow type="math_number">
                                            <field name="NUM">10</field>
                                        </shadow>
                                    </value>
                                    <value name="BY">
                                        <shadow type="math_number">
                                            <field name="NUM">1</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="controls_forEach">
                                    <field name="VAR" id="vJRf14j)-P,Gwr~5maLQ">j</field>
                                </block>
                                <block type="controls_flow_statements">
                                    <field name="FLOW">BREAK</field>
                                </block>
                            </category>

                            <category name="Math" colour="#5b67a5">
                                <block type="math_number">
                                    <field name="NUM">0</field>
                                </block>
                                <block type="math_arithmetic">
                                    <field name="OP">ADD</field>
                                    <value name="A">
                                        <shadow type="math_number">
                                            <field name="NUM">1</field>
                                        </shadow>
                                    </value>
                                    <value name="B">
                                        <shadow type="math_number">
                                            <field name="NUM">1</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="math_single">
                                    <field name="OP">ROOT</field>
                                    <value name="NUM">
                                        <shadow type="math_number">
                                            <field name="NUM">9</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="math_trig">
                                    <field name="OP">SIN</field>
                                    <value name="NUM">
                                        <shadow type="math_number">
                                            <field name="NUM">45</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="math_constant">
                                    <field name="CONSTANT">PI</field>
                                </block>
                                <block type="math_number_property">
                                    <mutation divisor_input="false"></mutation>
                                    <field name="PROPERTY">EVEN</field>
                                    <value name="NUMBER_TO_CHECK">
                                        <shadow type="math_number">
                                            <field name="NUM">0</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="math_round">
                                    <field name="OP">ROUND</field>
                                    <value name="NUM">
                                        <shadow type="math_number">
                                            <field name="NUM">3.1</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="math_on_list">
                                    <mutation op="SUM"></mutation>
                                    <field name="OP">SUM</field>
                                </block>
                                <block type="math_modulo">
                                    <value name="DIVIDEND">
                                        <shadow type="math_number">
                                            <field name="NUM">64</field>
                                        </shadow>
                                    </value>
                                    <value name="DIVISOR">
                                        <shadow type="math_number">
                                            <field name="NUM">10</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="math_constrain">
                                    <value name="VALUE">
                                        <shadow type="math_number">
                                            <field name="NUM">50</field>
                                        </shadow>
                                    </value>
                                    <value name="LOW">
                                        <shadow type="math_number">
                                            <field name="NUM">1</field>
                                        </shadow>
                                    </value>
                                    <value name="HIGH">
                                        <shadow type="math_number">
                                            <field name="NUM">100</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="math_random_int">
                                    <value name="FROM">
                                        <shadow type="math_number">
                                            <field name="NUM">1</field>
                                        </shadow>
                                    </value>
                                    <value name="TO">
                                        <shadow type="math_number">
                                            <field name="NUM">100</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="math_random_float"></block>
                            </category>

                            <category name="Text" colour="#5ba58c">
                                <block type="text">
                                    <field name="TEXT"></field>
                                </block>
                                <block type="text_join">
                                    <mutation items="2"></mutation>
                                </block>
                                <block type="text_append">
                                    <field name="VAR" id="dz08%Q2ISTb*}-Ff?|Q`">item</field>
                                    <value name="TEXT">
                                        <shadow type="text">
                                            <field name="TEXT"></field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="text_length">
                                    <value name="VALUE">
                                        <shadow type="text">
                                            <field name="TEXT">abc</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="text_isEmpty">
                                    <value name="VALUE">
                                        <shadow type="text">
                                            <field name="TEXT"></field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="text_indexOf">
                                    <field name="END">FIRST</field>
                                    <value name="VALUE">
                                        <block type="variables_get">
                                            <field name="VAR" id="=Q7j!%fEU(di8re4A.R!">text</field>
                                        </block>
                                    </value>
                                    <value name="FIND">
                                        <shadow type="text">
                                            <field name="TEXT">abc</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="text_charAt">
                                    <mutation at="true"></mutation>
                                    <field name="WHERE">FROM_START</field>
                                    <value name="VALUE">
                                        <block type="variables_get">
                                            <field name="VAR" id="=Q7j!%fEU(di8re4A.R!">text</field>
                                        </block>
                                    </value>
                                </block>
                                <block type="text_getSubstring">
                                    <mutation at1="true" at2="true"></mutation>
                                    <field name="WHERE1">FROM_START</field>
                                    <field name="WHERE2">FROM_START</field>
                                    <value name="STRING">
                                        <block type="variables_get">
                                            <field name="VAR" id="=Q7j!%fEU(di8re4A.R!">text</field>
                                        </block>
                                    </value>
                                </block>
                                <block type="text_changeCase">
                                    <field name="CASE">UPPERCASE</field>
                                    <value name="TEXT">
                                        <shadow type="text">
                                            <field name="TEXT">abc</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="text_trim">
                                    <field name="MODE">BOTH</field>
                                    <value name="TEXT">
                                        <shadow type="text">
                                            <field name="TEXT">abc</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="text_print">
                                    <value name="TEXT">
                                        <shadow type="text">
                                            <field name="TEXT">abc</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="text_prompt_ext">
                                    <mutation type="TEXT"></mutation>
                                    <field name="TYPE">TEXT</field>
                                    <value name="TEXT">
                                        <shadow type="text">
                                            <field name="TEXT">abc</field>
                                        </shadow>
                                    </value>
                                </block>
                            </category>

                            <category name="Lists" colour="#745ba5">
                                <block type="lists_create_with">
                                    <mutation items="0"></mutation>
                                </block>
                                <block type="lists_create_with">
                                    <mutation items="3"></mutation>
                                </block>
                                <block type="lists_repeat">
                                    <value name="NUM">
                                        <shadow type="math_number">
                                            <field name="NUM">5</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="lists_length"></block>
                                <block type="lists_isEmpty"></block>
                                <block type="lists_indexOf">
                                    <field name="END">FIRST</field>
                                    <value name="VALUE">
                                        <block type="variables_get">
                                            <field name="VAR" id="7@R#G(w==VKuKMB|T$Wc">list</field>
                                        </block>
                                    </value>
                                </block>
                                <block type="lists_getIndex">
                                    <mutation statement="false" at="true"></mutation>
                                    <field name="MODE">GET</field>
                                    <field name="WHERE">FROM_START</field>
                                    <value name="VALUE">
                                        <block type="variables_get">
                                            <field name="VAR" id="7@R#G(w==VKuKMB|T$Wc">list</field>
                                        </block>
                                    </value>
                                </block>
                                <block type="lists_setIndex">
                                    <mutation at="true"></mutation>
                                    <field name="MODE">SET</field>
                                    <field name="WHERE">FROM_START</field>
                                    <value name="LIST">
                                        <block type="variables_get">
                                            <field name="VAR" id="7@R#G(w==VKuKMB|T$Wc">list</field>
                                        </block>
                                    </value>
                                </block>
                                <block type="lists_getSublist">
                                    <mutation at1="true" at2="true"></mutation>
                                    <field name="WHERE1">FROM_START</field>
                                    <field name="WHERE2">FROM_START</field>
                                    <value name="LIST">
                                        <block type="variables_get">
                                            <field name="VAR" id="7@R#G(w==VKuKMB|T$Wc">list</field>
                                        </block>
                                    </value>
                                </block>
                                <block type="lists_split">
                                    <mutation mode="SPLIT"></mutation>
                                    <field name="MODE">SPLIT</field>
                                    <value name="DELIM">
                                        <shadow type="text">
                                            <field name="TEXT">,</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="lists_sort">
                                    <field name="TYPE">NUMERIC</field>
                                    <field name="DIRECTION">1</field>
                                </block>
                            </category>

                            <category name="Colour" colour="#a5745b">
                                <block type="colour_picker">
                                    <field name="COLOUR">#ff0000</field>
                                </block>
                                <block type="colour_random"></block>
                                <block type="colour_rgb">
                                    <value name="RED">
                                        <shadow type="math_number">
                                            <field name="NUM">100</field>
                                        </shadow>
                                    </value>
                                    <value name="GREEN">
                                        <shadow type="math_number">
                                            <field name="NUM">50</field>
                                        </shadow>
                                    </value>
                                    <value name="BLUE">
                                        <shadow type="math_number">
                                            <field name="NUM">0</field>
                                        </shadow>
                                    </value>
                                </block>
                                <block type="colour_blend">
                                    <value name="COLOUR1">
                                        <shadow type="colour_picker">
                                            <field name="COLOUR">#ff0000</field>
                                        </shadow>
                                    </value>
                                    <value name="COLOUR2">
                                        <shadow type="colour_picker">
                                            <field name="COLOUR">#3333ff</field>
                                        </shadow>
                                    </value>
                                    <value name="RATIO">
                                        <shadow type="math_number">
                                            <field name="NUM">0.5</field>
                                        </shadow>
                                    </value>
                                </block>
                            </category>

                            <category name="Variables" colour="#a55b80" custom="VARIABLE"></category>

                            <category name="Functions" colour="#995ba5" custom="PROCEDURE"></category>

                            <category name="Custom" colour="#5ba58c">

                                <block type="when_key_pressed">
                                    <field name="TECLA">F</field>
                                    <statement name="MENSAGEM">
                                    </statement>
                                </block>

                                <block type="move_item" colour="230">
                                    <value name="distance">
                                        <shadow type="math_number">
                                            <field name="NUM">0</field>
                                        </shadow>
                                    </value>
                                    <value name="transition">
                                        <shadow type="math_number">
                                            <field name="NUM">0</field>
                                        </shadow>
                                    </value>
                                </block>

                                <block type="wait" id="Mzqh4JGGDso7OttoMo5O" x="63" y="63">
    <value name="time">
      <block type="math_number" id="q!(gbPd9=+8+H@|A3fWO">
        <field name="NUM">1</field>
      </block>
    </value>
    <statement name="code">
      <block type="text_print" id="Dg0e=znVm#d2cFyxQX(F">
        <value name="TEXT">
          <shadow type="text" id="~3e?u{3M:w6Y3dr_:f0e">
            <field name="TEXT">Hello, World!</field>
          </shadow>
        </value>
      </block>
    </statement>
  </block>

                            </category>

                        </xml>

                    </div>
                    
                </td>

            </tr>

        </table>

        <script>
            // Cria um workspace Blockly na div 'blocklyDiv'
            var workspace = Blockly.inject('blocklyDiv', {
                media: 'https://unpkg.com/@blockly/blockly/media/',
                toolbox: document.getElementById('toolbox')
            });

            // Cria o evento de atualização de código
            function updateCode() {
                var code = Blockly.JavaScript.workspaceToCode(workspace);

                $.ajax({
                    url: 'projeto.php',
                    type: 'POST',
                    data: {
                        codigo: code
                    },
                    success: function(data) {
                        console.log('Variável enviada com sucesso!');
                    },
                    error: function() {
                        console.error('Erro ao enviar variável');
                    }
                });
            }

            workspace.addChangeListener(updateCode);
            updateCode();
        </script>

        <?php
        if (isset($_POST['codigo'])) {
            $codigo = $_POST['codigo'];

            // Abre o arquivo code.js em modo de escrita
            $arquivo = fopen('code.js', 'w');

            // Escreve o código no arquivo
            fwrite($arquivo, $codigo);

            // Fecha o arquivo
            fclose($arquivo);
        }
        ?>


    </center>

</body>

</html>