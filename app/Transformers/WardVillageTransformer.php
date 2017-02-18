<?php
/**
 * Ward Village Transformer
 * 
 * @package App\Transformers
 * @author Li Jia Li <limonster.li@gmail.com>
 */

namespace App\Transformers;

use App\Transformers\Contracts\TransformerInterface;
use League\Fractal\TransformerAbstract;

class WardVillageTransformer extends TransformerAbstract implements TransformerInterface
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
            'am_constituency'         => $data->am_constituency,
            'st_constituency_number'  => $data->st_constituency_number,
            'st_constituency'         => $data->st_constituency,
            'ward_village_number'     => $data->ward_village_number,
            'ward_village'            => $data->ward_village,
            'am_constituency_number'  => $data->am_constituency_number,
            'st_constituency_pcode'   => $data->st_constituency_pcode
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