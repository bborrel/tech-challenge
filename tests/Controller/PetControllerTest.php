<?php

namespace App\Tests\Controller;

use App\Entity\Pet;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PetControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $petRepository;
    private string $path = '/pet/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->petRepository = $this->manager->getRepository(Pet::class);

        foreach ($this->petRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Pet index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'pet[name]' => 'Testing',
            'pet[date_of_birth]' => 'Testing',
            'pet[approximate_age]' => 'Testing',
            'pet[date_of_age_approximation]' => 'Testing',
            'pet[sex]' => 'Testing',
            'pet[type]' => 'Testing',
            'pet[breed]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->petRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Pet();
        $fixture->setName('My Title');
        $fixture->setDate_of_birth('My Title');
        $fixture->setApproximate_age('My Title');
        $fixture->setDate_of_age_approximation('My Title');
        $fixture->setSex('My Title');
        $fixture->setType('My Title');
        $fixture->setBreed('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Pet');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Pet();
        $fixture->setName('Value');
        $fixture->setDate_of_birth('Value');
        $fixture->setApproximate_age('Value');
        $fixture->setDate_of_age_approximation('Value');
        $fixture->setSex('Value');
        $fixture->setType('Value');
        $fixture->setBreed('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'pet[name]' => 'Something New',
            'pet[date_of_birth]' => 'Something New',
            'pet[approximate_age]' => 'Something New',
            'pet[date_of_age_approximation]' => 'Something New',
            'pet[sex]' => 'Something New',
            'pet[type]' => 'Something New',
            'pet[breed]' => 'Something New',
        ]);

        self::assertResponseRedirects('/pet/');

        $fixture = $this->petRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getDate_of_birth());
        self::assertSame('Something New', $fixture[0]->getApproximate_age());
        self::assertSame('Something New', $fixture[0]->getDate_of_age_approximation());
        self::assertSame('Something New', $fixture[0]->getSex());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getBreed());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Pet();
        $fixture->setName('Value');
        $fixture->setDate_of_birth('Value');
        $fixture->setApproximate_age('Value');
        $fixture->setDate_of_age_approximation('Value');
        $fixture->setSex('Value');
        $fixture->setType('Value');
        $fixture->setBreed('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/pet/');
        self::assertSame(0, $this->petRepository->count([]));
    }
}
