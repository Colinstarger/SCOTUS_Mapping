<?php

define("EOL", "\r\n", true);
require '../Libs/scotus_objects.php';
require '../Data/data_2015_Term.php';

/* Example 1
function cmp($a, $b)
{
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}

$a = array(3, 2, 5, 6, 1);

echo "before usort ". EOL;
foreach ($a as $key => $value) {
    echo "$key: $value\n";
}

usort($a, "cmp");

echo "after usort ". EOL;
foreach ($a as $key => $value) {
    echo "$key: $value\n";
}


function cmp($a, $b)
{
    return strcmp($a["fruit"], $b["fruit"]);
}

$fruits[0]["fruit"] = "lemons";
$fruits[1]["fruit"] = "apples";
$fruits[2]["fruit"] = "grapes";

echo "before" . EOL;
while (list($key, $value) = each($fruits)) {
    echo "\$fruits[$key]: " . $value["fruit"] . "\n";
}


usort($fruits, "cmp");

echo "after" . EOL;
while (list($key, $value) = each($fruits)) {
    echo "\$fruits[$key]: " . $value["fruit"] . "\n";
}
*/

class TestObj {
    var $name;
    var $age;
    var $DOD;

    function TestObj($name)
    {
        $this->name = $name;
    }

    public function addAgeDOD($age, $DOD){
    	$this->age = $age;
    	$this->DOD = $DOD;
    }

    /* This is the static comparing function: */
    static function cmp_obj($a, $b, $option=0)
    {

    	if ($option==0){
        	$al = strtolower($a->name);
        	$bl = strtolower($b->name);
        	if ($al == $bl) {
        	    return 0;
        	}
        	return ($al > $bl) ? +1 : -1;
    	}
    	else {

    		return strcmp (($a->age), ($b->age));
    	}

    }

    public function echoSelf() {
    	echo "Name = ".$this->name."; Age = ". $this->age . "; DOD = ". $this->DOD . EOL;
    }
}

class CollectTestObj {

	public $name;
	private $object_array = array();


  public function add_TestObj ($obj) {
    array_push($this->object_array, $obj);
  }

  public function sort_by_name () {

  	usort($this->object_array, array("TestObj", "cmp_obj"));
  }

  public function echoCollect(){
  	echo "Name = " . $this->name . EOL;
  	echo "Object array = ";

  	foreach ($this->object_array as $object) {
  		$object->echoSelf();
  	}

  }
}

/*
$a[] = new TestObj("Colin");
$a[0]->addAgeDOD(49, 55.5);
$a[] = new TestObj("Boris");
$a[1]->addAgeDOD(42, 33.33);
$a[] = new TestObj("Daisy");
$a[2]->addAgeDOD(2, 40.44);
*/

/*
$collect = new CollectTestObj;

$a = new TestObj("Colin");
$a->addAgeDOD(49, 55.5);

$collect->add_TestObj($a);

$b = new TestObj("Boris");
$b->addAgeDOD(42, 33);

$collect->add_TestObj($b);

$c = new TestObj("Daisy");
$c->addAgeDOD(2, 2);

$collect->add_TestObj($c);

echo "Before sort". EOL;
$collect->echoCollect();

$collect->sort_by_name();

echo "After sort". EOL;
$collect->echoCollect();
*/

echo 'BEFORE SORT BOOGIE ****************************' . EOL;
$term_2015->echo_collection();

$term_2015->sort_by_3d_size(false);

echo EOL.EOL.EOL.'AFTER SORT BOOGIE ******************************'.EOL;
$term_2015->echo_collection();



?>