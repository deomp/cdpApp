<?php 
namespace App\Services;
use App\Repository\ContributionsRepository;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetParameters {
    private $security;
    private $myContribs;

    public function __construct(Security $security, ContributionsRepository $ContributionsRepo)
    {
        $this->security = $security;
        $this->ContributionsRepo = $ContributionsRepo;
       
    }

    public function getInfo(){
        $user = $this->security->getUser();
        $userId = $user->getId();
        
        //$MonthPaid = $this->ContributionsRepo->countContribs($userId);
        $countValidatedContrib = $this->ContributionsRepo->countContribs($userId);
        // Use json_encode() function 
       $json_countValidatedContrib = json_encode($countValidatedContrib); 
       $countValidatedContrib = $json_countValidatedContrib[10];

       $getMonthPaidValidatedContribs = $this->ContributionsRepo->getValidatedPaidMonth($userId);
       $json_getMonthPaidValidatedContribs = json_encode($getMonthPaidValidatedContribs); 
       $getMonthPaidValidatedContribs = substr($json_getMonthPaidValidatedContribs,8, -2);//"[{"sum":0}]"

       $dateAdhesion = $user->getCreatedAt();
       $dateAdhesion = $dateAdhesion->format('d-m-Y');

       $sumValidatedContrib = $this->ContributionsRepo->getValidatedContribs($userId);
            $json_sumValidatedContrib = json_encode($sumValidatedContrib); 
            $sumValidatedContrib = substr($json_sumValidatedContrib, 8, -2);//[{"sum":"150"}]
            

        //dd($getMonthPaidValidatedContribs);
       
 
       $sumPendingContrib = $this->ContributionsRepo->getPendingContribs($userId);
       $json_sumPendingContrib = json_encode($sumPendingContrib); 
       $sumPendingContrib = substr($json_sumPendingContrib, 8, -2);//[{"sum":"150"}]
       
         // dd($sumPendingContrib);
        
       
        
        //[CDP_START_YEAR, CONTRIB_AMOUNT, MEMBER_ADHESON_YEAR]
        //$myInfo = array('2018','50', $adhyear);
        $myInfo = array();
        $YEAROFMONTH = 12;
        $cdpStartYear = '2018';
        $cdpStartMonth = '9';
        $cdpMonthlyContrib = '50';
        $currentYear = (string)date('Y');
        //$currentMonth = (string)date('m');
        
        $adhesionYear = substr($dateAdhesion, -4);
        $adhesionMonth= substr($dateAdhesion, 3, -5);//05-11-2021
       
        $todayDate = (string)date('d');
        
         
        if($todayDate >= 25){
            $currentMonth = (string)date('m');
            $messageCaisse = "La caisse pour le mois " . $currentMonth . " est ouverte.";
            $contributionDueMonth = (($currentYear - $adhesionYear) * $YEAROFMONTH)- $adhesionMonth + $currentMonth;
        }
        else{
            $currentMonth = (string)((int)date('m') - 1);
            $contributionDueMonth = (($currentYear - $adhesionYear) * $YEAROFMONTH)- $adhesionMonth + $currentMonth;
        }
       
        //$MonthPaid = $contributionDueMonth - $RetardContrib;
        $MonthPaid = $countValidatedContrib;
        //$MonthPaid = $getMonthPaidValidatedContribs;
        $RetardContrib = $contributionDueMonth - $MonthPaid;
        $rap = $RetardContrib * $cdpMonthlyContrib;
        //dd($rap);

        if($MonthPaid < $YEAROFMONTH){
            //$startMoisRetard = $MonthPaid - ($YEAROFMONTH - $adhesionMonth);
            $startMoisRetard = ($adhesionMonth + $MonthPaid);
            $startYearRetard = $adhesionYear;
        }
        elseif($MonthPaid >= $YEAROFMONTH && $MonthPaid <= $YEAROFMONTH * 2 ){
            $startMoisRetard = (($YEAROFMONTH * 2) - $RetardContrib);
            $startYearRetard = $adhesionYear + 2;
        }
        elseif($MonthPaid >= $YEAROFMONTH * 2 && $MonthPaid <= $YEAROFMONTH * 3 ){
            $startMoisRetard = (($YEAROFMONTH * 3) - $RetardContrib);
            $startYearRetard = $adhesionYear + 3;
        }
        elseif($MonthPaid >= $YEAROFMONTH * 2 && $MonthPaid <= $YEAROFMONTH * 4 ){
            $startMoisRetard = (($YEAROFMONTH * 4) - $RetardContrib);
            $startYearRetard = $adhesionYear + 4;
        }
              
        if($currentMonth == '0') 
           {$currentYear = $currentYear - 1;}
        //$lastmonthOfContrib = 
        //$lastYearOfContrib =

        array_push($myInfo, $contributionDueMonth, $RetardContrib, $startMoisRetard, $startYearRetard, $currentMonth, $currentYear, $sumValidatedContrib, $sumPendingContrib,$rap, $MonthPaid);
        if ($myInfo[6] == 'null'){
            $myInfo[6]= '0';
            unset($myInfo[6]);
            $myInfo = array_slice($myInfo, 0, 6, true) +
                array("6" => "0") +
                array_slice($myInfo, 6, count($myInfo) - 1, true) ;
            //dd($myInfo);
        }

        elseif ($myInfo[7] == 'null'){
            $myInfo[7]= '0';
            unset($myInfo[7]);
            $myInfo = array_slice($myInfo, 0, 7, true) +
                array("7" => "0") +
                array_slice($myInfo, 7, count($myInfo) - 1, true) ;
            //dd($myInfo);
        }
        
        return $myInfo ;
    }

    public function getReportDetails(){
        $reportDetails = array();
        $sumValidatedofMonth = $this->ContributionsRepo->getValidatedofMonth();
        $json_sumValidatedofMonth = json_encode($sumValidatedofMonth); 
       
        if(str_contains($json_sumValidatedofMonth,'null')){
            $sumValidatedofMonth = 0;
        }
        else{
            $sumValidatedofMonth = substr($json_sumValidatedofMonth, 8, -2);//[{"sum":"150"}]
        }

        //Check MTD
        $sumValidatedofYear = $this->ContributionsRepo->getValidatedofYear();
        $json_sumValidatedofYear = json_encode($sumValidatedofYear); 
        if(str_contains($json_sumValidatedofYear,'null')){
            $sumValidatedofYear = 0;
        }
        else{
            $sumValidatedofYear = substr($json_sumValidatedofYear, 8, -2);//[{"sum":"150"}]
        }

        array_push($reportDetails, $sumValidatedofMonth, $sumValidatedofYear);

        return $reportDetails ;
    }

}