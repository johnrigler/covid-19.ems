<html>
<head>
<meta http-equiv="refresh" content="10000">
<style>
a {text-decoration:none; size:14px;}
p {color:blue;}
span.Cx {color:brown;}
span.s {color:blue;}
span.t {color:green;}
span.u {color:purple;}
span.v {color:orange;}
span.prefix {color:#d2d7dc;}
span.lh {color:#d2d7dc;}
span.lx {color:#d2d7dc;}
span.lz {color:#d2d7dc;}
span.header {color:blue; size:12px;}
table {border:1;}
div { color: blue; size:40px; }
</style>
</head>
<body>
<pre> 
<?php

function printer($array) {

	echo "<pre>";
	print_r($array);
	echo "</pre>";

}

function files() {
	$files = explode("\n",`ls`);
	array_pop($files);
	foreach($files as $str)
{
	$str = str_replace(array("\n", "\r"), '', $str);
	echo "<a href=index.php?function=$str>$str</a><br>\n";
	}

}

function unspendable($prefix,$address,$countdown,$code="0.00010000") {


	if($countdown == 2)
		$end = '}"';
	else
	$end = ',\\<br>';


	/// calculating

	$chop=rtrim(chop($address),";");
	$prefix_len=strlen($prefix);
	$base58=`python3 /home/john/alp/unspendable/unspendable.py $prefix "$chop"`;
	$body=substr($base58,$prefix_len);
	list($words,$padding) = explode("z",$body);
	$zpos = strpos($body,"z");
	$ending = substr($body,$zpos);
	$ending = chop($ending);
	$words = str_replace("x","<span class=lx>x</span>",$words);
	$words = str_replace("h","<span class=lh>h</span>",$words);
        $prefix_class = substr($prefix,1);

	/// printing
       
	echo "\\\"<span class=prefix>$prefix</span><span class=$prefix_class>$words</span><span class=lz>$ending</span>\\\":$code$end";
}

////// Main Body Here
//
 
///// Pretty
//
//
//
//

$file = $_GET['function'];

$rmt="https://live.blockcypher.com/doge/address";


	echo "<table border=1>";
echo "<tr><td>$file <a href=$file>(view/download)</a></td></tr><tr><td><pre>";
 	echo `cat $file`;
	echo "</pre></tr><tr><td>";

        //////  Definition

	$key = array("a"=>"a","d"=>'DCx',"s"=>"9s","t"=>"9t","u"=>"9u","v"=>"9v");
	$remote = "https://blockchair.com/dogecoin/transaction";

	///// Read the bash function into an array 



	$read=file($file);
	///// Remove lines that are commented

	$function_lines = array();
	$comments = array();
	
	foreach($read as $index => $line)  {

		if ($line[0] == '#') {
			$comments[] = substr($line,2);
		}
		else 
		{
		$function_lines[] = $line;
		}

	}

	list($function_name,$shoctal_cksum) = explode("-",$file);
	list($shocktal_sum,$shocktal_sz) = explode(".",$shoctal_cksum);

	$code = array();

	$divide = strlen($shocktal_sum)-7;
	$code[0] = substr($shocktal_sum,$divide);
	$code[1] = substr($shocktal_sum,0,$divide);
	$code[2] = $shocktal_sz;

	// printer($code);

	$countdown = sizeof($function_lines);

	foreach($function_lines as $index => $line)
	{

		if ($index == 0)
		{       
		echo "<span class=prefix>";
		echo 'dogecoin-cli sendmany "" "{\<br>';
		echo "</span>";
		$amount = "0.0" . $code[0];
		unspendable("DCx",$line,$countdown,$amount); 
		}


	$first=$line[0]; 

	if ($first == " ")
		{ 
			$cmd=$line[4];
		if($cmd == "a")
		{
			$real_address = substr($line,6,34);
			$satoshi_code = substr($line,41,11);
			echo "\\\"$real_address\\\":$satoshi_code}\"";
			continue;
		}
		$rest=substr($line,6);
		$prefix = $key[$cmd];
		$amount =  "0.0001" . str_pad($code[$index-1],4,"0", STR_PAD_LEFT);
		$rest = str_replace("[","(",$rest);
		$rest = str_replace("]",")",$rest);
		unspendable($prefix,$rest,$countdown,$amount);
	}

	elseif ( $first == "#" )
	{
	#	echo "$first";
	}

	$countdown = $countdown -1;
	}

	        echo    "</td><td><img src=$code[0].png></tr>";


	echo "</tr><tr><td>";

	foreach($comments as $transaction)
	{
		echo "<a href=$remote/$transaction> $transaction </a>";
	}
	
		
	echo	"</td></table>";

?>

</pre>

<?php files(); ?>
</body>
</html>
