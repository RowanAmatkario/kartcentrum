<?php

namespace App\Controller;

use App\Entity\Activiteit;
use App\Entity\Soortactiviteit;
use App\Form\ActiviteitType;
use App\Form\SoortactiviteitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MedewerkerController
 * @package App\Controller
 * @Route("/admin")
 */
class MedewerkerController extends AbstractController
{
    /**
     * @Route("/activiteiten", name="activiteitenoverzicht")
     */
    public function activiteitenOverzichtAction(): Response
    {
        $activiteiten=$this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->findAll();

        return $this->render('medewerker/activiteiten.html.twig', [
            'activiteiten'=>$activiteiten
        ]);
    }

    /**
     * @Route("/details/{id}", name="details")
     */
    public function detailsAction($id)
    {
        $activiteiten=$this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->findAll();
        $activiteit=$this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->find($id);

        $deelnemers=$this->getDoctrine()
            ->getRepository('App:User')
            ->getDeelnemers($id);


        return $this->render('medewerker/details.html.twig', [
            'activiteit'=>$activiteit,
            'deelnemers'=>$deelnemers,
            'aantal'=>count($activiteiten)
        ]);
    }

    /**
     * @Route("/beheer", name="beheer")
     */
    public function beheerAction()
    {
        $activiteiten=$this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->findAll();

        return $this->render('medewerker/beheer.html.twig', [
            'activiteiten'=>$activiteiten
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function addAction(Request $request)
    {
        // create a user and a contact
        $nieuweActiviteit=new Activiteit();

        $form = $this->createForm(ActiviteitType::class, $nieuweActiviteit);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($nieuweActiviteit);
            $em->flush();

            return $this->redirectToRoute('beheer');
        }
        $activiteiten=$this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->findAll();
        return $this->render('medewerker/add.html.twig',array('form'=>$form->createView()
        ));
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function updateAction($id,Request $request)
    {
        $a=$this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->find($id);

        $form = $this->createForm(ActiviteitType::class, $a);
        $form->add('save', SubmitType::class, array('label'=>"aanpassen"));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the contact (no queries yet)
            $em->persist($a);


            // actually executes the queries (i.e. the INSERT query)
            $em->flush();
            $this->addFlash(
                'notice',
                'activiteit aangepast!'
            );
            return $this->redirectToRoute('beheer');
        }

        $activiteiten=$this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->findAll();

        return $this->render('medewerker/add.html.twig',array('form'=>$form->createView(),'naam'=>'aanpassen','aantal'=>count($activiteiten)));
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $a= $this->getDoctrine()
            ->getRepository('App:Activiteit')->find($id);
        $em->remove($a);
        $em->flush();

        $this->addFlash(
            'notice',
            'activiteit verwijderd!'
        );
        return $this->redirectToRoute('beheer');

    }

    /**
     * @Route("/nieuwSoortActiviteit", name="nieuwSoortActiviteit")
     */
    public function nieuweSoortActiviteitToevoegenAction(Request $request)
    {

        $nieuweActiviteit=new Soortactiviteit();

        $activiteiten=$this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->findAll();

        $form = $this->createForm(SoortactiviteitType::class, $nieuweActiviteit);
        $form->add('save', SubmitType::class, array('label'=>"voeg toe"));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $soortAct = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($soortAct);
            $em->flush();
            return $this->redirectToRoute('kartactiviteiten');
        }
        return $this->render('medewerker/nieuwSA.html.twig',[
            'boodschap'=>'Voeg een nieuwe Activiteit toe',
            'form'=>$form->createView(),
            'activiteiten' => $activiteiten,
        ]);
    }
}
