<?php

function generate_rapport($file1,$file2,$nboflines) {

//echo "count-----".$nboflines;
//echo $file1->getFieldAtLine(0,85);
$line = explode(";",$file1->getFieldAtLine(0,85));
  for ($i = 1; $i < $nboflines; $i++) {
     $rank = "";
	 $line1  = explode(";",$file1->getFieldAtLine(0,$i));
	 $line2  = explode(";",$file2->getFieldAtLine(0,$i));
     
	 $position1 = intval($line1[0]);
	 $position2 = intval($line2[0]);
	 
	 $style = 'tWin';
	 if($position1 == "" && $position2 == ""){
	   
	 }
	 elseif($position1>$position2){
	   $rank = '+'.(intval($position1) - intval($position2));
	   
	 }elseif($position1<$position2){
	   $rank = '-'.($position2-$position1);
	   $style = 'tLost';
	 }elseif($position1==$position2){
	   $rank = '=';
	 }elseif($position2== 0 && $position1 != 0){
	  $rank = '( ex. '.$position1.')';
	  $style = 'tLost';
	 }elseif($position1== "" && $position2 != ""){
	   $rank = 'nouv.';
	   $style = 'tNew';
	 }
	 
	 $tr_construct =	 
'<tr class="tRowOwner tOdd odd">
	<td class="tCol1 tRank1  sorting_1" align="center">'.$position2.'<sup>er</sup></td>
	<td class=" " align="center">'.$position1.'&nbsp;</td>
	<td class=" " align="center"><span class="'.$style.'">('.$rank.')</span>&nbsp;</td>
	<td class=" ">'.$line1[2].'</td>
	<td class=" " align="center">'.$line1[1].'</td>
	<td class=" " align="center"><a href="'.$line1[3].'" target="blank">'.$line1[3].'</a></td>
	<td class=" " align="center">'.$position2.'<sup>ème</sup> (08/03/2013)</td>
</tr>';
	  if($position1 != "" && $position2 != ""){
	  echo $tr_construct;
      }
  }

}








?>


