
usage: cli.php [--verbose] task1 <method> [<args>]

Available controllers methods: 
    multiples_of_3_or_5_below_100                           returns the sum of all multiples of three or four below 100
    large_two_multiples_sum <threshold> <numx> <numy>       returns the sum of all multiples of numx or numy below threshold
    list_multiples_sum  <threshold> <numx>[,<numy>...]      returns the sum of all unique multiples of all the coma separated numbers below threshold
    power_a  <base> <exp>                                   returns the power of base at index exp using PHP's built in function.
    power_b  <base> <exp>                                   returns the power of base at index exp using a custom sum function.
    fibonacci_rec10                                         returns all the numbers of the fibonacci sequence below 10. With recursion.
    fibonacci_rec <threshold>                               returns all the numbers of the fibonacci sequence below threshold. With recursion.
    fibonacci <threshold>                                   returns all the numbers of the fibonacci sequence below threshold. Without recursion.


See cli.php help <controller> [<method>] for more information on a specific controller and it's methods.
