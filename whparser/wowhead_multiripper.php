<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>rdb faction, hp, mana, gold drop, display, level dumper [RAW]</title>
</head>
<center>
<?php

function shitremover($input_string,$mode) {
    // filtered [li]
    $input_string=preg_replace("/\[li\]/i","",$input_string);
    $input_string=preg_replace("/,/i","",$input_string);
    $input_string=preg_replace("/\[\/li\]/i","",$input_string);
    $input_string=preg_replace("/Health: /i","",$input_string);
    $input_string=preg_replace("/Mana: /i","",$input_string);
    $input_string=preg_replace("/Level: /i","",$input_string);    
    $input_string=preg_replace("/displayId: /i","",$input_string);    
    $input_string=preg_replace("/ }\)/i","",$input_string);
    $input_string=preg_replace("/\[money=/i","",$input_string);         
    $input_string=preg_replace("/\]/i","",$input_string);
    $input_string=preg_replace("/humanoid\: 1/i","",$input_string);
    
    // hp
    if ($mode==1) $input_string=preg_replace("/ - /i",", maxhealth=",$input_string);
             
    //level
    if ($mode==2) $input_string=preg_replace("/ - /i",", maxlevel=",$input_string);
    // mana
    if ($mode==3) $input_string=preg_replace("/ - /i",", maxmana=",$input_string);    
    
    return($input_string); 
}



 $datum=date("Y, F, j,  G:i:s");
 
if (!isset($_POST['kedzo']) AND  !isset($_POST['veg'])) {

print '
<form action="wowhead_multiripper.php" method="post">
<b>First npc ID:&nbsp;&nbsp;&nbsp;&nbsp;</b><input type="text" value="1" name="kedzo">


<b>Last npc ID: </b><input type="text" value="2" name="veg">



<input type="submit" value="Start">
</form>




';
}

if (isset($_POST['kedzo']) AND  isset($_POST['veg'])) {

// time limit
set_time_limit(499920);
//fajl megnyitasa
$filehandle = fopen("sqlwowheadmultiripper/creature_faction.sql", 'a') or die("Я не могу открыть файл.");
$filehandle2= fopen("sqlwowheadmultiripper/creature_level.sql", 'a') or die("Я не могу открыть файл.");
$filehandle3= fopen("sqlwowheadmultiripper/creature_hp.sql", 'a') or die("Я не могу открыть файл.");
$filehandle4= fopen("sqlwowheadmultiripper/creature_mana.sql", 'a') or die("Я не могу открыть файл.");
$filehandle5= fopen("sqlwowheadmultiripper/creature_display.sql", 'a') or die("Я не могу открыть файл.");
$filehandle6= fopen("sqlwowheadmultiripper/creature_dropmoney.sql", 'a') or die("Я не могу открыть файл.");
$filehandle7= fopen("sqlwowheadmultiripper/classification.sql", 'a') or die("Я не могу открыть файл.");
$filehandle8= fopen("sqlwowheadmultiripper/pet.sql", 'a') or die("Я не могу открыть файл.");
$filehandle9= fopen("sqlwowheadmultiripper/1entry.sql", 'a') or die("Я не могу открыть файл.");
for ($i=$_POST['kedzo'];$i<=$_POST['veg'];$i++)
{
 $link = 'http://www.wowhead.com/npc=' . $i;
 $tart = file_get_contents($link);


//[color=q10]A[/color][/li]
if (preg_match("/\[color\=q10\]A\[\/color\]/i", $tart)) $faction_id=14;
if (preg_match("/\[color\=q10\]H\[\/color\]/i", $tart)) $faction_id=14;

if (preg_match("/\[color\=q2\]A\[\/color\]/i", $tart)) $faction_id=35;
if (preg_match("/\[color\=q2\]H\[\/color\]/i", $tart)) $faction_id=35;

if (preg_match("/\[color\=q\]A\[\/color\]/i", $tart)) $faction_id=189;
if (preg_match("/\[color\=q\]H\[\/color\]/i", $tart)) $faction_id=189;

if ((preg_match("/\[color\=q2\]A\[\/color\] \[color\=q10\]H\[\/color\]/i", $tart)) OR 
      (preg_match("/React: \[color=q2\]A\[\/color\]/i", $tart)))
$faction_id=84;

 if ((preg_match("/\[color\=q10\]A\[\/color\] \[color\=q2\]H\[\/color\]/i", $tart)) OR
      (preg_match("/React: \[color=q2\]H\[\/color\]/i", $tart)))
$faction_id=83;

if (preg_match("/\[color\=q2\]A\[\/color\] \[color\=q2\]H\[\/color\]/i", $tart)) $faction_id=35;

if (preg_match("/\[color\=q10\]A\[\/color\] \[color\=q10\]H\[\/color\]/i", $tart)) $faction_id=14;

if (preg_match("/\[color\=q\]A\[\/color\] \[color\=q\]H\[\/color\]/i", $tart)) $faction_id=189;

/*
 ################# FACTION SYSTEM #################################
*/

// CLASSIC
if (preg_match("/\[li\]Faction: \[url\=\/faction\=529\]Argent Dawn/i", $tart)) $faction_id=794;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1133\]Bilgewater Cartel/i", $tart)) $faction_id=2159;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=87\]Bloodsail Buccaneers/i", $tart)) $faction_id=119;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=21\]Booty Bay/i", $tart)) $faction_id=120;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=910\]Brood of Nozdormu/i", $tart)) $faction_id=776;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=609\]Cenarion Circle/i", $tart)) $faction_id=635;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=909\]Darkmoon Faire/i", $tart)) $faction_id=1555;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=530\]Darkspear Trolls/i", $tart)) $faction_id=126;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=69\]Darnassus/i", $tart)) $faction_id=76;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=577\]Everlook/i", $tart)) $faction_id=854;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=930\]Exodar/i", $tart)) $faction_id=1638;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=729\]Frostwolf Clan/i", $tart)) $faction_id=1214;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=369\]Gadgetzan/i", $tart)) $faction_id=474;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=92\]Gelkis Clan Centaur/i", $tart)) $faction_id=132;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1134\]Gilneas/i", $tart)) $faction_id=2163;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=54\]Gnomeregan/i", $tart)) $faction_id=23;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=749\]Hydraxian Waterlords/i", $tart)) $faction_id=695;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=47\]Ironforge/i", $tart)) $faction_id=55;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=93\]Magram Clan Centaur/i", $tart)) $faction_id=133;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=76\]Orgrimmar/i", $tart)) $faction_id=29;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=470\]Ratchet/i", $tart)) $faction_id=69;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=349\]Ravenholdt/i", $tart)) $faction_id=471;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=809\]Shen'dralar/i", $tart)) $faction_id=1354;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=911\]Silvermoon City/i", $tart)) $faction_id=1602;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=890\]Silverwing Sentinels/i", $tart)) $faction_id=1514;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=730\]Stormpike Guard/i", $tart)) $faction_id=1216;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=72\]Stormwind/i", $tart)) $faction_id=11;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=510\]The Defilers/i", $tart)) $faction_id=412;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=509\]The League of Arathor/i", $tart)) $faction_id=1577;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=59\]Thorium Brotherhood/i", $tart)) $faction_id=1474;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=81\]Thunder Bluff/i", $tart)) $faction_id=104;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=576\]Timbermaw Hold/i", $tart)) $faction_id=414;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=68\]Undercity/i", $tart)) $faction_id=68;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=889\]Warsong Outriders/i", $tart)) $faction_id=1515;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=270\]Zandalar Tribe/i", $tart)) $faction_id=1574;

// The Burning Crusade
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1012\]Ashtongue Deathsworn/i", $tart)) $faction_id=1820;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=942\]Cenarion Expedition/i", $tart)) $faction_id=1659;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=946\]Honor Hold/i", $tart)) $faction_id=1666;
//if (preg_match("/\[li\]Faction: \[url\=\/faction\=989\]Keepers of Time/i", $tart)) $faction_id=;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=978\]Kurenai/i", $tart)) $faction_id=1721;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1011\]Lower City/i", $tart)) $faction_id=1818;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1015\]Netherwing/i", $tart)) $faction_id=1824;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1038\]Ogri'la/i", $tart)) $faction_id=1872;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1031\]Sha'tari Skyguard/i", $tart)) $faction_id=1856;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1077\]Shattered Sun Offensive/i", $tart)) $faction_id=1956;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=970\]Sporeggar/i", $tart)) $faction_id=1707;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=932\]The Aldor/i", $tart)) $faction_id=1743;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=933\]The Consortium/i", $tart)) $faction_id=1730;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=941\]The Mag'har/i", $tart)) $faction_id=1650;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=990\]The Scale of the Sands/i", $tart)) $faction_id=1778;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=934\]The Scryers/i", $tart)) $faction_id=1744;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=935\]The Sha'tar/i", $tart)) $faction_id=1741;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=967\]The Violet Eye/i", $tart)) $faction_id=1696;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=947\]Thrallmar/i", $tart)) $faction_id=1668;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=922\]Tranquillien/i", $tart)) $faction_id=1623;

// Wrath of the Lich King
//if (preg_match("/\[li\]Faction: \[url\=\/faction\=1037\]Alliance Vanguard/i", $tart)) $faction_id=;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1106\]Argent Crusade/i", $tart)) $faction_id=2070;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1068\]Explorers' League/i", $tart)) $faction_id=1926;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1104\]Frenzyheart Tribe/i", $tart)) $faction_id=2060;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1052\]Horde Expedition/i", $tart)) $faction_id=1901;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1090\]Kirin Tor/i", $tart)) $faction_id=2006;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1098\]Knights of the Ebon Blade/i", $tart)) $faction_id=2050;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1156\]The Ashen Verdict/i", $tart)) $faction_id=2216;
//if (preg_match("/\[li\]Faction: \[url\=\/faction\=1126\]The Frostborn/i", $tart)) $faction_id=;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1067\]The Hand of Vengeance/i", $tart)) $faction_id=1897;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1073\]The Kalu'ak/i", $tart)) $faction_id=1949;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1105\]The Oracles/i", $tart)) $faction_id=2063;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1094\]The Silver Covenant/i", $tart)) $faction_id=2025;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1119\]The Sons of Hodir/i", $tart)) $faction_id=2107;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1124\]The Sunreavers/i", $tart)) $faction_id=2121;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1064\]The Taunka/i", $tart)) $faction_id=1921;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1091\]The Wyrmrest Accord/i", $tart)) $faction_id=2010;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1050\]Valiance Expedition/i", $tart)) $faction_id=1891;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1085\]Warsong Offensive/i", $tart)) $faction_id=1978;

// Cataclysm
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1177\]Baradin's Wardens/i", $tart)) $faction_id=2354;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1172\]Dragonmaw Clan/i", $tart)) $faction_id=2305;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1158\]Guardians of Hyjal/i", $tart)) $faction_id=2233;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1178\]Hellscream's Reach/i", $tart)) $faction_id=2355;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1173\]Ramkahen/i", $tart)) $faction_id=2331;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1135\]The Earthen Ring/i", $tart)) $faction_id=2167;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1171\]Therazane/i", $tart)) $faction_id=2281;
if (preg_match("/\[li\]Faction: \[url\=\/faction\=1174\]Wildhammer Clan/i", $tart)) $faction_id=2336;

// OTHER
if (preg_match("/\[li\]Faction: \[url\=\/faction=70]Syndicate/i", $tart)) $faction_id=87;
if (preg_match("/\[li\]Faction: \[url\=\/faction=589]Wintersaber Trainers/i", $tart)) $faction_id=874;
//if (preg_match("/\[li\]Faction: \[url\=\/faction=1168]Guild/i", $tart)) $faction_id=;

/*
 ################# HP MANA LEVEL DISPLAY  MONEY  SYSTEM #################################
*/
 
preg_match("/\[li\]Health: (.*?)\[\/li]/is",$tart, $hp);
preg_match("/\[li\]Mana: (.*?)\[\/li]/is",$tart, $mana);
preg_match("/\[li\]Level: (.*?)\[\/li\]/is",$tart, $level);
preg_match("/displayId: (.*?)}\)/is",$tart, $display);
preg_match("/\[money=(.*?)\]/is",$tart, $dropmoney);
if(!isset($mana[0])) $mana[0]=0;
if(!isset($dropmoney[0])) $dropmoney[0]=0;

//raw fajlba iras
if (isset($hp[0])){ 
    // level
fwrite($filehandle2,"UPDATE `creature_template` SET `minlevel` = ".shitremover($level[0],2)." WHERE `entry` = ".$i.";\n");
    // hp
fwrite($filehandle3,"UPDATE `creature_template` SET `minhealth` = ".shitremover($hp[0],1)."  WHERE `entry` = ".$i.";\n");
    //mana
fwrite($filehandle4,"UPDATE `creature_template` SET `minmana` = ".shitremover($mana[0],3)."  WHERE `entry` = ".$i.";\n");
    // money
fwrite($filehandle6,"UPDATE `creature_template` SET `maxgold` = ".shitremover($dropmoney[0],0)."  WHERE `entry` = ".$i.";\n");    

fwrite($filehandle9,"INSERT IGNORE INTO `creature_template` (`entry`) VALUES (".$i.");\n");
}
/*
 ################# PET SYSTEM #################################
*/
if (preg_match("/\[li\]Tameable/i", $tart)) {
    
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=1\]Wolf\[\/url\]/i", $tart)) $family_id=1;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=2\]Cat\[\/url\]/i", $tart)) $family_id=2;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=3\]Spider\[\/url\]/i", $tart)) $family_id=3;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=4\]Bear\[\/url\]/i", $tart)) $family_id=4;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=5\]Boar\[\/url\]/i", $tart)) $family_id=5;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=6\]Crocolisk\[\/url\]/i", $tart)) $family_id=6;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=7\]Carrion Bird\[\/url\]/i", $tart)) $family_id=7;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=8\]Crab\[\/url\]/i", $tart)) $family_id=8;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=9\]Gorilla\[\/url\]/i", $tart)) $family_id=9;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=11\]Raptor\[\/url\]/i", $tart)) $family_id=11;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=12\]Tallstrider\[\/url\]/i", $tart)) $family_id=12;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=20\]Scorpid\[\/url\]/i", $tart)) $family_id=20;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=21\]Turtle\[\/url\]/i", $tart)) $family_id=21;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=24\]Bat\[\/url\]/i", $tart)) $family_id=24;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=25\]Hyena\[\/url\]/i", $tart)) $family_id=25;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=26\]Bird of Prey\[\/url\]/i", $tart)) $family_id=26;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=27\]Wind Serpent\[\/url\]/i", $tart)) $family_id=27;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=30\]Dragonhawk\[\/url\]/i", $tart)) $family_id=30;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=31\]Ravager\[\/url\]/i", $tart)) $family_id=31;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=32\]Warp Stalker\[\/url\]/i", $tart)) $family_id=32;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=33\]Sporebat\[\/url\]/i", $tart)) $family_id=33;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=34\]Nether Ray\[\/url\]/i", $tart)) $family_id=34;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=35\]Serpent\[\/url\]/i", $tart)) $family_id=35;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=37\]Moth\[\/url\]/i", $tart)) $family_id=37;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=38\]Chimaera\[\/url\]/i", $tart)) $family_id=38;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=39\]Devilsaur\[\/url\]/i", $tart)) $family_id=39;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=41\]Silithid\[\/url\]/i", $tart)) $family_id=41;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=42\]Worm\[\/url\]/i", $tart)) $family_id=42;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=43\]Rhino\[\/url\]/i", $tart)) $family_id=43;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=44\]Wasp\[\/url\]/i", $tart)) $family_id=44;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=45\]Core Hound\[\/url\]/i", $tart)) $family_id=45;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=46\]Spirit Beast\[\/url\]/i", $tart)) $family_id=46;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=50\]Fox\[\/url\]/i", $tart)) $family_id=50;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=51\]Monkey\[\/url\]/i", $tart)) $family_id=51;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=52\]Dog\[\/url\]/i", $tart)) $family_id=52;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=53\]Beetle\[\/url\]/i", $tart)) $family_id=53;
    if (preg_match("/\[li\]Tameable \(\[url\=\/pet\=55\]Shale Spider\[\/url\]/i", $tart)) $family_id=55;	
                                 
    fwrite($filehandle8,"UPDATE `creature_template` SET `type_flags` = 1, `family` = ".$family_id." WHERE `entry` = ".$i.";\n");
}

/*
 ################# RANK SYSTEM #################################
*/

// rank
if (isset($hp[0]))
{
$rank=0;
 if (preg_match("/\[li\]Classification: Elite\[\/li\]/i", $tart)) 
 $rank=1;
 if (preg_match("/\[li\]Classification: Rare\[\/li\]/i", $tart)) 
 $rank=4;
 if (preg_match("/\[li\]Classification: Boss\[\/li\]/i", $tart)) 
 $rank=3;

fwrite($filehandle7,"UPDATE `creature_template` SET `rank` = ".$rank." WHERE `entry` = ".$i.";\n");
}

if (isset($display[0])) fwrite($filehandle5,"UPDATE `creature_template` SET  `modelid1` = ".shitremover($display[0],0).", `modelid1f` = ".shitremover($display[0],0)." WHERE `entry` = ".$i.";\n");

if (isset($faction_id) && $faction_id!=0) {
    fwrite($filehandle,"UPDATE `creature_template` SET `faction` =".$faction_id."  WHERE `entry` = ".$i.";\n");
}
$faction_id=0;  
$level[0]=0; 
$hp[0]=0;
}

fwrite($filehandle, "\n -- Done  ".$datum." --\n");
fwrite($filehandle2, "\n -- Done  ".$datum." --\n");
fclose($filehandle);fclose($filehandle2);
fclose($filehandle3);fclose($filehandle4);
fclose($filehandle5);fclose($filehandle6);
fclose($filehandle7);fclose($filehandle8);
fclose($filehandle9);

print"<center><h1> <a href='wowhead_multiripper.php'>Назад</a></h1> </center>";
}

?>

<body>
</body>
</html>
