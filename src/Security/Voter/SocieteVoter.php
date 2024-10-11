<?php
namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Societe;
use App\Repository\UserSocieteRepository;

class SocieteVoter extends Voter
{
    const VIEW = 'view';
    const MANAGE = 'manage';
    const ADMIN = 'admin';

    private $userSocieteRepository;

    public function __construct(UserSocieteRepository $userSocieteRepository)
    {
        $this->userSocieteRepository = $userSocieteRepository;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::VIEW, self::MANAGE, self::ADMIN])
            && $subject instanceof Societe;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        $society = $subject;

        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($society, $user);
            case self::MANAGE:
                return $this->canManage($society, $user);
            case self::ADMIN:
                return $this->canAdmin($society, $user);
        }

        return false;
    }

    private function canView(Societe $society, UserInterface $user): bool
    {
        $role = $this->getUserRoleInSociety($user, $society);
        return in_array($role, ['admin', 'manager', 'consultant']);
    }

    private function canManage(Societe $society, UserInterface $user): bool
    {
        $role = $this->getUserRoleInSociety($user, $society);
        return in_array($role, ['admin', 'manager']);
    }

    private function canAdmin(Societe $society, UserInterface $user): bool
    {
        $role = $this->getUserRoleInSociety($user, $society);
        return $role === 'admin';
    }

    private function getUserRoleInSociety(UserInterface $user, Societe $society): ?string
    {
        return $this->userSocieteRepository->findUserRoleInSociety($user, $society);
    }
}