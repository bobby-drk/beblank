<?php
/***********************************************************************
* Filename.......: Functions
* Summary:.......: random set of functions
***********************************************************************/

/*******************************************************************
* Class Name: Functions
* Desciption: 
*******************************************************************/
class Functions
{
	/******************************************************************
	* Function Name: colswap
	* Parameters: array, number of columns
	* Description: change order of array from left to right, to top to bottom
	* Return type: array
	*******************************************************************/
	function colswap($array, $numcols)
	{
        $minPerRow = floor(count($array) / $numcols);
        $remaining = count($array) % $numcols;
        $colCount = array();
        for ($i = 0; $i< $numcols; $i++) 
        {
            if ($i < $remaining) 
            {
                array_push($colCount,$minPerRow+1);
            }
            else 
            {
                array_push($colCount,$minPerRow);
            }
        }
        
        $new_array = array();
        
        $count = 0;
        
        
        for ($i = 0; $i < count($colCount); $i++) 
        {
            for ($j = 0; $j <$colCount[$i]; $j++) 
            {
               $new_array[$i][$j] = $array[$count];
                
                $count = $count + 1;
            }
        }

        return $new_array;
    }
    
    /******************************************************************
	* Function Name: muticol_colswap
	* Parameters: array, number of columns
	* Description: change order of array from left to right, to top to bottom
	* Return type: array
	*******************************************************************/
	function muticol_colswap($array, $numcols)
	{
        $minPerRow = floor(count($array) / $numcols);
        $remaining = count($array) % $numcols;
        $colCount = array();
        $keys = array_keys($array);
        
        for ($i = 0; $i< $numcols; $i++) 
        {
            if ($i < $remaining) 
            {
                array_push($colCount,$minPerRow+1);
            }
            else 
            {
                array_push($colCount,$minPerRow);
            }
        }
        
        $new_array = array();
        
        $count = 0;
        
        
        for ($i = 0; $i < count($colCount); $i++) 
        {
            for ($j = 0; $j <$colCount[$i]; $j++) 
            {
               $new_array[$i][$j]['value'] = array_shift($array);
                $new_array[$i][$j]['key'] = array_shift($keys);
                
                $count = $count + 1;
            }
        }


        return $new_array;
    }
	/******************************************************************
	* Function Name: clean_string
	* Parameters: string
	* Description: make a string css ID/Class safe
	* Return type: str
	*******************************************************************/
	function clean_string($str)
	{
		$str = str_replace(" ", "_", $str);
		$str = str_replace("'", "", $str);
		$str = str_replace("\"", "", $str);
		$str = str_replace("\\", "", $str);
		$str = strtolower($str);
		
        return $str;
    }
}
?>
