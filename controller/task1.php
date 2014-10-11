<?

namespace Controller;

class Task1 extends \Core\Controller{
    
    public function multiples_of_3_or_5_below_100(){
        $this->display('', array(\Model\Task1::multiplesSum(100, array(3,5))));
    }
    
    public function large_two_multiples_sum($threshold, $int1, $int2){
        $this->display('', array(\Model\Task1::largeMultiplesSum($threshold, array((int) $int1,(int)  $int2))));
    }
    
    public function list_multiples_sum($threshold, $int1csv){
        $ints = explode(',', $int1csv);
        $this->display('', array(\Model\Task1::largeMultiplesSum($threshold, $ints)));
    }
    
    public function power_a($base, $exp){
        $this->display('', array(\Model\Task1::powerA((int) $base,(int)  $exp)));
    }
    
    public function power_b($base, $exp){
        $this->display('', array(\Model\Task1::powerB((int) $base,(int)  $exp)));
    }
    
    public function fibonacci_rec10(){
        $this->display('', array(implode(',', \Model\Task1::fibonacciRec(10))));
    }
    
    public function fibonacci_rec($max){
        $this->display('', array(implode(',', \Model\Task1::fibonacciRec((int) $max))));
    }
    
    public function fibonacci($max){
        $this->display('', array(implode(',', \Model\Task1::fibonacci((int) $max))));
    }
}