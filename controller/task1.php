<?

//    Copyright (C) 2014  Roberto Ladd
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.


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