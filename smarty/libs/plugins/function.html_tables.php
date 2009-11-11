<script language="php">
/*Table bulding class - Rico Pundrich (2003)
  this code is freeware for private using
*/


  class make_tables{

   var $cols = 0;
   var $rows = 0;
   var $data_array = array();
   var $newtable = "";
   var $is_set_data = false;

   //build the table prestring
   function make_tables($rows, $cols){

          $this->rows=$rows;
          $this->cols=$cols;

          $this->newtable .= "<table[attr_table]>\n";
          for($i=0; $i < $this->rows; $i++){

               $this->newtable .= "  <tr[attr_row_".$i."]>\n";

                  for($u=0; $u<$this->cols; $u++){

                        $this->newtable .= "    <td[attr_col_".$i.".".$u."]>\n";
                        $this->newtable .= "      [data_".$i.".".$u."]\n";
                        $this->newtable .= "    </td>\n";
                  }

               $this->newtable .= "  </tr>\n";

          }
          $this->newtable .= "</table>\n";
   }

   //set attributes for the table
   function set_table_attributes($attr_table=""){

           $this->is_set_attributes = true;

           $this->newtable = str_replace("[attr_table]", " ".$attr_table, $this->newtable);

   }

   //set attributes for rows
   function set_row_attributes($attr_row="", $num_row=0, $all=false){

           for($i=0; $i<$this->rows; $i++){

                      if($i == $num_row-1 || $all == true){
                             $this->newtable = str_replace("[attr_row_".$i."]", " ".$attr_row."[attr_row_".$i."]", $this->newtable);
                             if($all == false) break;
                      }
           }



   }

   //set attributes for cols
   function set_col_attributes($attr_col="", $num_row=0, $num_col=0, $all=false){

           for($i=0; $i<$this->rows; $i++){

                  for($u=0; $u<$this->cols; $u++){
                      if($i == $num_row-1 && $u == $num_col-1 || $all == true){
                             $this->newtable = str_replace("[attr_col_".$i.".".$u."]", " ".$attr_col."[attr_col_".$i.".".$u."]", $this->newtable);
                             if($all == false) break;
                      }
                  }
           }



   }

   //put the data into the table
   function set_table_data($data_array){

           $this->data_array = $data_array;
           $this->is_set_data = true;
           $replace_with = "";

           for($i=0; $i<$this->rows; $i++){

                  for($u=0; $u<$this->cols; $u++){

                      if(!empty($this->data_array[$i][$u])){
                         $replace_with = $this->data_array[$i][$u];
                      }else{
                         $replace_with = "";
                      }
                      $this->newtable = str_replace("[data_".$i.".".$u."]", $replace_with, $this->newtable);
                      $this->newtable = str_replace("[attr_row_".$i."]", "", $this->newtable);
                      $this->newtable = str_replace("[attr_col_".$i.".".$u."]", "", $this->newtable);
                  }
           }

   }

   //return the tablestring
   function get_table(){

         $err = false;
         if($this->is_set_data == false) $err = "Error: no data in table!";
         //if($this->is_set_attributes == false) $err = "Error: no table attributes set";

         if($err == false){
             return ($this->newtable);
         }else{
             return ($err);
         }


   }

  }
</script>