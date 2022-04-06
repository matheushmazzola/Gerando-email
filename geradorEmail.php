<!DOCTYPE html>
<html>
<body>

<h2>Criação de Email</h2>

<form method="post" action="/geradorEmail.php">
  <label for="nome">Nome completo:</label><br>
  <input type="text" id="nome" name="nome"><br>
  <input type="submit" value="Submit">
</form> 

</body>
</html>
<?php

$arrayNomes = array();
$iniciais = array();
$resultadoEmail = array();
$juntandoEmail = array();
$_SESSION['dados'] = array();
$dominio = "@snipergamer.com";
$input = empty($_POST['nome']) ? "" : $_POST['nome'];

$arrayNomes = [
"Tadeu Augusto",
"Tadeu Frazon",
"Matheus Henrique Mazzola",
"Perycles Junior",
"Ricardo Henrique",
"Victor Sposito",
"Matheus Henrique Meireles",
"Tadeu Augusto Frazon-Lino",
"Matheus Junior Manuel",
"Manuela Souza",
"Victor Sechi",
"Pedro Junior",
"Marcos Souza"];

$count = count(array_keys($arrayNomes));
if($input != ""){
    $arrayNomes[$count] = $input;
}

foreach($arrayNomes as $key => $arrNomes){
    $arrNomes = strtolower($arrNomes);
    $retirandoCaracterEspecial = preg_replace('/[-]+/', '', $arrNomes);
    $quebrandoNosEspacos = explode(" ", $retirandoCaracterEspecial);
    $numeroUltimoNome = array_key_last($quebrandoNosEspacos);
    $sobrenome = $quebrandoNosEspacos[$numeroUltimoNome];
    $qtdNomes = count($quebrandoNosEspacos);
    $qtdNomes = $qtdNomes - 1;
    for($i = 0;$i < $qtdNomes;$i++){
        $primeiraLetra = substr($quebrandoNosEspacos[$i], 0, 1);
        if($i+1 < $qtdNomes){
            $iniciais[$i] = $primeiraLetra.".";
        }else{
            $iniciais[$i] = $primeiraLetra;
        }
    }
    if(empty($iniciais)){
        $resultadoEmail[$key] = $sobrenome.$dominio;
        continue;
    }
    $iniciais = implode($iniciais);
    $juntandoEmail[$key] = $sobrenome.".".$iniciais.$dominio;
    $countIguais = array_count_values($juntandoEmail);
    if(array_search($juntandoEmail[$key], $resultadoEmail)){
        $resultadoEmail[$key] = $sobrenome.".".$iniciais.$countIguais[$juntandoEmail[$key]].$dominio;
    }else{
        $resultadoEmail[$key] = $juntandoEmail[$key];
    }
    unset($iniciais);

}
$resultadoCombinando = array_combine($arrayNomes, $resultadoEmail);
foreach($resultadoCombinando as $key => $arrFinal){
    $resultadoFinal[$key] = "$key &lt$arrFinal><br/>";
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Historico de criação</h2>
<form>
    <?php foreach($resultadoFinal as $key => $arrFinal){
        print_r($arrFinal);
    }?>
</form> 

</body>
</html>