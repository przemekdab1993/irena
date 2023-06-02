<?php

namespace App\Factory;

use App\Entity\UserApp;
use App\Repository\UserAppRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<User>
 *
 * @method        UserApp|Proxy create(array|callable $attributes = [])
 * @method static UserApp|Proxy createOne(array $attributes = [])
 * @method static UserApp|Proxy find(object|array|mixed $criteria)
 * @method static UserApp|Proxy findOrCreate(array $attributes)
 * @method static UserApp|Proxy first(string $sortedField = 'id')
 * @method static UserApp|Proxy last(string $sortedField = 'id')
 * @method static UserApp|Proxy random(array $attributes = [])
 * @method static UserApp|Proxy randomOrCreate(array $attributes = [])
 * @method static UserAppRepository|RepositoryProxy repository()
 * @method static UserApp[]|Proxy[] all()
 * @method static UserApp[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static UserApp[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static UserApp[]|Proxy[] findBy(array $attributes)
 * @method static UserApp[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static UserApp[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class UserAppFactory extends ModelFactory
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
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function(UserApp $user): void {
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
        return UserApp::class;
    }
}
