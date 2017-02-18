<?php
/**
 * Township Transformer
 * 
 * @package App\Transformers
 * @author Li Jia Li <limonster.li@gmail.com>
 */

namespace App\Transformers;

use App\Transformers\Contracts\TransformerInterface;
use League\Fractal\TransformerAbstract;

class TownshipTransformer extends TransformerAbstract implements TransformerInterface
{

    protected $fields = [];

    public function __construct($fields = [])
    {
        $this->fields = $fields;
    }

    public function transform($data)
    {
        if ( ! empty($this->fields)) {
            return $this->transformFieldOnly($this->fields, $data);
        }

        return [
           //'id'                     => (string)$data->_id,
           'township_pcode_idx'     => $data->township_pcode_idx,
           'township_pcode'         => $data->township_pcode,
           'name_en'                => $data->name_en,
           'name_mm'                => $data->name_mm,
           'region_pcode_idx'       => $data->region_pcode_idx,
           'region_pcode'           => $data->region_pcode,
           'am_constituency_number' => $data->am_constituency_number,
           'am_constituency'        => $data->am_constituency
        ];
    }

    protected function transformFieldOnly($fields, $data)
    {
        $result = [];

        foreach ($fields as $f) {            
            $result[$f] = $data->{$f};
        }

        return $result;
    }

}