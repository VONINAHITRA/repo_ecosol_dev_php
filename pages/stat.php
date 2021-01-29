<?php
$t = microtime(true);
include($_SERVER["DOCUMENT_ROOT"] . "/ecosol-anah/" . 'inc/get_path.php');
include($path . "conf.inc.php");

require_once ROOT.'vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

$size = isset($_REQUEST['size'])?intval($_REQUEST['size']):1024;

$pris_le = isset($_REQUEST['pris_le']);

if(isset($_REQUEST['du']) && isset($_REQUEST['au'])){
	$du_str = $_REQUEST['du'];
	$au_str = $_REQUEST['au'];
}
else {
	$du_str = date('d/m/y', $default_mktime);
	$au_str = date('d/m/y');
}

$active = 1;
if(isset($_REQUEST['active'])) $active = intval($_REQUEST['active']);

$du = $default_mktime;
$au = time();

$tab = explode (DIRECTORY_SEPARATOR, $du_str);
if(count($tab) == 3 && strlen($tab[0])==2 && strlen($tab[1])==2){
	if(strlen($tab[2])<3) $tab[2]="20".$tab[2];
	$du = mktime(0, 0, 0, $tab[1], $tab[0], $tab[2]);	
}
else if(count($tab) == 2 && strlen($tab[0])==2){
	if(strlen($tab[1])<3) $tab[1]="20".$tab[1];
	$du = mktime(0, 0, 0, $tab[0], 1, $tab[1]);	
}

$tab = explode (DIRECTORY_SEPARATOR, $au_str);
if(count($tab) == 3 && strlen($tab[0])==2 && strlen($tab[1])==2){
	if(strlen($tab[2])<3) $tab[2]="20".$tab[2];
	$au = mktime(23, 59, 59, $tab[1], $tab[0], $tab[2]);	
}
else if(count($tab) == 2 && strlen($tab[0])==2){
	if(strlen($tab[1])<3) $tab[1]="20".$tab[1];
	$tab[0] = $tab[0]+1;
	if($tab[0]>12){
		$tab[0] = 1;
		$tab[1]++;
	}
	
	$au = mktime(0, 0, 0, $tab[0], 1, $tab[1]);	
	$au -= 86400;
}

if(isset($_REQUEST['du']) && isset($_REQUEST['au']) && $_REQUEST['au']==''){
	$du = $au+86400;
}

if($pris_le) $date_where = " AND stamp>=$du AND stamp<=$au";
else  $date_where = " AND dateheure>=FROM_UNIXTIME($du) AND dateheure<=FROM_UNIXTIME($au)";


$iduser = bl_compte_UtilisateurId();
$user = sqlu('utilisateurs', $iduser);
$telepros = array();
$commerciaux = array();
if($user['admin'] == 1 || $user['rc'] == 1 || $user['assistant'] == 1 ){
	
	if(isset($_REQUEST['telepros']) && is_array($_REQUEST['telepros'])){
                foreach($_REQUEST['telepros'] as $k => $v) 
                    $telepros[intval($k)] = intval($v);
	}
	
	if(isset($_REQUEST['commerciaux']) && is_array($_REQUEST['commerciaux'])){
                foreach($_REQUEST['commerciaux'] as $k => $v) 
                    $commerciaux[intval($k)] = intval($v);
	}

	if(!count($telepros) && !count($commerciaux)){
		$where =" telepro=1 OR commercial=1";
		if($active!=-1) $where = "active=$active AND (telepro=1 OR commercial=1)";
		$query = "SELECT id, commercial, telepro FROM utilisateurs WHERE $where ORDER BY nom";

		$utilisateurs = sql($query);
		while($utilisateur = mysqli_fetch_array($utilisateurs)){
			if($utilisateur['commercial']==1) $commerciaux[] = $utilisateur['id'];
			if($utilisateur['telepro']==1) $telepros[] = $utilisateur['id'];
		}

	}
}
else{
    $commerciaux[] = $iduser;
    $telepros[] = $iduser;
}

$print = isset($_REQUEST['print']) && $_REQUEST['print']==1;

//GLOBAL
$res = sql("SELECT count(id) AS nbclient FROM clients WHERE active=1");
$rec = mysqli_fetch_array($res);
$global_nbcontrats = $rec['nbclient'];

$res = sql("SELECT count(id) AS nb FROM rdv WHERE active=1");
$rec = mysqli_fetch_array($res);
$global_nbrdv = $rec['nb'];
//end => GLOBAL

$output = '';

$types_rapport = array('EN COURS' =>0,'SIGNE' =>0,'DEVIS ENVOYE' =>0,'DEVIS REFUSE' =>0,'DEVIS EXPIRE' =>0,'PAS INTERRESSE' =>0,'HORS CRITERE' =>0,'NRP' =>0,'R2' =>0,'ANNULE' =>0,'EN ATTENTE' =>0,'A REPLACER' =>0,'ATTENTE IMPOTS' =>0,'A COMPLETER' =>0,'A RECONTACTER' =>0,'DOSSIER DOUBLON' =>0,'LEAD TRAITE' =>0,'INERTIE' =>0,'AVIS D IMPOT 2021' =>0);
//COMMERCIAL

if(!empty($commerciaux)){
    $output .= '<div style="margin: 10px; ">';
    $output .= '<div class="title">Du '.date('d/m/y', $du).' au '.date('d/m/y', $au).' COMMERCIAL</div>';
    $output .= '<table class="tab">'; 

    $output .= '<tr>';
    $output .= '<td class="th">Nom</td>';

    $values = $types_rapport;
    $totaux = $types_rapport;

    foreach($values as $key => $value){
            $output .= '<td class="th">'.$key.'</td>';
    }
    $output .= '<td class="th">Total</td>';
    $output .= '</tr>';

    $switch = true;
 
    $commerciaux = [];
    $commerciauxReq = sql("SELECT utilisateurs.id AS idcommercial FROM utilisateurs INNER JOIN equipes ON utilisateurs.idequipe = equipes.id WHERE utilisateurs.commercial=1");
      
     foreach ($commerciauxReq as $coms) {
       $commerciauxRes = $coms['idcommercial'];
       $commerciaux [] = $commerciauxRes;
     }

     foreach($commerciaux as $idcommercial){
            $class="";
            if($switch) $class=" hl";

            $where = " active=1 AND idutilisateur=$idcommercial";

            $query = "SELECT count(id) AS nb, rapport FROM rdv WHERE $where $date_where GROUP BY rapport";
          
            $rdvs = sql($query);
 
            $output .= '<tr class="table_line '.$class.'">';	
            $commerce = sqlu("utilisateurs", $idcommercial);
            $output .= '<td class="th">'.$commerce['nom'].' '.$commerce['prenom'].'</td>';

            $total = 0;
            $values = array('EN COURS' =>0,'SIGNE' =>0,'DEVIS ENVOYE' =>0,'DEVIS REFUSE' =>0,'DEVIS EXPIRE' =>0,'PAS INTERRESSE' =>0,'HORS CRITERE' =>0,'NRP' =>0,'R2' =>0,'ANNULE' =>0,'EN ATTENTE' =>0,'A REPLACER' =>0,'ATTENTE IMPOTS' =>0,'A COMPLETER' =>0,'A RECONTACTER' =>0,'DOSSIER DOUBLON' =>0,'LEAD TRAITE' =>0,'INERTIE' =>0,'AVIS D IMPOT 2021' =>0);
            while($rdv = mysqli_fetch_assoc($rdvs)){
                    $values[$rdv['rapport']] = $rdv['nb'];		
                    $totaux[$rdv['rapport']]+=$rdv['nb'];
                    $total+=$rdv['nb'];
            }
     
            foreach($values as $key => $value){
                $pct = number_format($total>0?(100.0*$value/$total):0, 1);
                $str = $value.' ('.$pct.'%)';
                if($print)  $output .= '<td>'.$str.'</td>';
                else $output .= '<td><a href="javascript:UpdateFromRdvStats('.$idcommercial.', \''.$key.'\', true);">'.$str.'</a></td>';    
            }

            if($print)   $output .= '<td>'.$total.'</td>';
            else $output .= '<td><a href="javascript:UpdateFromRdvStats('.$idcommercial.', \'Tous\', true);">'.$total.'</a></td>';

            $output .= '</tr>';
            $switch = !$switch;
    }

    //mysqli_stmt_close($comStmt);

    $output .= '<tr class="table_line"><td class="th">Totaux</td>';
    $final = 0;
    foreach($values as $key => $value){
        $final += $totaux[$key];
    }

    foreach($values as $key => $value){
        $pct = number_format($final>0?(100.0*$totaux[$key]/$final):0, 1);
        $str = $totaux[$key].' ('.$pct.'%)';    
        $output .= '<td class="th">'.$str.'</td>';
    }
    $output .= '<td class="th">'.$final.'</td>';
    $output .= '</tr>';

    $output .= '</table></div>';
}

// TELEPROS
if(!empty($telepros)){
    $output .= '<div style="margin: 10px;">';
    $output .= '<div class="title">Du '.date('d/m/y', $du).' au '.date('d/m/y', $au).'  TELEPROS</div>';

    $output .= '<table class="tab">';
    $output .= '<tr>';
    $output .= '<td class="th">Nom</td>';
    $values = $types_rapport;
    $totaux = $types_rapport;
    foreach($values as $key => $value){
            $output .= '<td class="th">'.$key.'</td>';
    }
    $output .= '<td class="th">Total</td>';
    $output .= '</tr>';

    $switch = true;

    $telepros = [];
    $teleproReq = sql("SELECT utilisateurs.id AS idtelepro FROM utilisateurs INNER JOIN equipes ON utilisateurs.idequipe = equipes.id WHERE utilisateurs.telepro=1");

    foreach ($teleproReq as $tels) {
       $teleprosRes = $tels['idtelepro'];
       $telepros [] = $teleprosRes;
     }

    foreach($telepros as $idtelepro){

            $class="";
            if($switch) $class=" hl";
            $where = " active=1 AND idutilisateur=$idtelepro";
            
            $query = "SELECT count(id) AS nb, rapport FROM rdv WHERE $where $date_where GROUP BY rapport";
            $rdvs = sql($query);
            $output .= '<tr class="table_line  '.$class.'">';	
            $telepro = sqlu("utilisateurs", $idtelepro);
            $output .= '<td class="th">'.$telepro['nom'].' '.$telepro['prenom'].'</td>';

            $total = 0;
            $values = array('EN COURS' =>0,'SIGNE' =>0,'DEVIS ENVOYE' =>0,'DEVIS REFUSE' =>0,'DEVIS EXPIRE' =>0,'PAS INTERRESSE' =>0,'HORS CRITERE' =>0,'NRP' =>0,'R2' =>0,'ANNULE' =>0,'EN ATTENTE' =>0,'A REPLACER' =>0,'ATTENTE IMPOTS' =>0,'A COMPLETER' =>0,'A RECONTACTER' =>0,'DOSSIER DOUBLON' =>0,'LEAD TRAITE' =>0,'INERTIE' =>0,'AVIS D IMPOT 2021' =>0);
            while($rdv = mysqli_fetch_assoc($rdvs)){
                    $values[$rdv['rapport']] = $rdv['nb'];	
                    $totaux[$rdv['rapport']]+=$rdv['nb'];	
                    $total+=$rdv['nb'];
            }

            foreach($values as $key => $value){
                $pct = number_format($total>0?(100.0*$value/$total):0, 1);
                $str = $value.' ('.$pct.'%)';            
                if($print) $output .= '<td>'.$str.'</td>';
                else $output .= '<td><a href="javascript:UpdateFromRdvStats('.$idtelepro.', \''.$key.'\', false);">'.$str.'</a></td>';

            }

            if($print) $output .= '<td>'.$total.'</td>';
            else $output .= '<td><a href="javascript:UpdateFromRdvStats('.$idtelepro.', \'Tous\', false);">'.$total.'</a></td>';
            $output .= '</tr>';
            $switch = !$switch;
    }

    $output .= '<tr class="table_line"><td class="th">Totaux</td>';
    $final = 0;

    foreach($values as $key => $value){
        $final += $totaux[$key];
    }

    foreach($values as $key => $value){
        $pct = number_format($final>0?(100.0*$totaux[$key]/$final):0, 1);
        $str = $totaux[$key].' ('.$pct.'%)';     
        $output .= '<td class="th">'.$str.'</td>';
    }

    $output .= '<td class="th">'.$final.'</td>';
    $output .= '</tr>';

    $output .= '</table></div>';
}

//SOURCE
$source = [];

    $sourceReq = sql("SELECT utilisateurs.id AS idSource FROM utilisateurs");
    foreach ($sourceReq as $srcs) {
        $sourceRes = $srcs['idSource'];
        $sources [] = $sourceRes;
    }
    $sourcesArr = array('radiateur-1euro' => 0,'total' => 0,'carrera' => 0,'parrainage' => 0, 'facebook' => 0, 'google' => 0, 'bing' => 0, 'outbrain' => 0, 'sms' => 0, 'email' => 0, 'groupon' => 0,'radiateur-1euro : lead'=>0,'radiateur-1euro : contact'=>0, 'parrainage_email' => 0, 'parrainage_sms' => 0, 'parrainage_fb' => 0, 'parrainage_google' => 0,'radiateurs-gratuits'=>0, 'taboola' => 0, 'courrier' => 0, 'as-media'=>0,'2B Digital'=>0,'showroom_prive'=>0);

    if (!empty($sources)) {

        $output .= '<div style="margin: 10px;">';
        $output .= '<div class="title">Du ' . date('d/m/y', $du) . ' au ' . date('d/m/y', $au) . '  SOURCES</div>';

        $output .= '<table class="tab">';
        $output .= '<tr>';
        $output .= '<td class="th">Nom</td>';
        $values = $sourcesArr;
        $totaux = $sourcesArr;
        foreach ($values as $key => $value) {

            $output .= '<td class="th">' . $key . '</td>';
        }
        $output .= '<td class="th">Total</td>';
        $output .= '</tr>';

        $switch = true;

        foreach ($sources as $idsource) {
            $class = "";
            if ($switch) $class = " hl";
//            $where = " active=1 AND idtelepro=$idtelepro ";
            $where = " idutilisateur=$idsource";
            $query = "SELECT count(id) AS nb, source FROM rdv WHERE $where $date_where GROUP BY source";
            $rdvs = sql($query);
            $output .= '<tr class="table_line  ' . $class . '">';
            $sourcet = sqlu("utilisateurs", $idsource);
            $output .= '<td class="th">' . $sourcet['nom'] . ' ' . $sourcet['prenom'] . '</td>';
            $total = 0;
            $values = array('radiateur-1euro' => 0,'total' => 0,'carrera' => 0,'parrainage' => 0, 'facebook' => 0, 'google' => 0, 'bing' => 0, 'outbrain' => 0, 'sms' => 0, 'email' => 0, 'groupon' => 0,'radiateur-1euro : lead'=>0,'radiateur-1euro : contact'=>0, 'parrainage_email' => 0, 'parrainage_sms' => 0, 'parrainage_fb' => 0, 'parrainage_google' => 0,'radiateurs-gratuits'=>0, 'taboola' => 0, 'courrier' => 0, 'as-media'=>0,'2B Digital'=>0,'showroom_prive'=>0);
         
            while ($rdv = mysqli_fetch_assoc($rdvs)) {
                $values[$rdv['source']] = $rdv['nb'];
                $totaux[$rdv['source']] += $rdv['nb'];
                $total += $rdv['nb'];
            }

            foreach ($values as $key => $value) {
                $pct = number_format($total > 0 ? (100.0 * $value / $total) : 0, 1);
                $str = $value . ' (' . $pct . '%)';
                if ($print) $output .= '<td>' . $str . '</td>';
                else $output .= '<td><a href="javascript:UpdateFromRdvStats(' . $idsource . ', \'' . $key . '\', false);">' . $str . '</a></td>';

            }

            if ($print) $output .= '<td>' . $total . '</td>';
            else $output .= '<td><a href="javascript:UpdateFromRdvStats(' . $idsource . ', \'Tous\', false);">' . $total . '</a></td>';
            $output .= '</tr>';
            $switch = !$switch;
        }

        $output .= '<tr class="table_line"><td class="th">Totaux</td>';
        $final = 0;

        foreach ($values as $key => $value) {
            $final += $totaux[$key];
        }

        foreach ($values as $key => $value) {
            $pct = number_format($final > 0 ? (100.0 * $totaux[$key] / $final) : 0, 1);
            $str = $totaux[$key] . ' (' . $pct . '%)';
            $output .= '<td class="th">' . $str . '</td>';
        }

        $output .= '<td class="th">' . $final . '</td>';
        $output .= '</tr>';

        $output .= '</table></div>';
    }



if($print){
        set_time_limit(1200);

        $html2pdf = new Html2Pdf('L','A4','fr');
        
        $PDF_output = '<style>';
        $PDF_output .= '.title {background-color: #E4E4E4; margin-bottom: 10px;}';
        $PDF_output .= '.hl {background-color: #F4F4F4;}';
        $PDF_output .= 'table {margin-bottom: 20px;}';
        $PDF_output .= 'td {font-size: 12px;}';
        $PDF_output .= '</style>';
        $PDF_output .= '<page>'.$output.'</page>';
        $html2pdf->WriteHTML($PDF_output);
        $html2pdf->Output('stats.pdf');	
        exit();           
}
else echo $output;

?>
<script type="text/javascript">
$('#stat_du').datepicker($.datepicker.regional['fr']);
$('#stat_au').datepicker($.datepicker.regional['fr']);
</script>

