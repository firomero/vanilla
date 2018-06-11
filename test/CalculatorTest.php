<?php

class CalculatorTest extends \PHPUnit\Framework\TestCase
{
    private function getCommission($value){
        return 0.17 * $value;
    }

    private function getTax($tax, $value){
        return $tax * $value;
    }

    private function basePrice($value){
        $now = new DateTime('now');
        $format = $now->format('Y-m-d');
        $day = date('N', strtotime( $format));
        $time = date('H', strtotime( $now->format('H')));
        $factor = 0.11;
        if ($day==5 && $time>15 && $time<20) {
            $factor = 0.13;
        }
        $calc = $factor * $value;
        return $calc;
    }

    public function testCalc() {
        $data = array(
            'value' => 10000,
            'instalment'=>2,
            'tax'=>0.1
        );
        $result = array(
            'value'=>$data['value'],
            'rows'=>array(),
            'totalCost'=> 0
        );
        $instalment = intval($data['instalment']);
        for ($i=0;$i<$instalment;$i++){
            $base = $this->basePrice(floatval($data['value'])/$instalment);
            $commission = $this->getCommission($base);
            $tax = $this->getTax($data['tax'],$base);
            $result['rows'][] = array(
                'base'=> $base,
                'commission'=>$commission,
                'tax'=>$tax,
                'total'=>$base + $commission + $tax
            );
            $result['totalCost']+=$base+$commission+$tax;
        }
        $result['totalCost'] = round($result['totalCost'],2);
        $this->assertEquals(1397.00,$result['totalCost']);
    }



}