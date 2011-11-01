<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Simukti\Knn;

use \InvalidArgumentException as ErrorInput;

/**
 * Description of Distance
 *
 * @author simukti <me@simukti.net>
 */
class Distance
{
    /**
     * Hitung jarak data via metode euclidean
     * 
     * @param array $values Variabel acuan untuk menghitung jarak data.
     * @param array $data   Data yang akan dihitung jaraknya.
     * @param boolean $lastDataAsGroup Apakah baris terakhir dalam $data adalah identifier?
     * @return array Data yang sudah ditambahi hasil jarak antar data.
     * @example <pre> Input: 
     *   $values = array(45, 76);
     *   $data   = array(array(4, 53, 1), array(5, 63, 1));
     * 
     *   $result = array(array(_hasil_euclidean, 4, 53, 1));
     * </pre>
     */
    public static function euclidean(array $values, array $data, $lastDataAsGroup = true)
    {
        foreach ($data as $key => $chunk) {
            if ($lastDataAsGroup) {
                if (count($values) > (count($chunk) - 1)) {
                    throw new ErrorInput(sprintf("Jumlah baris data harus sama. 
                        Dan diasumsikan baris terakhir dalam data adalah identifier grup.")
                    );
                };
            }
            
            $chunk_sum = 0;
            
            for ($i = 0; $i < count($values); ++$i) {
                // http://en.wikipedia.org/wiki/Euclidean_distance
                $chunk_sum = $chunk_sum + (pow(($chunk[$i] - $values[$i]), 2));
            }
            
            // saya unshift nilai jaraknya,
            // agar bisa langsung dikonsumsi oleh SplMinHeap()
            array_unshift($data[$key], sqrt($chunk_sum));
        }
        
        return $data;
    }
}

?>
