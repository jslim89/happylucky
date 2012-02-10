<?php
/**
 * Due the multiple batching, this function is required to 
 * calculate the cost for this particular product in this
 * particular time.
 * i.e.
 * Batch   Stock-In   Unit-Cost 
 * -----   --------   ---------
 *   1         5       300.00
 *   2         6       350.00
 *   3         3       450.00
 *
 * Order-ID   Sold
 * --------   ----
 *   #001       3
 *   #002       6
 *   #003       4
 *
 * The cost for #003 (Assume that current order is #003) is
 *     (5+6)-(3+6) * 350.00
 * + 4-((5+6)-(3+6)) * 450.00
 *   ------------------------
 *        800.00
 * 
 * @param mixed $qty 
 * @return double
 */

class Product_Cost_Calculator {

    /**
     * init 
     * 
     * @param mixed $product_id 
     * @return void
     */
    public function init($product_id, $qty) {
        $this->_get_ci()->load->model('product_model');
        $this->product = new Product_Model($product_id);
        $this->qty = $qty;
    }

    /**
     * Return the total cost for current order product 
     * 
     * @return double
     */
    public function get_current_total_cost() {
        $start_batch = $this->_get_starting_batch_id();
        $end_batch   = $this->_get_ending_batch_id();

        $total_cost = 0;
        $qty_left   = $this->qty;
        foreach($this->product->product_batch as $batch) {
            if($batch->id >= $start_batch && $batch->id <= $end_batch) {
                if($batch->id == $start_batch) {
                    $current_batch_availability = ($this->_qty_until_batch($batch->id) - $this->product->total_num_sold);
                }
                else {
                    $current_batch_availability = $batch->quantity_stock_in;
                }
                $qty_to_be_deduct = ($qty_left < $current_batch_availability)
                            ? $qty_left : $current_batch_availability;
                $total_cost += $batch->unit_cost * $qty_to_be_deduct;
                $qty_left -= $qty_to_be_deduct;

                if($qty_left == 0) break;
            }
        }
        return $total_cost;
    }

    /**
     * Refer to example above, this function will 
     * return the batch no. #2, since #1 already sold
     * out while #2 left 2 quantity which is still
     * sufficient
     * 
     * @return mixed
     */
    private function _get_starting_batch_id() {
        $total_batch_qty = 0;
        foreach($this->product->product_batch as $batch) {
            $total_batch_qty += $batch->quantity_stock_in;
            if($total_batch_qty > $this->product->total_num_sold) return $batch->id;
        }
        return false;
    }

    /**
     * Refer to example above, this function will 
     * return the batch no. #3, since #2 still got
     * 2 quantity left, 4 - 2 = 2, #3 got 3 quantity
     * available, 3 > 2 thus #3 is sufficient
     * 
     * @return mixed
     */
    private function _get_ending_batch_id() {
        $total_batch_qty    = 0;
        $estimated_num_sold = $this->product->total_num_sold + $this->qty;
        foreach($this->product->product_batch as $batch) {
            $total_batch_qty += $batch->quantity_stock_in;
            if($total_batch_qty > $estimated_num_sold) return $batch->id;
        }
        return false;
    }

    /**
     * Get the quantity from beginning until nth batch 
     * 
     * @param mixed $batch_id 
     * @return int
     */
    private function _qty_until_batch($batch_id) {
        $total_batch_qty = 0;
        foreach($this->product->product_batch as $batch) {
            if($batch->id <= $batch_id) $total_batch_qty += $batch->quantity_stock_in;
        }
        return $total_batch_qty;
    }

    private function _get_ci() {
        $ci =& get_instance();
        return $ci;
    }
}
