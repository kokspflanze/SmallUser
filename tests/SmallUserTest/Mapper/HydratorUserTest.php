<?php


namespace SmallUserTest\Mapper;


use SmallUser\Entity\User;
use SmallUser\Mapper\HydratorUser;

class HydratorUserTest extends \PHPUnit_Framework_TestCase
{
    public function testExtract()
    {
        $entity = new User();
        $hydrator = new HydratorUser();
        $data = $hydrator->extract($entity);

        $this->assertNotEmpty($data);
    }

    /**
     * @expectedException \ZfcUser\Mapper\Exception\InvalidArgumentException
     */
    public function testExtractException()
    {
        $entity = new \stdClass();
        $hydrator = new HydratorUser();
        $hydrator->extract($entity);
    }

    public function testHydrate()
    {
        $entity = new User();
        $hydrator = new HydratorUser();
        $data = $hydrator->hydrate(array(), $entity);

        $this->assertEquals($entity, $data);
    }

    /**
     * @expectedException \ZfcUser\Mapper\Exception\InvalidArgumentException
     */
    public function testHydrateException()
    {
        $entity = new \stdClass();
        $hydrator = new HydratorUser();
        $hydrator->hydrate(array(), $entity);
    }
}
