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
use App\Model\Township;
use App\Transformers\TownshipTransformer;

class TownshipController extends Controller
{

    /**
     * Get township list
     * @return \Symfony\Component\HttpFoundation\Response
     * 
     */
    public function getList()
    {
        $fields = $this->getRequestFields(app('request'));

        $data = $this->transform($this->query($fields), new TownshipTransformer($fields), true);

        return response_ok($data);
    }

    /**
     * Get Township by Pcode
     *
     * @return \Symfony\Component\HttpFoundation\Response
     **/
    public function getByPcode($pcode)
    {
        $data = (new Township())->getBy('township_pcode', $pcode);

        if (!$data) {
            return response_missing();
        }

        $item = $this->transform($data, new TownshipTransformer($this->getRequestFields(app('request'))), false);

        return response_ok($item);
    }

    protected function query($fields = [])
    {
        $request = app('request');

        $model = new Township();

        //Query
        if ($region_pcode = $request->input('region_pcode')) {
            $model = $model->where('region_pcode', $region_pcode);
        }

        if ($am_constituency = $request->input('am_constituency')) {
            $model = $model->where('am_constituency', $am_constituency);
        }

        if ($am_constituency_number = $request->input('am_constituency_number')) {
            $model = $model->where('am_constituency_number', $am_constituency_number);
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