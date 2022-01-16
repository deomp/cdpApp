<?php

namespace App\Controller\Finance;

use App\Entity\Contributions;
use App\Services\GetParameters;
use App\Form\FinAddContributionType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContributionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/finance', name: 'finance_')]
class FinanceController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ContributionsRepository $ContributionsRepo): Response
    {
        $userID = $this->getUser()->getId();
        $contributions = $ContributionsRepo->getAllPendingContribs();
        $trackRevenue = $ContributionsRepo->trackRevenue('2022');
        $json_trackRevenue = json_encode($trackRevenue); 
        $trackRevenue = substr($json_trackRevenue, 8, -2);//[{"sum":"150"}]
        //dd($trackRevenue);
        $budget = (14*50)*12;
        $forecast = (14*50)*1;
        $tracker = (int)round(($trackRevenue/$budget)*100);
        $trackForecast = (int)round(($forecast/$budget)*100);
       // dd($tracker);
        //$gethand = $ContributionsRepo->takeHand($userID);
        
        return $this->render('finance/index.html.twig', [
            'pendingContribs' => $contributions,
            'trackRevenue' => $tracker,
            'budget'=>$budget,
            'revenue'=>$trackRevenue,
            'forecast'=>$forecast,
            'trackForecast'=>$trackForecast,
        ]);
    }

    #[Route('/addcontribution', name: 'add_contribution')]
    public function addContribution(Request $request, GetParameters $appInfo, EntityManagerInterface $entityManager, ContributionsRepository $ContributionsRepo): Response
    {
        $contribution = new Contributions();
        $form = $this->createForm(FinAddContributionType::class, $contribution);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $CONTRIB_MONTHLY = 50;
            $amount = (int)$form->get('amount')->getData();
            $paymentMode = $form->get('paymentmode')->getData();
            $nbreMonthPaid = (int)($amount/$CONTRIB_MONTHLY);
            $amountReste = ($amount%$CONTRIB_MONTHLY);
            $period = $form->get('period')->getData();
            $headers = [];
            if (strpos($period, ',') !== false) {
                $headers = explode(',', $period);
            }
            $period = $headers[0] ."-". $headers[1];
            $periodMonth = $headers[0];
            $periodYear = $headers[1];
            $onBehalfofUser = $form->get('users')->getData();
            $date = new \DateTime('@'.strtotime('now'));
            $createdYear = (string)date('Y');
            $createdMonth = (string)date('m');
            $createdby = $this->getUser()->getId();
            $number = rand(1, 90000);
            $tid = "CDP".(string)$number;
            $status = "2";
            $finType = "1";
            $uploadedFile = $form['proof']->getData();
            if ($uploadedFile)
            {
            $destination = $this->getParameter('proof_directory');
            $newFilename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($destination,$newFilename);
            }
           
        for($i=0; $i<$nbreMonthPaid; $i++){
            $contribution = new Contributions();
            $periodMonth += $i;
            
            $period = $periodMonth."-".$periodYear;
            $contribution->setUsers($onBehalfofUser);
            $contribution->setPeriod($period);
            $contribution->setAmount($CONTRIB_MONTHLY);
            $contribution->setCreatedby($createdby);
            $contribution->setCreatedAt($date);
            $contribution->setValidatedAt($date);
            $contribution->setValidatedby($createdby);
            $contribution->setCreatedmonth($createdMonth);
            $contribution->setCreatedyear($createdYear);
            $contribution->setStatus($status);
            $contribution->setTid($tid);
            $contribution->setProof($newFilename);
            $contribution->setCatfinance($finType);
            $contribution->setPaymentMode($paymentMode);
            $contribution->setPaidforhowmanymonth($nbreMonthPaid);

            $entityManager->persist($contribution);
            $entityManager->flush();
            
        }   
        $this->addFlash('message','La contribution a été enregistrée avec succès.');
                return $this->redirectToRoute('finance_index');
    }     
        return $this->render('finance/addContrib.html.twig', [
            'contribForm' => $form->createView(),
            'getAppInfo'=> $appInfo->getInfo(),
        ]);
    }

    #[Route('/report', name: 'report')]
    public function getReport(ContributionsRepository $ContributionsRepo, GetParameters $reportInfo): Response
    {
        //$contributions = $ContributionsRepo->getAllPendingContribs();
        //$contributions = $ContributionsRepo->findAll();
        //getReportDetails
        return $this->render('finance/getReport.html.twig', [
            'getReportInfo'=> $reportInfo->getReportDetails(),

        ]);
    }

#[Route('/hand/{user_id}', name: 'hand')]
public function updateStatus($user_id, ContributionsRepository $ContributionsRepo): Response
{
    $gethand =  $ContributionsRepo->takeHand($user_id);

    return $this->redirect ('/finance');
}

#[Route('/validate/{user_id}', name: 'validate')]
public function ValidateContrib($user_id, Request $request, ContributionsRepository $ContributionsRepo): Response
{
    $validatorID = $this->getUser()->getId();
    $validatedAt = new \DateTime('@'.strtotime('now'));
    $myAction = $request->get('RadioValidation');
    if($myAction == 'on'){$myAction =  $ContributionsRepo->validateContrib($user_id, $validatedAt, $validatorID);}
    else{$myAction =  $ContributionsRepo->rejectContrib($user_id, $validatedAt, $validatorID);}

  //dd($myAction);
   return $this->redirect ('/finance');
}

#[Route('/bplaning', name: 'bplanning')]
public function budgetPlanning(ContributionsRepository $ContributionsRepo): Response
{
    return $this->render('finance/budgetPlanning.html.twig', [
        //'pendingContribs' => $contributions,
        
    ]);
}


    
}
