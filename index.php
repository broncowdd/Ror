<?php 
########################
#                      #
# █████   ████   █████  #
# ██  ██ ██  ██ ██  ██ #
# ██  ██ ██  ██ ██  ██ #
# █████  ██  ██  █████  #
# ██  ██ ██  ██ ██  ██ #
# ██  ██ ██  ██ ██  ██ #
# ██  ██  ████  ██  ██ #
#                      #
########################
# Ror: avatar generator
# @author: bronco@warriordudimanche.net
# howto: use get vars to generate an avatar (once generated, it'll be saved in avatars/ folder)
# ?str=[string] (required)
# ?sz= [integer] avatar's size (opt.) 
# ?c1= [string] avatar's color (opt.)
# ?c2= [string] avatar's background color (opt.)
# ?style=dot (opt.) square by default

###############################
#                             #
#  ░░░░  ░   ░░  ░░░░  ░░░░░░ #
#   ░░   ░░  ░░   ░░   ░ ░░ ░ #
#   ░░   ░░░ ░░   ░░     ░░   #
#   ░░   ░░░░░░   ░░     ░░   #
#   ░░   ░░ ░░░   ░░     ░░   #
#   ░░   ░░  ░░   ░░     ░░   #
#  ░░░░  ░░   ░  ░░░░   ░░░░  #
#                             #
###############################

if (!is_dir('avatars')){
	mkdir('avatars');
}
$avatar_filename='';

if (!empty($_GET['c1'])){
	$c1=strip_tags($_GET['c1']);
	$avatar_filename.='-c1='.$c1;
	$c1=separatRGB($c1);
}
if (!empty($_GET['c2'])){
	$c2=strip_tags($_GET['c2']);
	$avatar_filename.='-c2='.$c2;
	$c2=separatRGB($c2);
}
if (!empty($_GET['sz'])){
	$size=intval(strip_tags($_GET['sz']));
}
if (empty($size)){$size=128;}

$dot=!empty($_GET['style'])&&$_GET['style']=='dot';
$avatar_filename='x'.$size.$avatar_filename.'.png';
$dotsize=$size/9;

##################################################################
#                                                                #
# ░░░░░░ ░░  ░░ ░   ░░  ░░░░  ░░░░░░  ░░░░   ░░░░  ░   ░░  ░░░░  #
# ░░     ░░  ░░ ░░  ░░ ░░  ░░ ░ ░░ ░   ░░   ░░  ░░ ░░  ░░ ░░  ░░ #
# ░░     ░░  ░░ ░░░ ░░ ░░       ░░     ░░   ░░  ░░ ░░░ ░░  ░░    #
# ░░░░░  ░░  ░░ ░░░░░░ ░░       ░░     ░░   ░░  ░░ ░░░░░░   ░░   #
# ░░     ░░  ░░ ░░ ░░░ ░░       ░░     ░░   ░░  ░░ ░░ ░░░    ░░  #
# ░░     ░░  ░░ ░░  ░░ ░░  ░░   ░░     ░░   ░░  ░░ ░░  ░░ ░░  ░░ #
# ░░      ░░░░  ░░   ░  ░░░░   ░░░░   ░░░░   ░░░░  ░░   ░  ░░░░  #
#                                                                #
##################################################################

function separatRGB($color){
    $color=str_replace('#','',$color);
    if (strlen($color)==3){
        $color=$color[0].$color[0].$color[1].$color[1].$color[2].$color[2];
    }
    $RGB=array();
    $RGB['r']=hexdec(substr($color, 0,2));
    $RGB['g']=hexdec(substr($color, 2,2));
    $RGB['b']=hexdec(substr($color, 4,2));  
    return $RGB;
}

function drawLine($linenb,$pattern,$size,$dots=false){
	global $image,$couleur_avatar,$couleur_fond;
	for ($i=0;$i<9;$i++){
		$x=$i*$size;
		$y=$linenb*$size;
		if ($pattern[$i]==1){
			if (!$dots){
				imagefilledrectangle ( $image , $x,$y  , $x+$size ,$y+$size , $couleur_avatar );
			}else{
				imagefilledellipse ( $image , $x+($size/2),$y+($size/2)  , $size ,$size , $couleur_avatar );
			}
		}else{
			imagefilledrectangle ( $image , $x,$y  , $x+$size ,$y+$size ,$couleur_fond);
		}
	}
}



###########################################################
#                                                         #
#  ░░░░  ░░░░░░ ░   ░░ ░░░░░░ ░░░░░   ░░░░  ░░░░░░ ░░░░░░ #
# ░░  ░░ ░░     ░░  ░░ ░░     ░░  ░░ ░░  ░░ ░ ░░ ░ ░░     #
# ░░     ░░     ░░░ ░░ ░░     ░░  ░░ ░░  ░░   ░░   ░░     #
# ░░ ░░░ ░░░░░  ░░░░░░ ░░░░░  ░░░░░  ░░░░░░   ░░   ░░░░░  #
# ░░  ░░ ░░     ░░ ░░░ ░░     ░░  ░░ ░░  ░░   ░░   ░░     #
# ░░  ░░ ░░     ░░  ░░ ░░     ░░  ░░ ░░  ░░   ░░   ░░     #
#  ░░░░  ░░░░░░ ░░   ░ ░░░░░░ ░░  ░░ ░░  ░░  ░░░░  ░░░░░░ #
#                                                         #
###########################################################
if (!empty($_GET['str'])){
	$h1=hash('crc32',$_GET['str']);
	$h2=hash('crc32b',$_GET['str']);
	$d=($dot===true)?'dot':'';

	if (empty($c1)){$c1 = separatRGB($h1);}
	if (empty($c2)){$c2 = separatRGB($h2);}

	$s=$h1.$h2[0].$d;
	$file='avatars/'.$s.$avatar_filename;

	if (is_file($file)){
		header ("Content-type: image/png");
		exit(file_get_contents($file));
	}

	$image = @ImageCreate ($size, $size) or die ("Erreur lors de la création de l'image");
	$couleur_fond   = ImageColorAllocate ($image, $c1['r'], $c1['g'], $c1['b']);
	$couleur_avatar = ImageColorAllocate ($image, $c2['r'], $c2['g'], $c2['b']);

	$a[dechex(0)]='000010000';
	$a[dechex(16)]='111111111';

	for ($i=1;$i<=15;$i++){
		$bin=decbin($i);
		$bin=str_repeat('0', 4-strlen($bin)).$bin;
		$a[dechex($i)]=$bin.'1'.strrev($bin);
	}

	
	
	for ($i=0;$i<9;$i++){
		drawLine($i,$a[$s[$i]],$dotsize,$dot);
	}

	header ("Content-type: image/png");
	
	ImagePng($image,$file);
	chmod($file,0644);
	ImagePng($image);
}


?>
