<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Shared\CustomResponseController;
use App\Models\Shared\CustomConstants;
use App\Http\Controllers\Shared\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BaseController extends Controller
{

    public $resp;
    public $const;
    public $helper;

    /**
     * PermissionController constructor.
     */
    public function __construct()
    {
        $this->resp = new CustomResponseController();
        $this->const = new CustomConstants();
        $this->helper = new Helper();
    }

    /**
     * Paginated data
     *
     * @param Request $request
     * @param $data
     * @param string $content
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginate(Request $request, $data, string $content = 'items'): \Illuminate\Http\JsonResponse
    {
        if ($request->has('page_size')) {
            if ($request->input('page')) {
                $data = $data->orderBy('created_at', 'ASC')->paginate($request->input('page_size'), ['*'], 'page', $request->input('page'));
            } else {
                $data = $data->orderBy('created_at', 'ASC')->paginate($request->input('page_size'));
            }
        } else {
            $data = $data->orderBy('created_at', 'ASC')->paginate(10);
        }
        if ($data) {
            $formattedData = ['last_page' => $data->lastPage(), 'total' => $data->total(), $content => $this->reformatRecords($data)];
            return $this->resp->response($this->const::RESPONSE_STATUS_SUCCESS, $this->const::RESPONSE_MESSAGE_SUCCESS, $formattedData);
        } else {
            return $this->resp->response($this->const::RESPONSE_STATUS_FAILED, $this->const::RESPONSE_MESSAGE_FAILED, []);
        }
    }

    /**
     * Reformat records
     *
     * @param $records
     * @return array
     */
    public function reformatRecords($records): array
    {
        $data = [];
        foreach ($records as $record) {
            $data[] = $record;
        }
        return $data;
    }

    /**
     * Search start date
     *
     * @param $date
     * @return string
     */
    public function searchStartDate($date): string
    {
        return (new Carbon(date('Y-m-d h:i:s', strtotime($date))))->startOfDay()->toDateTimeString();
    }

    /**
     * Search end date
     *
     * @param $date
     * @return string
     */
    public function searchEndDate($date): string
    {
        return (new Carbon(date('Y-m-d h:i:s', strtotime($date))))->endOfDay()->toDateTimeString();
    }

    /**
     * @param $countryCode
     * @param $phoneNumber
     * @param $length
     * @return string
     */
    public function preparePhoneNumber($countryCode, $phoneNumber, $length): string
    {
        return $countryCode . substr(trim($phoneNumber), -$length);
    }
}
