<?
namespace Model;

class Task1 extends \Core\Model{
    
    protected static $_disable_persistance=true;
    
    public static function multiples_sum($threshold, $ints = array()){
        
        \Core\Log::info("Start searching for given numbers multiples sum.");
        
        $sum=0;
        $multiples = array();
        
        foreach($ints as $int_index => $int){
            \Core\Log::info("Multipes of $int");
            $mult=0;
            for($i=1;$mult<$threshold;$i++){
                
                
                if(!isset($multiples[$mult])){//avoid duplicates
                    if($mult==0){
                        $mult = $int*$i;
                        continue;
                    }
                    \Core\Log::info($mult);
                    
                    $sum += $mult;
                    $multiples[$mult] = $mult;
                    
                }else{
                    \Core\Log::info("$mult (repeated)");
                }
                
                $mult = $int*$i;
            }
        }
        \Core\Log::info("Result: $sum\n");
        return $sum;
    }
    
    
    
    public static function large_multiples_sum($threshold, $ints = array(), $sum=0){
        static $_start_from_i;
        \Core\Log::info("Start searching for numbers multiples sum.");
        
        if(!is_array($_start_from_i)){
            foreach($ints as $k => $v) $_start_from_i[$k]=1;
        }
        
        
        $multiples = array();
        
        //Search fora common multiplier to use as recursion step to avoid a memory crash
        $common_multiple = 1;
        foreach($ints as $k => $int){
                $common_multiple = $common_multiple * $int;
        }
        $rec_limit = $common_multiple;
        while($rec_limit<100000){
            $rec_limit*=10;
        }
        \Core\Log::info("Recursion step amount $rec_limit");
        
        foreach($ints as $int_index => $int){
            \Core\Log::info("Multipes of $int");
            $mult=0;
            for($i=$_start_from_i[$int_index];$mult<$threshold;$i++){
                
                
                if(!isset($multiples[$mult])){//avoid duplicates
                    if($mult==0){
                        $mult = $int*$i;
                        continue;
                    }
                    \Core\Log::info($mult);
                    \Core\Log::progress("Adding multiple: {$mult} \t Current sum: {$sum}");
                    $sum += $mult;
                    $multiples[$mult] = $mult;
                    
                }else{
                    \Core\Log::info("$mult (repeated)");
                }
                
                $mult = $int*$i;
                
                //avoid reaching memory limit
                if($mult%$rec_limit==0){
                    
                    \Core\Log::info("$int_index - ".count($ints));
                    if($int_index==count($ints)-1){
                        
                        \Core\Log::info("Release unrequired memory.");
                        //clear memory
                        unset($multiples);
                        //save loop index for current number
                        $_start_from_i[$int_index]=$i;
                        
                        //start new range.
                        return self::large_multiples_sum($threshold, $ints, $sum);
                    }else{
                        
                        //save loop index for current number
                        \Core\Log::info("Continue to next number.");
                        $_start_from_i[$int_index]=$i;
                        continue 2;
                    }
                }
            }
        }
        \Core\Log::info("Result: $sum\n");
        return $sum;
    }
    
    
    
    function sumed_power($base, $exp){
        if(!is_int($base) || !is_int($exp) || $base<0 || $exp<0) throw new laddException('Both numbers must be natural numbers');
        
        
    }
}