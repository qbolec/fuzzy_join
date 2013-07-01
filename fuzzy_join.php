#!/usr/bin/php
<?php
function get_or(array $a,$key,$default){
  if(array_key_exists($key,$a)){
    return $a[$key];
  }
  return $default;
}
$short_opts = implode('',array(
  '1:',//field in first file
  '2:',//field in second file
  'd:',
));
$long_opts = array(
  'minus:',
  'plus:',
);
$options = getopt($short_opts,$long_opts);
$filenames = array_slice($argv,-2);
$delimiter = get_or($options,'d',"\t");
$join_fields[] = get_or($options,'1',1)-1;
$join_fields[] = get_or($options,'2',1)-1;
$plus = get_or($options,'plus',0);
$minus = get_or($options,'minus',0);
foreach($filenames as $i => $name){
  $handle = @fopen(($name==='-'?'php://stdin':$name),'rb');
  if(false===$handle){
    echo "Could not open file $name\n";
    die(1);
  }
  $handles[]=$handle;
}

$buffer = array();

while(!feof($handles[0])){
  $line=fgets($handles[0]);
  if(false===$line){
    break;
  }
  $current=explode($delimiter,rtrim($line,"\n"));
  $key = $current[$join_fields[0]];
  while(!feof($handles[1]) && (empty($buffer) || $buffer[count($buffer)-1][$join_fields[1]]<=$key+$plus)){
    $line=fgets($handles[1]);
    if(false===$line){
      break;
    }
    $fields=explode($delimiter,rtrim($line,"\n"));
    $buffer[] = $fields;
  }
  $buffer_start = 0;
  while($buffer_start < count($buffer) && $buffer[$buffer_start][$join_fields[1]] < $key-$minus){
    $buffer_start++;
  }
  $buffer = array_slice($buffer,$buffer_start);//amortized by $buffer[]=, and echo below.
  foreach($buffer as $fields){
    if($fields[$join_fields[1]] <= $key + $plus){
      echo implode($delimiter, array_merge($current,$fields)) . "\n";
    }//else happens at most once.
  }
}
