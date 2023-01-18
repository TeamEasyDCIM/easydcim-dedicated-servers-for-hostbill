<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use Carbon\Carbon;

class InvoicingDate
{
    /*
     * Check is start date is bigger than reg date
     *
     * @param object $service insteandof Hostings
     *
     * @return date
     */

    public static function checkAndGetDate($hosting)
    {
        $service   = $hosting;
        $startDate = self::getStartDate($service);
        if ($startDate < $service->regdate)
        {
            return $service->regdate;
        }
        return $startDate;
    }

//    /*
//     * Get service details
//     *
//     * @param integer $serviceID
//     *
//     * @return object insteandof Hostings
//     */
//
//    private static function getService($serviceID)
//    {
//        return Hosting::where('id', $serviceID)->first();
//    }

    /*
     * Get date range
     *
     * @param object $service insteandof Hosting
     *
     * @return date
     */

    private static function getStartDate($service)
    {
        switch ($service->billingcycle)
        {
            case 'Monthly':
                $startDate = Carbon::createFromFormat('Y-m-d', $service->nextduedate)->subMonth()->toDateString();
                break;
            case 'Quarterly':
                $startDate = Carbon::createFromFormat('Y-m-d', $service->nextduedate)->subMonth(3)->toDateString();
                break;
            case 'Semi-Annually':
                $startDate = Carbon::createFromFormat('Y-m-d', $service->nextduedate)->subMonth(6)->toDateString();
                break;
            case 'Annually':
                $startDate = Carbon::createFromFormat('Y-m-d', $service->nextduedate)->subYear()->toDateString();
                break;
            case 'Biennially':
                $startDate = Carbon::createFromFormat('Y-m-d', $service->nextduedate)->subYear(2)->toDateString();
                break;
            case 'Triennially':
                $startDate = Carbon::createFromFormat('Y-m-d', $service->nextduedate)->subYear(3)->toDateString();
                break;
            default:
                $startDate = $service->nextduedate;
                break;
        }
        return $startDate;
    }

    /*
     * Get correct start Date
     *
     * @param date $date
     * @return date
     */

    public static function getCalculateDate($date)
    {
        $dateexplode  = explode("-", $date);
        $currentyear  = date("Y");
        $currentmonth = date("m");
        $newdate      = $currentyear . "-" . $currentmonth . "-" . $dateexplode[2];
        $dateDiff     = time() - strtotime("+1 hour", strtotime($newdate));
        $fullDays     = floor($dateDiff / ( 60 * 60 * 24 ));

        if ($fullDays < 0)
        {
            return date("Y-m-d", strtotime("-1 month", strtotime($newdate)));
        }
        return $newdate;
    }

    public static function getFirstDay()
    {
        return date("Y-m"). "-01";
    }
}