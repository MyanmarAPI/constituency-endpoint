<?php
/**
 * Region Controller
 * 
 * @package App\Http\Controllers
 * @author Li Jia Li [limonster.li@gmail.com]
 */

namespace App\Http\Controllers;

use MongoDate;
use Carbon\Carbon;
use App\Model\Region;
use App\Transformers\RegionTransformer;

class RegionController extends Controller
{

    /**
     * Get candidate list
     * @return \Symfony\Component\HttpFoundation\Response
     * 
     */
    public function getList()
    {
        $fields = $this->getRequestFields(app('request'));

        $data = $this->transform($this->query($fields), new RegionTransformer($fields), true);

        return response_ok($data);
    }

    /**
     * Get Polling Station by ID
     *
     * @return \Symfony\Component\HttpFoundation\Response
     **/
    public function getByPcode($pcode)
    {
        $data = (new Region())->getBy('region_pcode', $pcode);

        if (!$data) {
            return response_missing();
        }

        $item = $this->transform($data, new RegionTransformer($this->getRequestFields(app('request'))), false);

        return response_ok($item);
    }

    protected function query($fields = [])
    {
        $request = app('request');

        $model = new Region();

        if ($type = $request->input('type')) {
            $model = $model->where('type', $type);
        }

        return $model->paginate($fields);
    }

    /**
     * Get response fields lists from request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    protected function getRequestFields($request)
    {
        if ( ! $request->has('fields')) {
            return [];
        }

        return explode(',', $request->input('fields'));
    }
}