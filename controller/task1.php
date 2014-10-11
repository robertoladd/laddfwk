<?

namespace Controller;

class Task1 extends \Core\Controller{
    
    public function multiplesOf3or5Below100($threshold, $int1, $int2){
        $this->display('', array(\Model\Task1::multiples_sum($threshold, array($int1, $int2))));
    }
    
    public function large_two_multiples_sum($threshold, $int1, $int2){
        $this->display('', array(\Model\Task1::large_multiples_sum($threshold, array($int1, $int2))));
    }
    
    public function list_multiples_sum($threshold, $int1csv){
        $ints = explode(',', $int1csv);
        $this->display('', array(\Model\Task1::large_multiples_sum($threshold, $ints)));
    }
    
    public function summed_power($base, $exp){
        $this->display('', array(\Model\Task1::summed_power($base, $exp)));
    }
}