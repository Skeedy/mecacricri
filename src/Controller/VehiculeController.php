<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Prestation;
use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\CarburantRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

#[Route('/vehicule')]
class VehiculeController extends AbstractController
{
    #[Route('/', name: 'app_vehicule_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $vehicules = $entityManager
            ->getRepository(Vehicule::class)
            ->findAll();

        return $this->render('vehicule/index.html.twig', [
            'vehicules' => $vehicules,
        ]);
    }
    #[Route('/addVehicule/{id}', name: 'add_vehicule', methods: ['POST'])]
    public function addVehicule(Client $client, EntityManagerInterface $entityManager, Request $request, CarburantRepository $carburantRepository) : Response
    {
        $data = json_decode($request->getContent(),true)[0];
        $newVehicule = new Vehicule();
        $newVehicule->setClient($client);
        $newVehicule->setKilometre($data['kilometre']);
        $newVehicule->setName($data['vehicule']);
        $newVehicule->setImmatriculation($data['immat']);
        $newVehicule->setCarburant($carburantRepository->findOneBy(['id' => $data['carburant']]));
        $entityManager->persist($newVehicule);
        $entityManager->flush();
        return $this->json([
            'success' => true
        ], 200);
    }
    #[Route('/new', name: 'app_vehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vehicule);
            $entityManager->flush();

            return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehicule/new.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehicule_show', methods: ['GET'])]
    public function show(Vehicule $vehicule): Response
    {
        return $this->render('vehicule/show.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vehicule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vehicule $vehicule, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehicule/edit.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehicule_delete', methods: ['POST'])]
    public function delete(Request $request, Vehicule $vehicule, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicule->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vehicule);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/', name: 'add_vehicule_presta', methods: ['POST'])]
    public function addPrestaToVehicule(VehiculeRepository $vehiculeRepository,Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(),true)[0];
        try{
            $vehicule = $vehiculeRepository->findOneBy(['id' => $data['idVehicule']]);
            $newPresta = new Prestation();
            $newPresta->setDescription($data['prestation']);
            $newPresta->setCurrentKilometre($data['kilometre']);
            $newPresta->setNextDate(new \DateTime($data['next_date']));
            $newPresta->setNextKilometre($data['retour_kilometre']);
            $newPresta->setPrix($data['prix']);
            $newPresta->setDate(new \DateTime());
            $newPresta->SetPayed($data['payed']);
            $newPresta->setVehicule($vehicule);
            $entityManager->persist($newPresta);
            $entityManager->flush();
            return $this->json([
                'success' => true
            ], 200
            );
        }catch (\Symfony\Component\Config\Definition\Exception\Exception $exception){
            return $this->json([
                'success' => false,
                'error' => $exception
            ], 400);
        }
    }
}
