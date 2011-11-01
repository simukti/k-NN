<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Simukti\Knn;

use \SplMinHeap as MinHeap,
    \RuntimeException as Error;

require_once (__DIR__ . DIRECTORY_SEPARATOR . 'Distance.php');

/**
 * Description of Knn
 *
 * @author simukti <me@simukti.net>
 */
class Knn
{
    /**
     * Data yang digunakan untuk acuan
     * 
     * @var array
     */
    protected $_data;
    
    /**
     * Nilai yang akan dites
     * 
     * @var array
     */
    protected $_values;
    
    /**
     * Hasil pengurutan data berdasar jarak euclidean (SplMinHeap)
     * 
     * @var array
     */
    protected $_result = array();
    
    /**
     * Set data acuan
     * 
     * @param array $data
     * @example <pre> 
     *      array(array(4, 53, 1), array(5, 63, 1));
     * </pre>
     */
    public function setData(array $data)
    {
        $this->_data = $data;
    }
    
    /**
     * Ambil data yang sudah diset
     * 
     * @return array
     */
    public function getData()
    {
        if (null !== $this->_data) {
            return $this->_data;
        }
    }
    
    /**
     * Set nilai yang akan di-tes
     * 
     * @param array $values 
     * @example <pre> 
     *      array(45, 76);
     * </pre>
     */
    public function setValues(array $values)
    {
        $this->_values = $values;
    }
    
    /**
     * Ambil nilai yang akan dites
     * 
     * @return array
     */
    public function getValues()
    {
        if (null !== $this->_values) {
            return $this->_values;
        }
    }
    
    /**
     * Eksekusi k-NN
     * 
     * @param int $k Jumlah k yang diambil
     * @return array Penentuan hasilnya dapat diproses lebih mudah bila baris terakhir dalam tiap
     *                array $this->setData() adalah identifier grup dari data tersebut. 
     *                Misal: array(5, 64, 1), maka identifier grup datanya adalah 1.
     * @todo Hasilnya langsung grup data di modus $k ya, seperti fungsi MODE di Excel
     */
    public function exec($k)
    {
        if (null === $this->_data || null === $this->_values) {
            throw new Error('Data acuan dan nilai yang akan dites belum di-set');
        }
        
        $distance = Distance::euclidean($this->getValues(), $this->getData());
        $minHeap  = new MinHeap;
        
        foreach ($distance as $result) {
            $minHeap->insert(array_values($result));
        }
        
        foreach($minHeap as $value) {
            // gak butuh nampilin nilai euclidean lagi? uncomment baris berikut
            // $distance = array_shift($value);
            $this->_result[] = $value;
        }
        
        return array_slice($this->_result, 0, $k);
    }
}
?>
