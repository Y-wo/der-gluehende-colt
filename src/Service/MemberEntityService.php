<?php

namespace App\Service;

use App\Entity\AttendanceEntity;
use App\Entity\MemberEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class MemberEntityService extends AbstractEntityService
{
    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        parent::__construct($entityManager, $slugger);
    }

    public static $entityFqn = MemberEntity::class;


    public function getAllMembers(
    ) :array
    {
        $queryBuilder = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->select('r')
        ;

        $query = $queryBuilder->getQuery();
        $members = $query->execute();
        return $members;
    }

    public function getMember(
        int $memberId
    ) : array
    {
        $queryBuilder = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->andWhere('r.id = :member_id')
            ->setParameter('member_id', $memberId)
            ->select('r')
        ;

        $query = $queryBuilder->getQuery();
        $member = $query->execute();
        return $member;
    }

    // gets members whose birthday is in the month
    public function getMembersWhoseBirthdayIsComing(){
        $today = new \DateTime();
        $newDateTime = new \DateTime();
        $todayInOneMonth = $newDateTime->modify('+30 days');

        $todaysMonth = $today->format('m');
        $todaysDay = $today->format('d');
        $nextMonth = $todayInOneMonth->format('m');

        $queryBuilder = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->where('
            MONTH(r.birthday) = :todaysMonth AND
            DAY(r.birthday) >= :todaysDay
            ')
            ->orWhere('
            MONTH(r.birthday) = :nextMonth AND
            DAY(r.birthday) <= :todaysDay
            ')
            ->setParameter('todaysMonth', $todaysMonth)
            ->setParameter('todaysDay', $todaysDay)
            ->setParameter('nextMonth', $nextMonth)
            ;

        $query = $queryBuilder->getQuery();

        $members = $query->getResult();

        // sort members by their birthday (only day and month)
        usort(
            $members,
            function (
                $a,
                $b
            ) {
                return $a->getBirthday()->format('md') <=> $b->getBirthday()->format('md') ;
            }
        );

        return $members;
    }

    public function setMemberDeleted(int $id){
        /**@var MemberEntity $member*/
        $member = $this->get($id);
        $member->setDeleted(true);
    }

    public function createRequestMemberAssociativeArray(
        Request $request
    ): array {
        return [
            'firstName' => $request->request->get('firstName'),
            'lastName' => $request->request->get('lastName'),
            'email' => $request->request->get('email'),
            'street' =>$request->get('street'),
            'houseNumber' => $request->request->get('houseNumber'),
            'zip' => $request->request->get('zip'),
            'locus' => $request->request->get('locus'),
            'phone' => $request->request->get('phone'),
            'birthday' => new \DateTime($request->request->get('birthday')),
            'gun' => $request->request->get('gun'),
            'bow' => $request->request->get('bow'),
            'airPressure' => $request->request->get('airPressure'),
            'createdAt' => new \DateTimeImmutable(),
        ];
    }

}