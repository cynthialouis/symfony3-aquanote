<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Genus;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    /**
     * @param ObjectManager $manager (= Entity manager)
     */
    public function load(ObjectManager $manager)
    {
        // Use the fixtures.yml file to load random genuses with 'nelmio/alice' library.
        Fixtures::load(
            __DIR__.'/fixtures.yml',
            $manager,
            // Options
            [
                // Array of additional objects that provide formatter functions.
                'providers' => [$this]
            ]
        );
    }

    /**
     * New genus formatter
     */
    public function genus()
    {
        $genera = [
            'Octopus',
            'Balaena',
            'Orcinus',
            'Hippocampus',
            'Asterias',
            'Amphiprion',
            'Carcharodon',
            'Aurelia',
            'Cucumaria',
            'Balistoides',
            'Paralithodes',
            'Chelonia',
            'Trichechus',
            'Eumetopias'
        ];

        $key = array_rand($genera);

        return $genera[$key];
    }

}