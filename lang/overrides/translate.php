<?php
// ONLY HELPER, SAMPLE
// NOT FOR PRODUCTION USE
// DO NOT FOLLOW THIS CODING STANDARDS!
       
define('WHMCS', 1);

function findTranslation($lang, $keys){
  $return = "";
  foreach($keys as $v){    
    $return = $lang[$v];      
    $lang = $return;
  }
  return $return;
}


function printArrayAsPHP($someArray) {
    $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($someArray), RecursiveIteratorIterator::SELF_FIRST);
    $out = "<?php\n";
    foreach ($iterator as $k => $v) {        
         if ($iterator->hasChildren()) {         
        } else {
            for ($p = array(), $i = 0, $z = $iterator->getDepth(); $i <= $z; $i++) {
              $p[] = $iterator->getSubIterator($i)->key();                          
            }
            $path = implode('/', $p);            
            $input = '$_LANG';            
            foreach($p as $key) {
              $input.="['$key']";
            }            
            $out.=$input."=\"$v\";\n";          
        }
    }
    highlight_string ($out);
}

function listLang($lang, $translated) {    
    $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($lang), RecursiveIteratorIterator::SELF_FIRST);    
    foreach ($iterator as $k => $v) {
        ;        
         if ($iterator->hasChildren()) {
            echo "$k :<br>";
        } else {
            for ($p = array(), $i = 0, $z = $iterator->getDepth(); $i <= $z; $i++) {
                $p[] = $iterator->getSubIterator($i)->key();
            }
            $path = implode('/', $p);            
            $input = '_LANG';            
            foreach($p as $key){
              $input.="[$key]";
            }
            $v = htmlentities($v);
            $tr = findTranslation($translated, $p);
            echo "<div class='form-group'><label>\$$input<br/><code>$v</code></label><br />
            <textarea class='input' name='{$input}' style='width:100%;;' rows='auto'>$tr</textarea>            
            </div>";
        }
    }
}

if(isset($_POST['_LANG'])) {  
  echo "<pre>";
  printArrayAsPHP($_POST['_LANG']);
  die;
}
  
include("./hungarian.php");
$hu = $_LANG;
unset($_LANG);
include("../english.php");
$en = $_LANG;


?>
<html>
<head>
<link href="https://bootswatch.com/cerulean/bootstrap.min.css" rel="stylesheet"  type="text/css" />
</head>
<body>
<div class="container" style="margin-bottom:100px;">
  <form class="form" method="post">
    <?php listLang($en, $hu); ?>
    <input type='submit' class='btn btn-block btn-success' style='position:fixed;bottom:10;left:0;;' />    
  </form>
</div>
</body>
</html>
