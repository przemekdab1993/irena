<?php

namespace App\Factory;

use App\Entity\AppUser;
use App\Repository\UserAppRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<User>
 *
 * @method        AppUser|Proxy create(array|callable $attributes = [])
 * @method static AppUser|Proxy createOne(array $attributes = [])
 * @method static AppUser|Proxy find(object|array|mixed $criteria)
 * @method static AppUser|Proxy findOrCreate(array $attributes)
 * @method static AppUser|Proxy first(string $sortedField = 'id')
 * @method static AppUser|Proxy last(string $sortedField = 'id')
 * @method static AppUser|Proxy random(array $attributes = [])
 * @method static AppUser|Proxy randomOrCreate(array $attributes = [])
 * @method static UserAppRepository|RepositoryProxy repository()
 * @method static AppUser[]|Proxy[] all()
 * @method static AppUser[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static AppUser[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static AppUser[]|Proxy[] findBy(array $attributes)
 * @method static AppUser[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static AppUser[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class AppUserFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    )
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'age' => self::faker()->numberBetween(15, 99),
            'password' => 'password',
            'roles' => [],
            'firstName' => self::faker()->firstName(),
            'lastName' => self::faker()->lastName(),
            'subscribe_to_newsletter' => self::faker()->boolean()
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function(AppUser $user): void {
                $username = strtolower("{$user->getFirstName()[0]}{$user->getLastName()}");

                $user->setEmail("{$username}@gmail.com");
                $user->setUsername($username);
                $user->setPassword($this->passwordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                ));
            })
        ;
    }

    protected static function getClass(): string
    {
        return AppUser::class;
    }
}
