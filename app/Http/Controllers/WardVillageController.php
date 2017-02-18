<?php
/**
 * Ward Village Controller
 * 
 * @package App\Http\Controllers
 * @author Li Jia Li [limonster.li@gmail.com]
 */

namespace App\Http\Controllers;

use MongoDate;
use Carbon\Carbon;
use App\Model\WardVillage;
use App\Transformers\WardVillageTransformer;

class WardVillageController extends Controller
{

    /**
     * Get township list
     * @return \Symfony\Component\HttpFoundation\Response
     * 
     */
    public function getList()
    {
        $fields = $this->getRequestFields(app('request'));

        $data = $this->transform($this->query($fields), new WardVillageTransformer($fields), true);

        return response_ok($data);
    }

    /**
     * Get Township by ID
     *
     * @return \Symfony\Component\HttpFoundation\Response
     **/
    public function getByID($id)
    {
        $data = (new WardVillage())->find($id);

        if (!$data) {
            return response_missing();
        }

        $item = $this->transform($data, new WardVillageTransformer($this->getRequestFields(app('request'))), false);

        return response_ok($item);
    }

    protected function query($fields = [])
    {
        $request = app('request');

        $model = new WardVillage();

        if ($ts_pcode = $request->input('ts_pcode')) {
            $model = $model->where('st_constituency_pcode', $ts_pcode);
        }

        if ($am_constituency = $request->input('am_constituency')) {
            $model = $model->where('am_constituency', $am_constituency);
        }

        if ($am_constituency_number = $request->input('am_constituency_number')) {
            $model = $model->where('am_constituency_number', $am_constituency_number);
        }

        if ($st_constituency = $request->input('st_constituency')) {
            $model = $model->where('st_constituency', $st_constituency);
        }

        if ($st_constituency_number = $request->input('st_constituency_number')) {
            $model = $model->where('st_constituency_number', $st_constituency_number);
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