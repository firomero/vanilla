<?php
class CalculatorService
{
    /**
     * @param $value
     * @return float|int
     */
    private function basePrice($value){
        $now = new DateTime('now');
        $format = $now->format('Y-m-d');
        $day = date('N', strtotime( $format));
        $time = date('H', strtotime( $format));
        $factor = 0.11;
        if ($day==5 && $time>15 && $time<20) {
            $factor = 0.13;
        }
        $calc = $factor * $value;
        return $calc;
    }

    /**
     * @param $value
     * @return float
     */
    private function getCommission($value){
        return 0.17 * $value;
    }

    /**
     * @param $tax
     * @param $value
     * @return float|int
     */
    private function getTax($tax, $value){
        return $tax * $value;
    }


    /**
     * @param array $data
     * @return array
     */
    public function getMatrixPrice($data){
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
            $result['rows']['base'] = $base;
            $result['rows']['commission'] = $commission;
            $result['rows']['tax'] = $tax;
            $result['rows']['total'] = $base + $commission + $tax;
            $result['totalCost']+=$base+$commission+$tax;
        }
        $result['totalCost'] = round($result['totalCost'],2);
        return $result;

    }

}