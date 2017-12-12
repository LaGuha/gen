<?

$length=20;

	function set_routes($num_elements){
		$elements_length=array();
		$count=$num_elements;
		for ($i=1; $i <$num_elements ; $i++) { 
			
			for ($j=$i+1; $j <$count+1; $j++) { 
				$elements_length[$i][$j]=rand(1,42);
			}
			
		}
		return $elements_length;
	}
$route=set_routes($length);

	function chromosome($length){
		$chromosome=array();
		for ($i=0; $i <$length ; $i++) { 
			$chromosome[]=$i+1;
		}
		for ($i=$length-1; $i >-1 ; $i--) { 
				$j=rand(0,$length-1);
				$buf=$chromosome[$i];
				$chromosome[$i]=$chromosome[$j];
				$chromosome[$j]=$buf;
		}
		return $chromosome;
	}
		
	function chr_len($chr){
		$route=0;
		for ($i=0; $i < count($chr)-1 ; $i++) { 
			if ($chr[$i]<$chr[$i+1]){
				$route+=$GLOBALS['route'][$chr[$i]][$chr[$i+1]];	
			}elseif ($chr[$i]==$chr[$i+1]) {
				$route=999999;
			}else{
				$route+=$GLOBALS['route'][$chr[$i+1]][$chr[$i]];
			}
			
		}
		return $route;
	}

	function crossingover($chr1,$chr2,$length){
		$count=round($length/2);
		//$count=$count+round($count/2);
		$child1=array();
		$child2=array();
		for ($i=0; $i <$count ; $i++) { 
			$child1[]=$chr1[$i];
			$child2[]=$chr2[$i];
		}
		for ($i=$count; $i <$length ; $i++) { 
			$child1[]=$chr2[$i];
			$child2[]=$chr1[$i];
		}

		if (chr_len($child1)<chr_len($child2)){
			return $child1;
		}else{
			return $child2;
		}
	}

	function mutation($chr,$length){
		$j=rand(0,$length-1);
		$i=rand(0,$length-1);
		$buf=$chr[$i];
		$chr[$i]=$chr[$j];
		$chr[$j]=$buf;
		return $chr;
	}	

	$population=array();
	$child=array();
	for ($q=0; $q <5 ; $q++) { 
		for ($i=0; $i <1000 ; $i++) { 
			$population[$i]=chromosome($length);
		}
		for ($i=0; $i <5 ; $i++) { 
			$count=0;
			echo "<b>Поколение" . $i . "</b><br>";
			$population2=array();
			for ($j=0; $j < 7000 ; $j++) { 
					$n1=rand(0,count($population)-1);
					$n2=rand(0,count($population)-1);
					$child=array_values(crossingover($population[$n1],$population[$n2],$length));
				if ((chr_len($child) <= chr_len($population[$n1])) && (chr_len($child) <=  chr_len($population[$n2])) && ( count(array_unique($child)) == $length)){
					if (rand(1,10000)==42){
						$child=mutation($child,$length);
					}
					$population2[$count]=$child;
					$count+=1;
					print_r($child);
					echo "<br>";
				}
			}
			if (!count($population2)){
				break;
			}
			unset($population);
			$population=array_values($population2);
			unset($population2);
			
		}
		$min=$population[0];
		for ($i=1; $i <count($population) ; $i++) { 
			if (chr_len($population[$i])<chr_len($min)){
				$min=$population[$i];
			}
		}
		echo "<b>Наикратчайший путь:</b> <br>";
		print_r($min);
		echo("<br><b>Его длина:</b> <br>");
		echo chr_len($min);
		unset($population);# code...
	}
	

?>