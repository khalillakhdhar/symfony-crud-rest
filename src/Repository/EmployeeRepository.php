<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employee>
 *
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,
    EntityManagerInterface $manager)
    {
        parent::__construct($registry, Employee::class);
        $this->manager = $manager;

    }

    public function saveEmployee($nom, $prenom, $email, $adresse, $telephone, $grade, $specialite, $salaire)
    {
        $newEmployee = new Employee();

        $newEmployee
            ->setNom($nom)
            ->setPrenom($prenom)
            ->setEmail($email)
            ->setTelephone($telephone)
            ->setAdresse($adresse)
            ->setGrade($grade)
            ->setSpecialite($specialite)
            ->setSalaire($salaire);

        $this->manager->persist($newEmployee);
        $this->manager->flush();
    }   

    public function removeEmployee(Employee $employee)
    {
        $this->manager->remove($employee);
        $this->manager->flush();
    }

    public function updateEmployee(Employee $employee, $data)
    {
        empty($data['nom']) ? true : $employee->setNom($data['nom']);
        empty($data['prenom']) ? true : $employee->setPrenom($data['prenom']);
        empty($data['email']) ? true : $employee->setEmail($data['email']);
        empty($data['telephone']) ? true : $employee->setTelephone($data['telephone']);
        empty($data['specialite']) ? true : $employee->setNom($data['specialite']);
        empty($data['grade']) ? true : $employee->setPrenom($data['grade']);
        empty($data['salaire']) ? true : $employee->setEmail($data['salaire']);
        empty($data['adresse']) ? true : $employee->setAdresse($data['adresse']);

        $this->manager->flush();
    }

    

//    /**
//     * @return Employee[] Returns an array of Employee objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Employee
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
