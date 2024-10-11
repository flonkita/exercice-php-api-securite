<?php

namespace App\Tests\Security;

use App\Entity\Societe;
use App\Entity\User;
use App\Security\Voter\SocieteVoter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SocieteVoterTest extends KernelTestCase
{
    private $voter;

    protected function setUp(): void
    {
        self::bootKernel();
        // Accède au conteneur depuis KernelTestCase
        $this->voter = self::$kernel->getContainer()->get(SocieteVoter::class); // Utilise Kernel pour obtenir le Voter
    }

    public function testAdminCanManageSociety()
    {
        $user = $this->getUserByEmail('user1@local.host');
        $society = new Societe();
        $token = new UsernamePasswordToken($user, 'credentials', 'memory');

        $this->assertTrue($this->voter->voteOnAttribute(SocieteVoter::MANAGE, $society, $token));
    }

    public function testManagerCanManageSociety()
    {
        $user = $this->getUserByEmail('user2@local.host');
        $society = new Societe();
        $token = new UsernamePasswordToken($user, 'credentials', 'memory');

        $this->assertTrue($this->voter->voteOnAttribute(SocieteVoter::MANAGE, $society, $token));
    }

    public function testConsultantCannotManageSociety()
    {
        $user = $this->getUserByEmail('consultant@local.host');
        $society = new Societe();
        $token = new UsernamePasswordToken($user, 'credentials', 'memory');

        $this->assertFalse($this->voter->voteOnAttribute(SocieteVoter::MANAGE, $society, $token));
    }

    private function getUserByEmail(string $email): User
    {
        // Accès à l'EntityManager via le conteneur
        $entityManager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        return $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    }
}
