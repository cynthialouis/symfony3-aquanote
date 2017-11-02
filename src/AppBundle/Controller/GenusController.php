<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genus;
use AppBundle\Service\MarkdownTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class GenusController extends Controller
{
    // Put the most generic route at the bottom !
    /**
     * @Route("/genus/new")
     */
    public function newAction()
    {
        $genus = new Genus();
        $genus->setName('Octopus' . rand(1, 100));
        $genus->setSubFamily('Octopodinae');
        $genus->setSpeciesCount(rand(100, 99999));

        // Save to Genus table in db
        $em = $this->getDoctrine()->getManager();
        $em->persist($genus);
        $em->flush();

        // Returns a response object
        return new Response('<html><body>Genus created!</body></html>');
    }

    /**
     * @Route("/genus")
     */
    public function listAction()
    {
        // Get the entity manager
        $em = $this->getDoctrine()->getManager();
        // Create a repository object from the query on the class name (not the table name!)
        // NB : Here, 'AppBundle:Genus' is a shortcut for 'AppBundle/Entity/Genus'
        $genuses = $em->getRepository('AppBundle:Genus')
            ->findAllPublishedOrderedBySize();

        // return a twig template
        return $this->render('genus/list.html.twig', [
            'genuses' => $genuses
        ]);
    }

    /**
     * @Route("/genus/{genusName}", name="genus_show")
     */
    public function showAction($genusName)
    {
        // Fetch the entity manager
        $em = $this->getDoctrine()->getManager();
        // Create a repository object from the query on the class name (not the table name!)
        $genus = $em->getRepository('AppBundle:Genus')
            ->findOneBy(['name' => $genusName]);

        // Handle error if no genus was found
        if (!$genus) {
            // on developer environment :
            //throw $this->createNotFoundException('Not found');

            // on prod environment :
            return $this->render('notfound.html.twig');
        }

        //$transformer = new MarkdownTransformer($this->get('markdown.parser'));
        // Now that the service has been added to the container, it will create that object behind the scenes.
        $transformer = $this->get('app.markdown_tranformer');
        $funFact = $transformer->parse($genus->getFunFact());

        // TODO : Add the caching back later
        /*
        $cache = $this->get('doctrine_cache.providers.my_markdown_cache');
        //Make sure the same string doesn't get parsed twice through markdown.
        $key = md5($funFact);
        if ($cache->contains($key)) {
            $funFact = $cache->fetch($key);
        } else {
            // To fake how slow this could be
            sleep(1);
            $funFact = $this->get('markdown.parser')
                ->transform($funFact);
            $cache->save($key, $funFact);
        }
        */

        return $this->render('genus/show.html.twig', [
            'funFact' => $funFact,
            'genus' => $genus
        ]);
    }

    /**
     * @Route("/genus/{genusName}/notes", name="genus_show_notes")
     * @Method("GET")
     */
    public function getNotesAction()
    {
        $notes = [
            ['id' => 1, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Octopus asked me a riddle, outsmarted me', 'date' => 'Dec. 10, 2015'],
            ['id' => 2, 'username' => 'AquaWeaver', 'avatarUri' => '/images/ryan.jpeg', 'note' => 'I counted 8 legs... as they wrapped around me', 'date' => 'Dec. 1, 2015'],
            ['id' => 3, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Inked!', 'date' => 'Aug. 20, 2015'],
        ];

        $data = [
            'notes' => $notes,
        ];

        return new JsonResponse($data);
    }

}