<?php

namespace AmirAnisheh\GregorianJalali;

class JalaliConverter
{
    // Convert Gregorian date to Jalali
    public static function toJalali($gy, $gm, $gd)
    {
        $g_d_m = [0,31,59,90,120,151,181,212,243,273,304,334];
        if($gy > 1600){
            $jy = 979;
            $gy -= 1600;
        } else {
            $jy = 0;
            $gy -= 621;
        }
        $gy2 = ($gm > 2) ? $gy + 1 : $gy;
        $days = 365*$gy + intval(($gy2+3)/4) - intval(($gy2+99)/100) + intval(($gy2+399)/400) - 80 + $gd + $g_d_m[$gm-1];
        $jy += 33*intval($days/12053); 
        $days %= 12053;
        $jy += 4*intval($days/1461);
        $days %= 1461;
        if($days > 365){
            $jy += intval(($days-1)/365);
            $days = ($days-1)%365;
        }
        $jm = ($days < 186) ? 1 + intval($days/31) : 7 + intval(($days-186)/30);
        $jd = 1 + (($days < 186) ? ($days % 31) : (($days-186) % 30));
        return sprintf("%04d/%02d/%02d", $jy, $jm, $jd);
    }

    // Convert Jalali date to Gregorian
    public static function toGregorian($jy, $jm, $jd)
    {
        $jy += 1595;
        $days = -355668 + (365*$jy) + intval($jy/33)*8 + intval((($jy%33)+3)/4) + $jd;
        $days += ($jm < 7) ? ($jm-1)*31 : (($jm-7)*30 + 186);
        $gy = 400*intval($days/146097);
        $days %= 146097;
        if($days > 36524){
            $gy += 100*intval(--$days/36524);
            $days %= 36524;
            if($days >= 365) $days++;
        }
        $gy += 4*intval($days/1461);
        $days %= 1461;
        if($days > 365){
            $gy += intval(($days-1)/365);
            $days = ($days-1)%365;
        }
        $gd = $days + 1;
        $leap = (($gy%4==0 && $gy%100!=0) || ($gy%400==0)) ? 1 : 0;
        $months = [0,31,($leap?29:28),31,30,31,30,31,31,30,31,30,31];
        for($gm=1;$gm<=12;$gm++){
            if($gd <= $months[$gm]) break;
            $gd -= $months[$gm];
        }
        return sprintf("%04d-%02d-%02d", $gy, $gm, $gd);
    }
}
