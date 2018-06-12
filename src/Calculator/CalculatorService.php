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
            'totalCost'=> 0,
            'instalment'=>$data['instalment']
        );
        $instalment = intval($data['instalment']);
        for ($i=0;$i<$instalment;$i++){
            $base = $this->basePrice($data['value']/$instalment);
            $commission = $this->getCommission($base);
            $tax = $this->getTax($data['tax'],$base);
            $result['rows'][]=array(
                'base'=>round($base,2),
                'commission'=>round($commission,2),
                'tax'=>round($tax,2),
                'total'=>round($base + $commission + $tax,2)
            );

            $result['totalCost']+=round($base+$commission+$tax,2);
        }
        $result['totalCost'] = round($result['totalCost'],2);
        return $result;

    }

}