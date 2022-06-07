<?php

namespace App\Controller;

use App\Repository\EmployeeRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EmployeeSiteController
 * @package App\Controller
 *
 * @Route(path="/employee")
 */
class EmployeeController
{
    private $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @Route("/add", name="add_employee", methods={"POST"})
     */
    public function addEmployee(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nom = $data['nom'];
        $prenom = $data['prenom'];
        $email = $data['email'];
        $adresse = $data['adresse'];
        $telephone = $data['telephone'];
        $grade = $data['grade'];
        $specialite = $data['specialite'];
        $salaire = $data['salaire'];

        if (empty($nom) || empty($prenom) || empty($email) || empty($telephone) || empty($grade) || empty($specialite) || empty($salaire)  || empty($adresse)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->employeeRepository->saveEmployee($nom, $prenom, $email, $adresse, $telephone, $grade, $specialite, $salaire);

        return new JsonResponse(['status' => 'Employee added!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/get/{id}", name="get_one_employee", methods={"GET"})
     */
    public function getOneEmployee($id): JsonResponse
    {
        $employee = $this->employeeRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $employee->getId(),
            'nom' => $employee->getNom(),
            'prenom' => $employee->getPrenom(),
            'email' => $employee->getEmail(),
            'adresse' => $employee->getAdresse(),
            'telephone' => $employee->getTelephone(),
            'grade' => $employee->getGrade(),
            'specialite' => $employee->getSpecialite(),
            'salaire' => $employee->getSalaire(),
        ];

        return new JsonResponse(['employee' => $data], Response::HTTP_OK);
    }

    /**
     * @Route("/get-all", name="get_all_employees", methods={"GET"})
     */
    public function getAllEmployees(): JsonResponse
    {
        $employees = $this->employeeRepository->findAll();
        //dd($employees);
        $data = [];

        foreach ($employees as $employee) {
            $data[] = [
                'id' => $employee->getId(),
                'nom' => $employee->getNom(),
                'prenom' => $employee->getPrenom(),
                'email' => $employee->getEmail(),
                'adresse' => $employee->getAdresse(),
                'telephone' => $employee->getTelephone(),
                'grade' => $employee->getGrade(),
                'specialite' => $employee->getSpecialite(),
                'salaire' => $employee->getSalaire(),
                ];
        }

        return new JsonResponse(['employees' => $data], Response::HTTP_OK);
    }

    /**
     * @Route("/update/{id}", name="update_employee", methods={"PUT"})
     */
    public function updateEmployee($id, Request $request): JsonResponse
    {
        $employee = $this->employeeRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        $this->employeeRepository->updateEmployee($employee, $data);

        return new JsonResponse(['status' => 'employee updated!']);
    }

    /**
     * @Route("/delete/{id}", name="delete_employee", methods={"DELETE"})
     */
    public function deleteEmployee($id): JsonResponse
    {
        $employee = $this->employeeRepository->findOneBy(['id' => $id]);

        $this->employeeRepository->removeEmployee($employee);

        return new JsonResponse(['status' => 'employee deleted']);
    }
}
