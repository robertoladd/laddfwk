<?
namespace Model;

class Task1 extends \Core\Model{
    
    protected static $_disable_persistance=true;
    
    public static function multiplesSum($threshold, $ints = array()){
        
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
    
    
    
    public static function largeMultiplesSum($threshold, $ints = array(), $sum=0){
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
    
    
    
    static function powerA($base, $exp){
        \Core\Log::info("Called Power A with parameters: $base, $exp");
        if(!is_int($base) || !is_int($exp) || $base<0 || $exp<0) throw new \Core\laddException('Both numbers must be natural numbers');
        
        //this is the simplest way. :)
        return pow($base, $exp);
    }
    
    static function powerB($base, $exp){
        if(!is_int($base) || !is_int($exp) || $base<0 || $exp<0) throw new \Core\laddException('Both numbers must be natural numbers');
        $pow = $base;
        for($i=1;$i<$exp;$i++){
            \Core\log::info("Processing exp loop {$i}");
            $pow = self::manualMultiplication($pow, $base);
            \Core\log::info("Current power {$pow}");
        }
        return $pow;
    }
    
    static function manualMultiplication($x, $y){
        if(!is_numeric($x) || !is_numeric($y)) throw new \Core\laddException('Both parameters must be numbers');
        $sum = 0;
        for($i=1;$i<=$y;$i++){
            \Core\log::info("Adding {$x} to {$sum}");
            $sum += $x;
        }
        return $sum;
    }
    
    static function fibonacciRec($max, $f_nums=array(1), $curr=1){
        if(!is_int($max)) throw new \Core\laddException('Maximum limit must be an integer');
        \Core\log::info("Current num {$curr}");
        
        if($curr>=$max) return $f_nums;
        
        //sum previous number with the current one
        $next= (max($f_nums) + $curr);
        
        //add current number to sequence
        $f_nums[]=$curr;
        
        \Core\log::info("Next num {$next}");
        $f_nums = self::fibonacciRec($max, $f_nums, $next);
        
        return $f_nums;
    }
    
    static function fibonacci($max){
        if(!is_int($max)) throw new \Core\laddException('Maximum limit must be an integer');
        $f_nums=array();
        $j = 1;
        for($i=1;$i<$max;$i=$i+max($f_nums) ){
            
            \Core\log::info("Current num {$i}");
            \Core\log::info("Prev num ".$j);
            $f_nums[]=$j;
            $j = $i;
        }
        return $f_nums;
    }
}