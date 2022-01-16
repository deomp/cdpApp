<?php

namespace App\Controller\Profil;

use App\Entity\Contributions;
use App\Entity\Users;
use App\Form\ContributionsType;
use App\Form\AddAvatarType;
use App\Services\GetParameters;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContributionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Length;

#[Route('/profil', name: 'profil_')]
class UsersController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function getUserProfil(Request $request, ContributionsRepository $ContributionsRepo,  GetParameters $appInfo): Response
    {       
         $user = $this->getUser();
         $userId = $this->getUser()->getId();
         $getmyContribs = $ContributionsRepo->findBy(['Users'=>$userId]);
         $contribbyStatus = $ContributionsRepo->findBy(['status'=>'1', 'status'=>'0']);
    
        return $this->render('profil/users/getprofile.html.twig', array(
            //'myContrib' => $ContributionsRepo->countContribs($user), 
            'getmyContribs' => $getmyContribs,
            'getAppInfo'=> $appInfo->getInfo(),    
        ));
    }

    #[Route('/contribute', name: 'contribute')]
    public function AddContribution(Request $request, EntityManagerInterface $entityManager, GetParameters $appInfo): Response
    {
        $contribution = new Contributions();
        $form = $this->createForm(ContributionsType::class, $contribution);
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
            $currentUser = $this->getUser();
            $date = new \DateTime('@'.strtotime('now'));
            $createdYear = (string)date('Y');
            $createdMonth = (string)date('m');
            $createdby = $this->getUser()->getId();
            $finType = "1";
            $number = rand(1, 90000);
            $tid = "CDP".(string)$number;
            $status = "0";
           
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
            $contribution->setUsers($currentUser);
            $contribution->setPeriod($period);
            $contribution->setAmount($CONTRIB_MONTHLY);
            $contribution->setCreatedby($createdby);
            $contribution->setCreatedAt($date);
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
            if ($amountReste > 0) {
            $this->addFlash('message','Votre contribution a été enregistrée avec succès. La somme de $'.$amountReste.'.00 sera reservée pour le mois prochaine.');
            return $this->redirectToRoute('profil_index');
            } 
            else{
                $this->addFlash('message','Votre contribution a été enregistrée avec succès.');
                return $this->redirectToRoute('profil_index');
                }  
            
        }

        return $this->render('profil/users/contribute.html.twig', [
            'userForm' => $form->createView(),
            'getAppInfo'=> $appInfo->getInfo(),

        ]);
    }

    #[Route('/mycontributions', name: 'mycontributions')]
    public function getMyContributions(ContributionsRepository $myContributions): Response
    {
        return $this->render('profil/users/mycontributions.html.twig', [
            'myContrib' => $myContributions->findAll(),

        ]);
    }

    #[Route('/avatar', name: 'avatar')]
    public function AddAvatar(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(AddAvatarType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
                    
            $uploadedAvatar = $form['avatar']->getData();
            if ($uploadedAvatar)
            {
            $destination = $this->getParameter('avatar_directory');
            $newFilename = md5(uniqid()).'.'.$uploadedAvatar->guessExtension();
            $uploadedAvatar->move($destination,$newFilename);
            $user->setAvatar($newFilename);
            }
            $entityManager->persist($user);
            $entityManager->flush();
            
            $this->addFlash('message','La Photo à été enregistrée.');
            return $this->redirectToRoute('profil_index');
        }

        return $this->render('profil/users/addAvatar.html.twig', [
            'avatarForm' => $form->createView(),
            

        ]);
    }


    
    
}

