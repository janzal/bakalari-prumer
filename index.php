<?php
 session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta charset="utf-8">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <title>Bakalari - prumer</title>
  <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <body><!--WZ-REKLAMA-1.0IZ--><div align="center"><table width="496" border="0"
cellspacing="0" cellpadding="0"><tr><td><a href="http://www.webzdarma.cz/"><img
src="http://i.wz.cz/banner/nudle03.gif" width="28" height="60"
style="margin: 0; padding: 0; border-width: 0" alt="WebZdarma.cz" /></a></td><td>
<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https':'http')+'://ad.wz.cz/openx/www/delivery/ajs.php';
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?zoneid=7");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>--></script><noscript><div><a href='http://ad.wz.cz/openx/www/delivery/ck.php?n=a5977468&amp;cb=123'><img src='http://ad.wz.cz/openx/www/delivery/avw.php?zoneid=33&amp;cb=123&amp;n=a5977468' style='margin: 0; padding: 0; border-width: 0' alt='' /></a></div></noscript>
</td></tr></table></div>
<!--WZ-REKLAMA-1.0IK-->

<center>

<img src="header.png" alt="header.png, 16kB" title="header" border="0"/>

<h1>Nova verze pocitadla je <a href="http://prumer.janzaloudek.cz">tady</a></h1>

<form aciton="index.php" method="post">

<fieldset>
  <legend>Zadejte znamky</legend>

  <p style="width: 60%">
    Zkopirujte znamky a vahy primo z bakalaru (oznacte dohromady prvni a druhej radek u predmetu) a vlozte je sem. Hotovo :)
  </p>
    Příklad:<br />
    <code>1 2 1 2 5<br>10 5 3 4 2</code><br /><br />


  <textarea rows="10" cols="80" name="znamky" wrap="off"><?php if (isset($_POST['znamky'])) echo $_POST['znamky']?></textarea>
  <br><input type="submit" value="Spocitat"><br>
  <h2>Novinky</h2>
  <b>Po peti letech jsem se podival do historie a rekl jsem si, ze musim to vkladani konecne opravit. Takze ted fakt jen staci copy-paste z bakalaru :)
  <br>
</fieldset>

</form>

<?php
  $znamky=$_POST['znamky'];
  if(!empty($znamky)) {
    $radky=explode("/",trim($znamky));

    if($radky[0]==$znamky)
      $radky=explode(chr(13),$znamky);

    $a=preg_split('/[\s,]+/',trim($radky[0]));
    $b=preg_split('/[\s,]+/',trim($radky[1]));

    $sum=0;
    $count=0;
    $num=array(1,1.5,2,2.5,3,3.5,4,4.5,5);
    $badav=1;
    $besav=5;
    $sa=array();
    $sb=array();
    $avga=array();

    echo "<table>
    <th>ID</th><th>Znamka</th><th>Vaha</th><th>Hodnota</th><th>Celkova hodnota</th><th>Delitel</th><th>Vysledek</th>";

    if (count($a)==count($b)) {
     for($i=0;$i<count($a);$i++) {
       $cl="";
       $zn=$a[$i];
       if(isset($zn[1]) && $zn[1]=="-")
       {
        $zn[1]=".";
        $zn[2]="5";
       }

       $val=$b[$i];
       if(is_numeric($val)) {
        $val=($val>10)?10:$val;
        $val=($val<1)?1:$val;
       } else { $val = 0; }

       if(in_array($zn,$num)) {

         $count+=$val;
         $sum+=$zn*$val;
         $sa[]=$zn;
         $sb[]=$val;

        } else
        $cl="bgcolor=\"silver\"";

       $av=(($count>0)? ($sum/$count) : 0);
       $avga[]=$av;
       $badav=($av>$badav)?$av:$badav;
       $besav=($av<$besav)?$av:$besav;
       echo "<tr $cl><td>".($i+1)."</td><td>".$zn."</td><td>".$val."</td><td>".$zn*$val."</td><td>$sum</td><td>$count</td><td>".round($av,3)." (".round($av).")</td>";
       $_SESSION['znamky_sess']=$sa;
       $_SESSION['vaha_sess']=$sb;
       $_SESSION['avga_sess']=$avga;
     }
     echo "</table>";
     $prumer=($count>0)?$sum/$count:0;
     echo "<b><h1><u>Znamka ".round($prumer)."</u></h1></b><br>".round($prumer,3);
     echo "<br><br><b>Statistiky:</b><br>
     Pocet znamek: ".count($a)."<br>
     Soucet znamek: $sum<br>
     Vysledny delitel: $count<br>
     Nejhorsi prumer: ".round($badav)." (".round($badav,3).")<br>
     Nejlepsi prumer: ".round($besav)." (".round($besav,3).")<br>
     <a href=\"#\" onClick=\"window.open('obrazek.php?cnt=".count($sa)."&avg=$prumer')\">Graf uspesnosti</a><br>";



    } else echo "Nedostatek informaci (".count($a)." / ".count($b).")";

  }

?>

</center>

Jan Žaloudek 2008 &copy;(posledni aktualizace: 19.1.2015)<br>
<a href="http://www.toplist.cz/stat/781990">
<script language="JavaScript" type="text/javascript">
<!--
document.write ('<img src="http://toplist.cz/count.asp?id=781990&logo=mc&http='+escape(document.referrer)+'&wi='+escape(window.screen.width)+'&he='+escape(window.screen.height)+'&cd='+escape(window.screen.colorDepth)+'" width="88" height="60" border=0 alt="TOPlist" />');
//--></script><noscript><img src="http://toplist.cz/count.asp?id=781990&logo=mc" border="0"
alt="TOPlist" width="88" height="60" /></noscript></a>

  </body>
</html>



