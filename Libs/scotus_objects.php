<?php
 
 define("EOL", "\r\n", true);
 date_default_timezone_set('America/New_York');

// ************************ CL_Network        
class CL_Network {
    
    public $cl_num;
    public $title = "";
    public $new_anchor = "";
    public $new_anchor_date = "";
    public $subject_area = "";
    public $old_anchor = "";
    public $old_anchor_date = "";
    public $num_3d = 0;
    public $DOD_3d = 0;
    public $num_2d = 0;
    public $DOD_2d = 0;
    public $blog_url = "";
    
    // Constructing requires a network number for now
    public function __construct($cl_num) {
      $this->cl_num = $cl_num;
    }

    public function set_new_anchor_date ($datestr) {
      $this->new_anchor_date = date_create($datestr);
    }

    public function set_old_anchor_date ($datestr) {
      $this->old_anchor_date = date_create($datestr);
    }

    public function add_term_collection_data ($new_anchor,
                                              $new_anchor_date,
                                              $subject_area,
                                              $blog_url,
                                              $old_anchor,
                                              $old_anchor_date,
                                              $num_3d,
                                              $DOD_3d,
                                              $num_2d,
                                              $DOD_2d) {

        $this->new_anchor=$new_anchor;
        $this->set_new_anchor_date($new_anchor_date);
        $this->subject_area=$subject_area;
        $this->blog_url=$blog_url;
        $this->old_anchor=$old_anchor;
        $this->set_old_anchor_date($old_anchor_date);
        $this->num_3d=$num_3d;
        $this->DOD_3d=$DOD_3d;
        $this->num_2d=$num_2d;
        $this->DOD_2d=$DOD_2d;
    }

    
    public function cl_url() {

      $url = "https://courtlistener.com/visualizations/scotus-mapper/" . $this->cl_num . "/slug";
      return $url;
    }

    public function calc_network_age_years () {

     
      $interval = date_diff($this->old_anchor_date, $this->new_anchor_date);
      $age= round (($interval->format('%a'))/365,2);

      return $age;
    }

    public function echo_term_row () {

      // Special function to create Term table
      echo "<tr>";
      echo "<td><a href='". $this->cl_url() ."'>".$this->new_anchor."</a></td>";
      echo "<td>". date_format($this->new_anchor_date, "Y-m-d") ."</td>";
      echo "<td><a href='". $this->blog_url ."'>".$this->subject_area."</a></td>";
      echo "<td>".$this->old_anchor . "</td>";
      echo "<td>". date_format($this->old_anchor_date, "Y-m-d") . "</td>";
      echo "<td>".$this->calc_network_age_years() . "</td>";

      $x= $this->num_3d;
      if ($x==-1) {
        echo "<td>tb </td>";
      }
      else {
        echo "<td>".$x."</td>";  
      }
      
      $x = $this->DOD_3d;
      if ($x==-1){
       echo "<td>tb </td>"; 
      }
      else {
        echo "<td>".$x."</td>";  
      }
      
      echo "<td>".$this->num_2d."</td>";
      echo "<td>".$this->DOD_2d."</td>";
      echo "</tr>".EOL;

    }
    public function echo_network () {

      /* this is purely a debugging function */

      echo "Number= " . $this->cl_num . "; ";
      echo "Title= " . $this->title . "; ";
      echo "new_anchor= " .  $this->new_anchor . "; ";

      $d = $this->new_anchor_date;
      if (gettype($d)=='object') {
        echo "new_anchor_date = ". date_format($d, "Y-m-d") . "; ";
      }
      else {
        echo "new_anchor_date= " .  $this->new_anchor_date . "; ";
      }
      
      echo "subject_area= ". $this->subject_area . "; ";
      echo "blog_url= ". $this->blog_url . "; ";
      echo "old_anchor= ".  $this->old_anchor. "; ";

      $d= $this->old_anchor_date;
      if (gettype($d)=='object') {
        echo "old_anchor_date = ". date_format($d, "Y-m-d") . "; "; 
      }
      else {
        echo "old_anchor_date= ".  $this->old_anchor_date. "; ";  
      }
      
      echo "num_3d= ".  $this->num_3d. "; ";
      echo "DOD_3d= ".  $this->DOD_3d. "; ";
      echo "num_2d= ".  $this->num_2d. "; ";
      echo "DOD_2d= ".  $this->DOD_2d. EOL;

    }

    static function compare_3d_size ($aa, $bb) 
    {
      $a = $aa->num_3d;
      $b = $bb->num_3d;

      if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;

    }

    public function scrape_table_data() {

        $html= file_get_contents($this->cl_url()); 
  
        # Create a DOM parser object
        $dom = new DOMDocument();
        @$dom->loadHTML($html);


        //First Get New Anchor
        $anchors = $dom->getElementsByTagName('h4');
        $anchorstr =  $anchors->item(0)->nodeValue;


        //This is a total hack to clean up the string, but it works
        $anchorstr = str_replace ("\n", "", $anchorstr);
        $anchorstr = str_replace(", ",",?", $anchorstr);
        $anchorstr = str_replace("  ","", $anchorstr);
        $anchorstr = str_replace(",?",", ", $anchorstr);
        $anchorstr = str_replace("  "," ", $anchorstr);

        
        $y = stripos($anchorstr, 'cases starting at ');
        $y+=18; // 'cases starting at ' is 18 chars long

        $x = stripos($anchorstr, ', and');
        $y_length = $x-$y;
        $old_anchor = substr($anchorstr, $y, $y_length);

       

        $old_anchor = rtrim($old_anchor);
        $old_anchor = rtrim($old_anchor, ',');


        
        // Check to see if there is a short name
        preg_match('/"case_name": "'.$old_anchor.'",[\s]*"case_name_short": "([\w  \.]+)/', $html, $short_name_matches);

        if ($short_name_matches != NULL) {
          echo "found short name ". $short_name_matches[1] . EOL;
          //found a short name
          $old_anchor = $short_name_matches[1];
        }

        $x = stripos($anchorstr, 'and going to '); 
        $x += 13;  // 'and going to ' is 13 chars long
        $new_anchor = substr($anchorstr, $x);
        $new_anchor = rtrim($new_anchor);
        $new_anchor = rtrim($new_anchor, '.');

        //echo "The new anchor is $new_anchor".EOL;

        //Second Get All the dates of the cases for new and old anchors

        preg_match_all('/"date_filed": "([\d]+-[\d]+-[\d]+)"/', $html, $date_filed_matches, PREG_PATTERN_ORDER);
        

        $date_filed_array = array();
        $x = count($date_filed_matches[1]);
        
        foreach ($date_filed_matches[1] as $strdate) {
          $date_filed_array[]=$strdate;
        }
        
        rsort($date_filed_array);
        $new_anchor_date = $date_filed_array[0]; //Now the latest, save
        $old_anchor_date = $date_filed_array[$x-1]; //Last item in the array

        // Third, start parsing description filed

        $desc_node = $dom->getElementById('notes');  
        $subject_area = $desc_node->getElementsByTagName('h3')->item(0)->nodeValue;
        $subject_area = trim($subject_area);

        // Assuming SCOTUS blog is the second url in the first paragraph...
        $blog_url = $desc_node->getElementsByTagName('p')->item(0)->getElementsByTagName('a')->item(1)->getAttribute('href');

        
        //Call this as separate function because it involves a different process
        $phantom_array = $this->scrape_DOD_info($num_3d, $DOD_3d, $num_2d, $DOD_3d); // WHILE TESTING REMOVE

        //$phantom_array = array (1,2,3,4); // during testing only!

        $num_3d = $phantom_array[0]; 
        $DOD_3d = $phantom_array[1];
        $num_2d = $phantom_array[2];
        $DOD_2d = $phantom_array[3];

        $this->add_term_collection_data ($new_anchor, $new_anchor_date, $subject_area, $blog_url, $old_anchor, $old_anchor_date, $num_3d, $DOD_3d, $num_2d, $DOD_2d);

    }

    private function scrape_DOD_info (){

      $url = $this->cl_url();

      $this->write_DOD_phantom_script($url);
      $parsed = $this->execute_and_parse_phantom_script();
      $num_3d = $parsed[0];
      $DOD_3d = $parsed[1];

      $url = $url . "?dos=2";
      $this->write_DOD_phantom_script($url);
      $parsed = $this->execute_and_parse_phantom_script();
      $num_2d = $parsed[0];
      $DOD_2d = $parsed[1];

      $return_array = array ($num_3d, $DOD_3d, $num_2d, $DOD_2d);

      return $return_array;
    }

    private function write_DOD_phantom_script($url) {

      $targetfile = '/Users/colinstarger/Desktop/Coding/PHP/SCOTUS/Scripts/temp_phantom.js';

      $file = fopen($targetfile, "w") or die("Unable to open file $filename");

      $filetext= "var page = require('webpage').create();
      page.open('". $url . "', function() {
        page.includeJs('http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', function() {
          var search = page.evaluate(function() { 
              return  $('#dod-info').text();
          });
          console.log(search);
          phantom.exit()
        });
      })";

      fwrite($file, $filetext);
      fclose($file);

    }

    private function execute_and_parse_phantom_script() {

      $pathToPhatomJs = '/Users/colinstarger/Desktop/Coding/Phantom/phantomjs-2.1.1-macosx/bin/phantomjs';

      $pathToJsScript = '/Users/colinstarger/Desktop/Coding/PHP/SCOTUS/Scripts/temp_phantom.js';

      $stdOut = exec(sprintf('%s %s', $pathToPhatomJs,  $pathToJsScript), $out);
      trim($stdOut);

      $x = stripos($stdOut, ' for ');
      $DOD_str = substr($stdOut, 0, $x+1);
      $DOD = (float)$DOD_str;

      $x = stripos($stdOut, ' cases of ');
      $x += 10;
      $num_str = substr($stdOut, $x, (strlen($stdOut)-x));
      $num = (int)$num_str;

      $return_array = array($num, $DOD);
      return $return_array;
    }


  } //class SCOTUS_Network

// ************************ Network_Collection
class Network_Collection {

  public $network_array = array(); 
  public $name;

  public function __construct($name) {
    $this->name = $name; 
  }

public function write_PHP_datafile ($targetfile, $collection_var_name) 
{

  $file = fopen($targetfile, "w") or die("Unable to open file $targetfile");

  $filetext= "<?php ".EOL;
  fwrite($file, $filetext);

  $filetext = "\$$collection_var_name = new Network_Collection('". $this->name ."');".EOL;
  fwrite($file, $filetext);

  foreach ($this->network_array as $network) {
    
    $network_num = $network->cl_num;
    $new_anchor = $network->new_anchor;
    $new_anchor_date = date_format($network->new_anchor_date, "Y-m-d");
    $subject_area = $network->subject_area;
    $old_anchor = $network->old_anchor;
    $old_anchor_date = date_format($network->old_anchor_date, "Y-m-d");
    $num_3d = $network->num_3d;
    echo "Num 3d = $num_3d; ";
    $DOD_3d = $network->DOD_3d;
    echo "DOD 3d = $DOD_3d; ";
    $num_2d = $network->num_2d;
    echo "Num 2d = $num_2d";
    $DOD_2d = $network->DOD_2d;
    echo "DOD 2d = $DOD_2d";
    $blog_url = $network->blog_url;
    echo "Blog url = $blog_url".EOL;

    $filetext = "\$map = new CL_Network($network_num);".EOL;
    fwrite($file, $filetext);

    $filetext = "\$map->add_term_collection_data(\"$new_anchor\", '$new_anchor_date', '$subject_area', '$blog_url', \"$old_anchor\",'$old_anchor_date', $num_3d, $DOD_3d, $num_2d, $DOD_2d);".EOL;
    fwrite($file, $filetext);

    $filetext = "\$$collection_var_name"."->add_network(\$map);".EOL;
        fwrite($file, $filetext);
  }

  $filetext= "?>";
  fwrite($file, $filetext);

  fclose($file);

}

  public function add_network ($network) {
    array_push($this->network_array, $network);
  }

  public function echo_collection () {

    echo "Name = " . $this->name . EOL;
    echo "This collection has " . count($this->network_array) . " maps\r\n ";
    foreach ($this->network_array as $network) {
      $network->echo_network();
    }
  }

  public function echo_term_rows () {
    foreach ($this->network_array as $network) {
      $network->echo_term_row();
    }
  }

  public function number_networks () {
    $num = count($this->network_array);
    return $num;
  }

  public function network_average_age_years() {

    $age = 0;
    foreach ($this->network_array as $network) {
        $age += $network->calc_network_age_years();
    }
    
    if ($age>0) {
      $average_age = $age/$this->number_networks();
      return round($average_age,2);
    } 
    else {
      return NULL;
    }
    
  }

  public function network_median_age_years() {

    $arr = array(); 
    foreach ($this->network_array as $network) {
        array_push($arr, $network->calc_network_age_years());
    }
    sort($arr);

    $count = count($arr); //total numbers in array
    $median_age=0;

    if ($count>0){
        $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
        if($count % 2) { // odd number, middle is the median
            $median_age = $arr[$middleval];
        } else { // even number, calculate avg of 2 medians
            $low = $arr[$middleval];
            $high = $arr[$middleval+1];
            $median_age = (($low+$high)/2);
        }
        return round($median_age,2); 
    }
    else {return NULL; }
    
  } // network_median_age_years

  public function network_average_num_3D_cases() {

    $tb_cases= 0;
    $num = 0;
    foreach ($this->network_array as $network) {

        $num3d = $network->num_3d;


        if (!($num3d== -1)){
          $num += $num3d;  
        }
        else {
          $tb_cases ++;
        }
        
    }
  
    if ($num>0) {
      $average_num = $num/($this->number_networks()-$tb_cases);
      return round($average_num,2);
    } 
    else {
      return NULL;
    }
    
  }

  public function network_median_num_3D_cases() {

    $arr = array(); 
    foreach ($this->network_array as $network) {
        if ($network->num_3d>0){
          array_push($arr, $network->num_3d);  
        }
        
    }
    sort($arr);

    $count = count($arr); //total numbers in array
    
    $median=0;

    if ($count>0){
        $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
        if($count % 2) { // odd number, middle is the median
            $median = $arr[$middleval];
        } else { // even number, calculate avg of 2 medians
            $low = $arr[$middleval];
            $high = $arr[$middleval+1];
            $median = (($low+$high)/2);
        }
        return round($median,2); 
    }
    else {return NULL; }
    
  } // network_median_num_3d_cases

    public function network_average_num_2D_cases() {

    $num = 0;
    foreach ($this->network_array as $network) {
        $num += $network->num_2d;
    }
  
    if ($num>0) {
      $average_num = $num/$this->number_networks();
      return round($average_num,2);
    } 
    else {
      return NULL;
    }
    
  }

  public function network_median_num_2D_cases() {

    $arr = array(); 
    foreach ($this->network_array as $network) {
        array_push($arr, $network->num_2d);
    }
    sort($arr);

    $count = count($arr); //total numbers in array
    
    $median=0;

    if ($count>0){
        $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
        if($count % 2) { // odd number, middle is the median
            $median = $arr[$middleval];
        } else { // even number, calculate avg of 2 medians
            $low = $arr[$middleval];
            $high = $arr[$middleval+1];
            $median = (($low+$high)/2);
        }
        return round($median,2); 
    }
    else {return NULL; }
    
  } // network_median_num_2D_cases

public function network_average_3D_DOD() {

    $dod = 0;
    foreach ($this->network_array as $network) {
        $dod += $network->DOD_3d;
    }
  
    if ($dod>0) {
      $average_dod = $dod/$this->number_networks();
      return round($average_dod,4);
    } 
    else {
      return NULL;
    }
    
  }

  public function network_median_3D_DOD() {

    $arr = array(); 
    foreach ($this->network_array as $network) {
        array_push($arr, $network->DOD_3d);
    }
    sort($arr);

    $count = count($arr); //total numbers in array
    
    $median=0;

    if ($count>0){
        $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
        if($count % 2) { // odd number, middle is the median
            $median = $arr[$middleval];
        } else { // even number, calculate avg of 2 medians
            $low = $arr[$middleval];
            $high = $arr[$middleval+1];
            $median = (($low+$high)/2);
        }
        return round($median,4); 
    }
    else {return NULL; }
    
  } // network_median_age_years
public function network_average_2D_DOD() {

    $dod = 0;
    foreach ($this->network_array as $network) {
        $dod += $network->DOD_2d;
    }
  
    if ($dod>0) {
      $average_dod = $dod/$this->number_networks();
      return round($average_dod,4);
    } 
    else {
      return NULL;
    }
    
  }

  public function network_median_2D_DOD() {

    $arr = array(); 
    foreach ($this->network_array as $network) {
        array_push($arr, $network->DOD_2d);
    }
    sort($arr);

    $count = count($arr); //total numbers in array
    
    $median=0;

    if ($count>0){
        $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
        if($count % 2) { // odd number, middle is the median
            $median = $arr[$middleval];
        } else { // even number, calculate avg of 2 medians
            $low = $arr[$middleval];
            $high = $arr[$middleval+1];
            $median = (($low+$high)/2);
        }
        return round($median,4); 
    }
    else {return NULL; }
    
  } // network_median_age_years

  public function sort_by_3d_size () {

    usort($this->network_array, array("CL_Network", "compare_3d_size"));

  }

  public function scrape_table_data_collection() {

    foreach ($this->network_array as $network) {
      $network->scrape_table_data();
    }
  }

} // class network_collection

/**
     HELPER FUNCTIONS 

**/

function combine_network_collections ($new_name, $collection1, $collection2) {

  $new_collection = new Network_Collection($new_name);

  //Go through and add each network from the old collections to the new collection

  $a = $collection1->network_array;
  foreach ($a as $network) {
    $new_collection->add_network($network);
  }

  $a = $collection2->network_array;
  foreach ($a as $network) {
    $new_collection->add_network($network);
  }

  return $new_collection;

}

     